<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        // To use site_url and redirect on this controller.
        $this->load->helper('url');
    }

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *        http://example.com/index.php/page
     *    - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/page/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */

    public function index()
    {
//        $this->load->model('facebook_model');
//        $data['fbLogin'] = $this->facebook_model->getLoginUrl();
//        $data['title'] = 'Welcome To MyBookSharing'; // Define the title of the page
//        $this->load->view('header', $data);
        $this->loadHeader('Welcome To MyBookSharing');
//        $pageTitleData['pageTitle'] = "Find Books"; // Define the title used inside the page
//        $pageTitleData['pageTitleDesc'] = "Find Books To Add To Your Bookshelf."; // Define the subtitle
//        $this->load->view('page_title', $pageTitleData); // Load the page title section
        $this->load->view('footer'); // Load the Footer
    }

    public function test()
    {
        $this->load->model('google_model');
        $google_id = 'DHAvBQAAQBAJ';
        $googleBooks = $this->google_model->getBookDetails($google_id);
        echo 'done';
    }

    private function loadHeader($title)
    {
        $this->load->model('login_model');
        $this->load->model('facebook_model');
        $user = $this->login_model->getCurrentUser();

        if ($user != null) {
            $dataHeader['username'] = $user->name;
            $dataHeader['loggedIn'] = true;
        } else {
            $dataHeader['username'] = "login";
            $dataHeader['loggedIn'] = false;
        }
//        if($dataHeader['loggedIn'] == true && $title == "MyBookSharing")
//            redirect(base_url("page/NewsFeed"));
        $dataHeader['fbLogin'] = $this->facebook_model->getLoginUrl();
        $dataHeader['title'] = $title;
        $this->load->view('header', $dataHeader);
        return $dataHeader;
    }

    /**
     * Checks if user is logged in. If so, return true and do nothing else.
     * If not, return false and show user login prompt.
     */
    public function checkIfLoggedIn($loginDetails)
    {
        if (!$loginDetails['loggedIn']) {
            $this->load->view('login', $loginDetails);
            return false;
        }
        return true;
    }

    public function FindBooksPage()
    {
        $dataHeader = $this->loadHeader('Find Books');

        if ($this->checkIfLoggedIn($dataHeader)) {
            $pageTitleData['pageTitle'] = "Find Books";
            $pageTitleData['pageTitleDesc'] = "Find The Books You Care About.";
            $this->load->view('page_title', $pageTitleData);
            $this->load->view('book_search_form');
        }

        $this->load->view('footer');
    }

    public function SearchBook()
    {
        $dataHeader = $this->loadHeader('Find Books');

        if ($this->checkIfLoggedIn($dataHeader)) {
            $this->load->model('google_model'); // Load the Google model
            $this->load->model('book_model'); // Load the book model
            $this->load->model('review_model'); // Load the review model
            $searchTerm = $this->input->post('searchTerm'); // Get the searchTerm the user used
            $pageNumber = $this->input->post('pageNumber'); // Get the pageNumber the user selected
            if (!isset($searchTerm) || !isset($pageNumber)) // Shouldn't happen, but might with user's client side edits
            {
                $this->load->view('no_books_found');
                $this->load->view('footer'); // Load the Footer
                return;
            }
            $pageTitleData['pageTitle'] = "Find Books"; // Define the title used inside the page
            $pageTitleData['pageTitleDesc'] = "Find Books To Add To Your Bookshelf."; // Define the subtitle
            $this->load->view('page_title', $pageTitleData); // Load the page title section
            $data['searchTerm'] = $searchTerm; // Save the search term for use in the page
            $this->load->view('book_search_form', $data); // Load the search form
            $data['searchResults'] = $this->google_model->searchBook($searchTerm, $pageNumber); // Get the books that match the search term from Google Books
            $data['searchResults'] = $this->book_model->addIdsToBooks($data['searchResults']); // Add ids if we have the books in the DB
            $data['searchResults'] = $this->review_model->getMassReviews($data['searchResults']); // Add reviews if we have the books in the DB
            if (isset($data['searchResults'])) {
                $this->load->view('book_search_results', $data); // Load the search results section and have it populated by the results from Google
            } else {
                $this->load->view('no_books_found');
            }
        }
        $this->load->view('footer'); // Load the Footer
    }

    public function myBookshelf()
    {
        $dataHeader = $this->loadHeader('My Bookshelf');

        if ($this->checkIfLoggedIn($dataHeader)) {
            $this->load->model('login_model');
            $this->load->model('book_model');
            $this->load->model('review_model');

            $user = $this->login_model->getCurrentUser();
            if ($user != null) {
                $data['books'] = $this->book_model->getUserBooks($user->id);
                $data['books'] = $this->review_model->getMassReviews($data['books']); // Add reviews if we have the books in the DB
                $pageTitleData['pageTitle'] = "My Bookshelf"; // Define the title used inside the page
                $pageTitleData['pageTitleDesc'] = "Manage The Books You Own And Wish To Share."; // Define the subtitle
                $this->load->view('page_title', $pageTitleData); // Load the page title section
                $this->load->view('my_bookshelf_books', $data);
            }
        }
        $this->load->view('footer');
    }

    public function bookManagement()
    {
        $dataHeader = $this->loadHeader('Book Management');

        if ($this->checkIfLoggedIn($dataHeader)) {
            // User Id is the user who got the book.
            // Friend Id is the user who gave the book.
            $this->load->model('login_model');
            $this->load->model('loan_model');

            $user = $this->login_model->getCurrentUser();
            if ($user != null) {
                $data['loansToMe'] = $this->loan_model->getLoansTo($user->id);
                $data['loansFromMe'] = $this->loan_model->getLoansFrom($user->id);
                $this->load->view('loans', $data);
            }
        }
        $this->load->view('footer');
    }

    public function newsfeed()
    {
        $dataHeader = $this->loadHeader('News Feed');

        if ($this->checkIfLoggedIn($dataHeader)) {
            $this->load->model('login_model');
            $this->load->model('newsfeed_model');

            $user = $this->login_model->getCurrentUser();
            if ($user != null) {
                $data['result'] = $this->newsfeed_model->getNewsFeedBooks($user->id);
                $this->load->view('newsfeed', $data);
            }
        }
        $this->load->view('footer');
    }

    public function book($bookId)
    {
        $this->load->model('book_model');
        $this->load->model('login_model');
        $this->load->model('review_model');

        $data['book'] = $this->book_model->getBook($bookId);
//        $friendsData['friends'] = $this->book_model->getOwners($data['book']->id);
//        $friendsData['bookId'] = $data['book']->google_id;
        $user = $this->login_model->getCurrentUser();
        $data['isOwnedByCurrentUser'] = $user != null && $this->book_model->isOwnedby($bookId, $user->id);
        $data['reviews'] = $this->review_model->getReviews($bookId);

        $this->loadHeader($data['book']->name);
        $this->load->view('book_info', $data);
//        $this->load->view('friends', $friendsData);
        $this->load->view('footer');
    }

    public function login()
    {
//        $data["title"] = "This is the title";
//        $this->load->helper('url');
//        $this->load->model('facebook_model');
//        $data['fbLogin'] = $this->facebook_model->getLoginUrl();
//        $this->load->view('welcome_message', $data);

        $this->load->library('facebook'); // Automatically picks appId and secret from config

        $user = $this->facebook->getUser();

        if ($user) {
            try {
                $data['user_profile'] = $this->facebook->api('/me');
            } catch (FacebookApiException $e) {
                $user = null;
            }
        } else {
            // Solves first time login issue. (Issue: #10)
            //$this->facebook->destroySession();
        }

        if ($user) {

            $data['logout_url'] = site_url('page/logout'); // Logs off application
            // OR
            // Logs off FB!
            // $data['logout_url'] = $this->facebook->getLogoutUrl();

        } else {
            $data['login_url'] = $this->facebook->getLoginUrl(array(
                'redirect_uri' => site_url('page/login'),
                'scope' => array("email") // permissions here
            ));
        }
        $this->load->view('login', $data);
    }

    public function logout()
    {

        $this->load->library('facebook');

        // Logs off session from website
        $this->facebook->destroySession();
        // Make sure you destory website session as well.

        redirect('page/login');
    }

}