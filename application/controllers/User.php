<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *        http://example.com/index.php/user
     *    - or -
     * Any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */

    public function test()
    {
        $data['title'] = "My Bookshelf";
        $this->load->view('header', $data);
        $this->load->view('my_bookshelf', $data);
        $this->load->view('footer', $data);
    }

    function logout()
    {
        $this->facebook_model->logout();
        $this->user_model->set_session(0, "logout");
        redirect('/');
    }
}