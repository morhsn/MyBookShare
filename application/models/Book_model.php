<?php

class book_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }


    function getBook($id)
    {
        $books = $this->db->query('SELECT * FROM book WHERE id = ' . $id)->result();
        if ($books != null)
            return $books[0];
        return null;
    }

    function getBookByGoogleId($googleBookId)
    {
        $books = $this->db->query('SELECT * FROM book WHERE google_id="' . $googleBookId . '"')->result();
        if ($books != null)
            return $books[0];
        return null;
    }

    public function getUserBooks($userId)
    {
        $queryStr = 'SELECT * FROM book WHERE id IN (SELECT book_id from users_owned_books WHERE user_id=' . $userId . ');';
        $query = $this->db->query($queryStr);
        return $query->result();
    }


    function runQuery($queryStr)
    {
        try {
            $this->db->query($queryStr);
        } catch (Exception  $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }

    function getOwners($bookId)
    {
        if ($bookId == null)
            return null;
        $queryStr = 'SELECT * FROM user WHERE id IN (SELECT user_id FROM users_owned_books WHERE book_id=' . $bookId . ');';
        $query = $this->db->query($queryStr);
        return $query->result();
    }

    function addBook($google_id)
    {
        $book = $this->getBookByGoogleId($google_id);
        if ($book == null) { // The book is not in the database yet
            $googleBook = $this->google_model->getBookDetails($google_id);

            $row = array(
                "google_id" => $google_id,
                "name" => $googleBook['name'],
                "author" => $googleBook['author'],
                "isbn" => $googleBook['isbn']
            );
            $this->db->insert('book', $row);
            // maybe the id that will return is different
            $book = $this->getBookByGoogleId($google_id);
        }
        return $book->id;
    }

    function addBookToUser($userId, $bookId)
    {
        $own = $this->db->query('SELECT * FROM users_owned_books WHERE user_id=' . $userId . ' AND book_id=' . $bookId)->result();
        if ($own == null)
            $this->runQuery('INSERT INTO users_owned_books (user_id, book_id, added_date, status) VALUES ("' . $userId . '", "' . $bookId . '", "' . date('Y-m-d') . '", 0);');
    }

    function removeBookFromUser($userId, $bookId)
    {
        $this->db->query('DELETE FROM users_owned_books WHERE user_id=' . $userId . ' AND book_id=' . $bookId);
    }

    function addBookFromGoogle($googleBookId)
    {
        $this->load->model('google_model');

        $book = $this->getBookByGoogleId($googleBookId);
        if ($book == null) {
            $googleBook = $this->google_model->getBookDetails($googleBookId);
            if ($googleBook == null) {
                print_r("Book not found");
                return null;
            }
            // maybe the id that will return is different
            $book = $this->getBookByGoogleId($googleBook['google_id']);
            if ($book == null) {
                $this->addBook($googleBook['google_id'], $googleBook['name'], $googleBook['author'], $googleBook['isbn']);
                $book = $this->getBookByGoogleId($googleBook['google_id']);
            }
        }
        return $book->id;
    }

    function addBookToUserByGoogleId($userId, $googleBookId)
    {
        $bookId = $this->addBookFromGoogle($googleBookId);
        if ($bookId == null)
            return;
        $this->addBookToUser($userId, $bookId);
    }


    function isOwnedby($bookId, $userId)
    {
        $owns = $this->db->query('SELECT * FROM users_owned_books WHERE user_id="' . $userId . '" AND book_id="' . $bookId . '"')->result();
        return (count($owns) > 0);
    }

    function deleteBook($id)
    {
        $this->runQuery('DELETE FROM book WHERE id=' . $id);
        $this->runQuery('DELETE FROM user WHERE id="' . $id . '"');
    }

}