<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Shanghai');
/**
 *  * User Class
 *   *
 *    * @author QiangRunwei <qiangrw@gmail.com>
 *     * @version   1.0
 *      */
class User extends CI_Controller {
    function __constructor() 
    {
        parent::__constructor();
    }

    // Page: login
    public function login()
    {
        $data['title'] = 'Login';
        @ob_clean();
        $this->load->view('inc/header',$data);
        $this->load->view('user/login');
        $this->load->view('inc/footer');
    }
     
    // Page: Signup
    public function signup()
    {
        $data['title'] = 'Signup';
        @ob_clean();
        $this->load->view('inc/header',$data);
        $this->load->view('user/signup');
        $this->load->view('inc/footer');
    }
    



}

/* End of file user.php */
/* Location: ./application/controllers/user.php */
