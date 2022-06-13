<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class MY_Controller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        if (!$this->session->userdata('session_login')) {
            redirect('login');
        }else{
            $this->session_login = $this->session->userdata('session_login');
        }
    }
}
