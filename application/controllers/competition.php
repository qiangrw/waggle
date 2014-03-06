<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Shanghai');

/**
 *   Competition Class
 *  
 *   @author QiangRunwei <qiangrw@gmail.com>
 *   @version   1.0
 */
class Competition extends CI_Controller {
    function __constructor() 
    {
        parent::__constructor();
    }


    // Page: competition list
    function index()
    {
        $data['title'] = '竞赛列表';
        $data['competitions'] = $this->Competition_model->gets();
        @ob_clean();
        $this->load->view('inc/header',$data);
        $this->load->view('competition/index');
        $this->load->view('inc/footer');

    }

    function commit($cid)
    {
        if($this->User_model->check_user_login() <= 0){ 
            redirect("user/login?url=competition/commit/$cid",'refresh');
            return;
        }
        $competition = $this->Competition_model->get($cid);
        if(!$competition) show_404();

        $sid = $this->session->userdata('sid');
        $counter = $this->Counter_model->get_by_cid($cid, $sid);
        // create one if not exist
        if(!$counter) {
            $count = 10;
            $counter_array = array(
                'cid' => $cid,
                'sid' => $sid,
                'count' => $count
                );
            $this->Counter_model->insert($counter_array);
        } else {
            $count = $counter->count;
        }

        @ob_clean();
        $data['sid'] =  $sid;
        $data['cid'] =  $cid;
        $data['count'] =  $count;
        $data['competition'] = $competition;
        $this->load->view('inc/header',$data);
        $this->load->view('competition/commit');
        $this->load->view('inc/footer');
    }


    // Interface: submit commit
    function submit_commit($cid)
    {
        if($this->User_model->check_user_login() <= 0){ 
            redirect("user/login?url=competition/commit/$cid",'refresh');
            return;
        }
        $competition = $this->Competition_model->get($cid);
        if(!$competition) show_404();

        $sid = $this->session->userdata('sid');
        $counter = $this->Counter_model->get_by_cid($cid, $sid);  
        if(!$counter || $counter->count <= 0) {
            $data['title'] = '错误';
            $data['note'] = '您已超过提交次数';
            $this->load->view('inc/header',$data);
            $this->load->view('inc/note');
            $this->load->view('inc/footer');
        }
        
        $config = array(
            array(
                'field'   => 'runtag',
                'label'   => 'Runtag',
                'rules'   => 'required|max_length[40]|alpha_numeric|xss_clean'
            ),   
            array(
                'field'   => 'message',
                'label'   => 'Message',
                'rules'   => 'max_length[40]|xss_clean'
            ),   
            array(
                'field'   => 'vcode',
                'label'   => 'Vcode',
                'rules'   => 'required|alpha_numeric|xss_clean'
            )
        );
        $this->form_validation->set_rules($config);
        $data = array();
        if ($this->form_validation->run() == FALSE) {
            $this->commit($cid);
        } else {
            $file_name = $sid.'_'.$cid.'_'.time().".txt";
            $config['upload_path'] = "uploads/commit/$cid";
            $config['allowed_types'] = 'txt|res';
            $config['max_size'] = '10000';
            $config['file_name'] = $file_name;
            $this->load->library('upload', $config);

            if ( !$this->upload->do_upload()) {
                $data['title'] = '错误';
                $data['note'] = $this->upload->display_errors();
            } 
            else {
                $data = array('upload_data' => $this->upload->data());

                // compute score of the file
                $this->load->helper('file');
                $file_content = read_file($config['upload_path']."/".$file_name);
                $score = $this->Commit_model->compute_score($cid, $file_content);
                if($score != NULL) {
                    $commit_array = array(
                        'sid' => $sid,
                        'cid' => $cid,
                        'file_name' => $file_name,
                        'runtag' => $this->input->get_post('runtag'),
                        'message' => $this->input->get_post('message')
                    );
                    $this->Commit_model->insert($commit_array);
                    // update counter 
                    //$counter_update = array('count' => $counter->count -1);
                    //$this->Counter_model->update($counter->id, $counter_update);

                    $data['title'] = '提交成功';
                    $data['note'] = '提交成功';
                } else {
                    $data['title'] = '计算分数失败';
                    $data['note'] = '计算得分失败，请确保结果文件格式正确.';
                }
            }
            $this->load->view('inc/header',$data);
            $this->load->view('inc/note');
            $this->load->view('inc/footer');

        }
    }


}

/* End of file competition.php */
/* Location: ./application/controllers/competition.php */
