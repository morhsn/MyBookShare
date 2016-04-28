<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax_controller extends CI_Controller
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
            $debug = array(
                'debug-text' => 'Still good 3'
            );
            $this->db->insert('debug', $debug);
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
}