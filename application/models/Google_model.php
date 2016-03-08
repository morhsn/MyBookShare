<?php

class google_model extends CI_Model
{

    /*
     * Example of return object:
     * stdClass Object ( [GsearchResultClass] => GbookSearch [unescapedUrl] => http://books.google.com/books?id=TShokNWOGy8C&printsec=frontcover&dq=the+house+of+god&num=8&client=internal-uds&cd=1&source=uds [url] => http://books.google.com/books%3Fid%3DTShokNWOGy8C%26printsec%3Dfrontcover%26dq%3Dthe%2Bhouse%2Bof%2Bgod%26num%3D8%26client%3Dinternal-uds%26cd%3D1%26source%3duds [title] => The House of God [titleNoFormatting] => The House of God [authors] => Samuel Shem [bookId] => ISBN1101460881 [publishedYear] => 2010 [tbUrl] => http://bks5.books.google.com/books?id=TShokNWOGy8C&printsec=frontcover&img=1&zoom=5&edge=curl [tbHeight] => 80 [tbWidth] => 60 [pageCount] => 400 )
     */
    public function getBookDetails($googleBookId)
    {
        $this->load->library('google');

        $googleBooks = $this->google->books($googleBookId, array('id' => $googleBookId))->results;
        //print_r($googleBooks);
        if ($googleBooks == null || count($googleBooks) == 0)
            return null;
        $google_id = $googleBooks[0]->unescapedUrl;
        $start = strpos($google_id, '?id=') + 4;
        $google_id = substr($google_id, $start, strpos($google_id, '&') - $start);
        $book = array(
            "google_id" => $google_id,
            "name" => $googleBooks[0]->title,
            "author" => $googleBooks[0]->authors,
            "publishedYear" => $googleBooks[0]->publishedYear,
            "isbn" => $googleBooks[0]->bookId
        );
        return $book;
    }

    public function searchBook($searchTerm, $pageNumber)
    {
        $this->load->library('google');
        echo $pageNumber . '<br />';
        $indexNumber = ($pageNumber - 1) * 8; // Index starts with 0 and page numbers start with 1
        echo $indexNumber;
        $params = array('start' => $indexNumber); // Define the start index of the search
        $searchOutput = $this->google->books($searchTerm, $params);
        $googleBooks = $searchOutput->results;
        if (!empty($googleBooks)) {
            echo "NOT EMPTY";
            $maxPage = end($searchOutput->cursor->pages)->label; // The amount of pages in the result
            reset($searchOutput->cursor->pages); // Reset the change of pointers done by the "end" function
            if ($googleBooks == null || count($googleBooks) == 0)
                return null;
            $searchResults = array(count($googleBooks));
            foreach ($googleBooks as $googleBook) {
                $google_id = $googleBook->unescapedUrl;
                $start = strpos($google_id, '?id=') + 4;
                $google_id = substr($google_id, $start, strpos($google_id, '&') - $start);
                $book = array(
                    "google_id" => $google_id,
                    "name" => $googleBook->title,
                    "author" => $googleBook->authors,
                    "publishedYear" => $googleBook->publishedYear,
                    "isbn" => $googleBook->bookId
                );
                array_push($searchResults, $book);
            }
            $metaData = array(
                "pageCount" => $maxPage,
                "currentPage" => $searchOutput->cursor->currentPageIndex,
                "moreResultsUrl " => $searchOutput->cursor->moreResultsUrl
            );
            array_push($searchResults, $metaData);
        }
        return (isset($searchResults) ? $searchResults : null);
    }

}