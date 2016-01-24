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
        $this->findBooksPage();
    }

    public function findBooksPage()
    {
        $data['title'] = "Find Books";
        $this->load->view('header', $data);
        $pageTitleData['pageTitle'] = "Find Books";
        $pageTitleData['pageTitleDesc'] = "Find Books To Add To Your Bookshelf.";
        $this->load->view('page_title', $pageTitleData);
        $this->load->view('book_search_form');
        $this->load->view('no_books_found');
//        $this->load->view('my_bookshelf', $data);
        $this->load->view('footer', $data);
    }

    public function searchBook()
    {
        $this->load->model('google_model'); // Load the Google model
        $searchTerm = $this->input->post('searchTerm'); // Get the searchTerm the user used
        $data['title'] = "Find Books"; // Define the title of the page
        $this->load->view('header', $data); // Load the header
        $pageTitleData['pageTitle'] = "Find Books"; // Define the title used inside the page
        $pageTitleData['pageTitleDesc'] = "Find Books To Add To Your Bookshelf."; // Define the subtitle
        $this->load->view('page_title', $pageTitleData); // Load the page title section
        $this->load->view('book_search_form'); // Load the search form
        $data['searchResults'] = $this->google_model->searchBook($searchTerm); // Get the books that match the search term from Google Books
        $this->load->view('book_search_results', $data); // Load the search results section and have it populated by the results from Google
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