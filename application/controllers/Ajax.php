<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends CI_Controller
{

// This function call from AJAX
    public function addBook()
    {
        $retData = array();

        $this->load->model('login_model');
        $this->load->model('book_model');
        $this->load->model('google_model');


        $user = $this->login_model->getCurrentUser();
        if ($user != null) {
            $userId = $user->id;
            $google_id = $this->input->post('google_id');
            $bookId = $this->book_model->addBook($google_id);
            if ($bookId != null) {
                $this->book_model->addBookToUser($userId, $bookId);
                $retData = array(
                    'success' => 'true'
                );
            }
        }

        //Either you can print value or you can send value to database
        echo json_encode($retData);
        return json_encode($retData);
    }

    // This function call from AJAX
    public function removeBook()
    {
        $retData = array();


        $this->load->model('login_model');
        $this->load->model('book_model');
        $this->load->model('google_model');


        $user = $this->login_model->getCurrentUser();
        if ($user != null) {
            $userId = $user->id;
            $google_id = $this->input->post('google_id');
            $debug = array(
                'debug-text' => 'Got to function call in Remove.'
            );
            $this->db->insert('debug', $debug);
            $bookByGoogleId = $this->book_model->getBookByGoogleId($google_id);
            $bookId = $bookByGoogleId->id;
            $this->book_model->removeBookFromUser($userId, $bookId);
            $retData = array(
                'success' => 'true'
            );
        }

        //Either you can print value or you can send value to database
        echo json_encode($retData);
        return json_encode($retData);
    }
}