<?php
/**
 * User Model Class
 *
 * @author QiangRunwei <qiangrw@gmail.com>
 * @version	1.0
 */
 
class User_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

	/**
	 * User::insert()
	 * 
	 * @param array $data
	 * @return
	 */
	function insert($data)
    {
        $data['create_time'] = time();
		$this->db->flush_cache();
		$this->db->insert('wa_user', $data);
		return TRUE;
    }

	
	/**
	 * generate user's confirm code 
	 * @return string code
	 */ 
	function generate_password(){
		 $code = $this->get_random_word(6,12);
		 return $code;
	}

    /**
     * get user's info by sid
     * @param int sid
     * @return mixed $info
     */
	function get($sid)
	{
        $this->db->flush_cache();
        $this->db->where('sid', $sid);
        $query = $this->db->get_where('wa_user');
        return $query->row();
	}
         
    /**
     * check whether user has login the site
     * @return int $sid
     */ 
    function check_user_login() 
    {
   	 	if(!$this->session->userdata('sid')) {
   	 		return 0;
		} else {
			return $this->session->userdata('sid');
		}
    }
    
	 /**
	  * check whether email and password matches then set session
	  * @param string $sid
	  * @param string $password
	  * @return int
	  */ 
	 function check_user_password($sid,$password) 
	 {
	 	$this->db->flush_cache();
		$data = array('sid' => $sid,'password'=>$password,'status' => 2);
	 	$sel_query = $this->db->get_where('wa_user',$data);
		if ($sel_query->num_rows() > 0) {
            $row = $sel_query->row();
            $this->session->set_userdata('sid',$row->sid);
            $this->session->set_userdata('name',$row->name);
            return $row->sid; 
        } else {
            return 0;	// not match
        }
     }


    /**
     * user logout the site
     * @return bool
     */
    function logout()
    {
        $this->session->unset_userdata('sid');
        $this->session->unset_userdata('name');
        $this->session->sess_destroy();
    }


    /**
     * The function to grab a random word from dictionary between the two length 
     * @param integer $min_length
     * @param integer $max_length
     * @ignore
     */
    function get_random_word($min_length, $max_length)
    {
        $len = ($min_length + $max_length) / 2;
        $chars = array(
            "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k",  
            "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v",  
            "w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G",  
            "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R",  
            "S", "T", "U", "V", "W", "X", "Y", "Z", "0", "1", "2",  
            "3", "4", "5", "6", "7", "8", "9"
        );
        $charsLen = count($chars) - 1; 
        shuffle($chars);    // 将数组打乱 
        $output = ""; 
        for ($i=0; $i<$len; $i++) { 
            $output .= $chars[mt_rand(0, $charsLen)]; 
        }
        return $output;
    }


    /**
     * send mail to user
     * @param string email
     * @param string subject
     * @param string message
     */ 
    function send_mail($email,$subject,$message)
    {
        $this->load->library('email');
        $this->email->from('qiangrw@xxx.com', '强闰伟');
        $this->email->to($email);
        $this->email->subject($subject);
        $this->email->message($message); 
        $this->email->send();
    }
}
/* End of file user_model.php */
/* Location: ./application/model/user_model.php */
