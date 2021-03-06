<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Shanghai');
/**
 *   User Class
 *  
 *   @author QiangRunwei <qiangrw@gmail.com>
 *   @version   1.0
 */
class User extends CI_Controller {
    function __constructor() 
    {
        parent::__constructor();
    }

    // Page: login
    public function login()
    {
        $url = $this->input->get('url');
        if(!$url || $url == '') $url = 'competition';
        $data['url'] = $url;
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


    // Interface: submit login
    public function submit_login()
    {
        $config = array(
            array(
                'field'   => 'sid', 
                'label'   => 'Student ID', 
                'rules'   => 'trim|required|integer|min_lenght[10]|max_length[10]|xss_clean'
            ),
            array(
                'field'   => 'password',
                'label'   => 'Password',
                'rules'   => 'required|max_length[40]|callback_password_check|xss_clean'
            )
        );
        $this->form_validation->set_rules($config);
        $data = array();
        if ($this->form_validation->run() == FALSE) {
            $this->login();
        } else {
            $url = $this->input->get_post('url');
            if(!$url || $url == '') $url = 'welcome';
            redirect($url, 'refresh');
            return;
        }
    }

    // Form Check: vcode
    public function vcode_check()
    {
        if(strtolower($this->input->post('vcode')) !=
            strtolower($this->session->userdata('vcode'))) {
                $this->form_validation->set_message('vcode_check', "Vcode is wrong");
                return FALSE;
            }
        return TRUE;
    }

    // Form Check: password
    function password_check()
    {
        $sid = $this->input->post('sid');
        $password = $this->input->post('password');
        if($this->User_model->check_user_login() >0 ) {
            $this->form_validation->set_message('password_check', "You have logged.");
            return FALSE;
        } else {
            $uid = $this->User_model->check_user_password($sid,$password);
            if($uid == 0) {
                $this->form_validation->set_message('password_check', "Password Wrong.");
                return FALSE;
            } else {
                return TRUE;
            }
        }
    }


    // Interface: submit login
    public function submit_signup()
    {
        if($this->User_model->check_user_login() > 0) {
            $data['title'] = '注意';
            $data['note'] = '请先注销后再尝试该操作.';
            $this->load->view('inc/header',$data);
            $this->load->view('user/note');
            $this->load->view('inc/footer');
            return;
        }
        $config = array(
            array(
                'field'   => 'sid', 
                'label'   => 'Student ID', 
                'rules'   => 'trim|required|integer|min_lenght[10]|max_length[10]|xss_clean|is_unique[wa_user.sid]'
            ),
            array(
                'field'   => 'vcode',
                'label'   => 'Vcode',
                'rules'   => 'required|alpha_numeric|callback_vcode_check|xss_clean'
            )
        );
        $this->form_validation->set_rules($config);
        $data = array();
        if ($this->form_validation->run() == FALSE) {
            $this->signup();
        } else {
            $password = $this->User_model->generate_password();
            $user = array(
                'sid' => $this->input->post('sid'), 
                'password' => $password
            );
            $this->User_model->insert($user);
            //$this->User_model->send_password($user['sid'], $user['password']);
            $this->load->library('email');
            $email = $user['sid'] . "@pku.edu.cn";
            $subject = "Waggle Password";
            $message = "Your Password is: ". $password;
            if(!$this->User_model->send_mail($email, $subject, $message)) {
                $data['title'] = 'SendMail Error';
                $data['note'] = $this->email->print_debugger();
                $this->load->view('inc/header',$data);
                $this->load->view('inc/note');
                $this->load->view('inc/footer');
                return;
            }

            $data['title'] = 'SignUp Succ';
            $data['flash_message'] = 'Signup Succ, Please get your password in your PKU mail (or Junk Mail).';
            @ob_clean();
            $this->load->view('inc/header',$data);
            $this->load->view('user/login');
            $this->load->view('inc/footer');
        }
    }

    public function logout()
    {
        $this->User_model->logout();
        redirect('user/login/', 'refresh');
    }
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */
