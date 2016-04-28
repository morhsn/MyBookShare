<?php

class login_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function getCurrentUser()
    {
        $this->load->model('facebook_model');
        $this->load->model('user_model');

        // get facebook id
        $facebookId = $this->facebook_model->getFacebookId();
        if ($facebookId != 0) {
            $user = $this->user_model->getUserByFacebookId($facebookId);
            $this->user_model->updateFriends($user);
        } else
            return null;
        //$user = $this->user_model->getFakeUser();
        // if is new user, insert to DB
        if ($user == null) {
            $fbuser = $this->facebook_model->getBasicInfo();
            $this->user_model->insertUser($fbuser);
            $this->user_model->updateFriends($user);
            $user = $this->user_model->getUserByFacebookId($facebookId);
        }

        return $user;
    }

}