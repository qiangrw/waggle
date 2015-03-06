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
        $data['title'] = 'Competition List';
        $data['competitions'] = $this->Competition_model->gets();
        @ob_clean();
        $this->load->view('inc/header',$data);
        $this->load->view('competition/index');
        $this->load->view('inc/footer');

    }

    // Page: Rank list
    function rank($cid)
    {
        $data['title'] = 'Rank';
        $data['competition'] = $this->Competition_model->get($cid);
        if(!$data['competition']) show_404();
        $data['commits'] = $this->Commit_model->get_rank($cid, 200);
        @ob_clean();
        $this->load->view('inc/header',$data);
        $this->load->view('competition/rank');
        $this->load->view('inc/duoshuo');
        $this->load->view('inc/footer');
    }

    // Page: Commit a file
    function commit($cid=0)
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
    function submit_commit($cid=0)
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
            )   
        );
        $this->form_validation->set_rules($config);
        $data = array();
        if ($this->form_validation->run() == FALSE) {
            echo validation_errors();
            return;
            $this->commit($cid);
        } else {

            $file_name = $sid.'_'.$cid.'_'.time()."_".$this->User_model->generate_password().".txt";
            $config['upload_path'] = "uploads/commit/$cid";
            $config['allowed_types'] = 'txt|res';
            $config['max_size'] = '200000000';
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
				$ans_content = read_file($competition->answer_file);
                
                if($cid == 1) {
                    $score = $this->Commit_model->compute_fvalue($file_content, $ans_content);
				}
                if($cid == 2)  {
                    $score = $this->Commit_model->compute_score($file_content, $ans_content);
				}

                if($score != NULL) {
                    $commit_array = array(
                        'sid' => $sid,
                        'cid' => $cid,
                        'file_name' => $file_name,
                        'runtag' => $this->input->get_post('runtag'),
                        'message' => $this->input->get_post('message'),
                        'score' => $score
                    );
                    $this->Commit_model->insert($commit_array);
                    // update counter 
                    $counter_update = array('count' => $counter->count -1);
                    $this->Counter_model->update($counter->id, $counter_update);

                    $data['title'] = 'Commit Succ';
                    $data['note'] = 'Commit Succ';
                    redirect('competition/rank/'.$cid, 'refresh');
                } else {
                    $data['title'] = 'Compute Score Error';
                    $data['note'] = 'Please confirm that your file format is right.';
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
