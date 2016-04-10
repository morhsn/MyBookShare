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
        $this->load->model('facebook_model');
        $data['fbLogin'] = $this->facebook_model->getLoginUrl();
//        $data['title'] = 'Welcome To MyBookSharing'; // Define the title of the page
//        $this->load->view('header', $data);
        $this->loadHeader('Welcome To MyBookSharing');
//        $pageTitleData['pageTitle'] = "Find Books"; // Define the title used inside the page
//        $pageTitleData['pageTitleDesc'] = "Find Books To Add To Your Bookshelf."; // Define the subtitle
//        $this->load->view('page_title', $pageTitleData); // Load the page title section
        $this->load->view('footer'); // Load the Footer
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
    }

    public function FindBooksPage()
    {
        $this->load->model('facebook_model');
        $data['fbLogin'] = $this->facebook_model->getLoginUrl();
        $this->loadHeader('Find Books');
        $pageTitleData['pageTitle'] = "Find Books";
        $pageTitleData['pageTitleDesc'] = "Find The Books You care about.";
        $this->load->view('page_title', $pageTitleData);
        $this->load->view('book_search_form');
//        $this->load->view('no_books_found');
//        $this->load->view('my_bookshelf', $data);
        $this->load->view('footer', $data);
    }

    public function SearchBook()
    {
        $this->load->model('facebook_model');
        $data['fbLogin'] = $this->facebook_model->getLoginUrl();
        $this->load->model('google_model'); // Load the Google model
        $searchTerm = $this->input->post('searchTerm'); // Get the searchTerm the user used
        $pageNumber = $this->input->post('pageNumber'); // Get the pageNumber the user selected
        if (!isset($searchTerm) || !isset($pageNumber)) // Shouldn't happen, but might with user's client edits
        {
            $this->findBooksPage();
            return;
        }
        $data['title'] = "Find Books"; // Define the title of the page
        $this->load->view('header', $data); // Load the header
        $pageTitleData['pageTitle'] = "Find Books"; // Define the title used inside the page
        $pageTitleData['pageTitleDesc'] = "Find Books To Add To Your Bookshelf."; // Define the subtitle
        $this->load->view('page_title', $pageTitleData); // Load the page title section
        $data['searchTerm'] = $searchTerm; // Save the search term for use in the page
        $this->load->view('book_search_form', $data); // Load the search form
        $data['searchResults'] = $this->google_model->searchBook($searchTerm, $pageNumber); // Get the books that match the search term from Google Books
        if (isset($data['searchResults'])) {
            $this->load->view('book_search_results', $data); // Load the search results section and have it populated by the results from Google
        } else {
            $this->load->view('no_books_found');
        }
        $this->load->view('footer', $data); // Load the Footer
    }

    public function myBookshelf()
    {
        $this->load->model('google_model');
        $searchTerm = "Arts";
//        $this->loadHeader("Search Results");
        $data['title'] = "My Bookshelf";
        $this->load->view('header', $data);
        $pageTitleData['pageTitle'] = "My Bookshelf";
        $pageTitleData['pageTitleDesc'] = "The Books You Own.";
        $this->load->view('page_title', $pageTitleData);
//        $this->load->view('book_search_form');
        $data['searchResults'] = $this->google_model->searchBook($searchTerm);
//        Next line is fake just to create results for prototype
        $this->load->view('my_bookshelf_results', $data);
//        $this->load->view('my_bookshelf', $data);
        $this->load->view('footer', $data);
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