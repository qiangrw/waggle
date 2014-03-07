<?php
/**
 * commit Model Class
 *
 * @author QiangRunwei <qiangrw@gmail.com>
 * @version	1.0
 */
 
class commit_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    // Compute F_value
    function compute_fvalue($file_content, $ans_content)
    {
		//get official answer
		$answer = preg_split("/[\r]?\n/",$ans_content);
		$pool = array();
		foreach($answer as $a)
		{
			if(strlen($a) == 0)
			{
				continue;
			}
			$a_ans = explode("\t",$a);
			if($a_ans[1] == "1")
			{
				array_push($pool,$a_ans[0]);
			}
		}
		
		$and = 0;
		$a_len = sizeof($pool);
		$f_len = 0;
		
		//get student answer
		$file = preg_split("/[\r]?\n/",$file_content);
		foreach($file as $f)
		{
			if(strlen($f) == 0)
			{
				continue;
			}
			$f_ans = explode("\t",$f);
			if($f_ans[1] == "1")
			{
				$f_len = $f_len + 1;
				if(in_array($f_ans[0],$pool))
				{
					$and = $and + 1;
				}
			}
		}
		
		$alpha = 0.3;
		$p = $and/$f_len;
		$r = $and/$a_len;
		
		$f = 1.0/($alpha/$p+(1-$alpha)/$r);
		return $f;
    }

    // Compute MAP
    function compute_score($file_content, $ans_content)
    {
		//get official answer
		$answer = preg_split("/[\r]?\n/",$ans_content);
		$answer_pool = array();
		for($i=51;$i<=110;$i=$i+1)
		{
			$answer_pool[$i] = array();
		}
		foreach($answer as $a)
		{
			if(strlen($a) == 0)
			{
				continue;
			}
			$a_ans = explode(" ",$a);
			array_push($answer_pool[intval($a_ans[0])],$a_ans[2]);
		}
		
		//get student answer
		for($i=51;$i<=110;$i=$i+1)
		{
			$recall[$i] = 0;
			$rank[$i] = 0;
			$score[$i] = 0.0;
        }

		$file = preg_split("/[\r]?\n/",$file_content);
		foreach($file as $f)
		{
			if(strlen($f) == 0)
			{
				continue;
			}
			$f_ans = explode(" ",$f);
			$qid = intval(substr($f_ans[0],$f_ans[0][2]=="0"?3:2));
			$tid = $f_ans[1];
			$rank[$qid] = $rank[$qid] + 1;
			if($rank[$qid] <= 1000)
			{
				if(in_array($tid,$answer_pool[$qid]))
				{
					$recall[$qid] = $recall[$qid] + 1.0;
					$score[$qid] = $score[$qid] + $recall[$qid]/($rank[$qid]*1.0);
				}
			}
        }

		$mean = 0;
		$qid_num = 0;
		for($i=51;$i<=110;$i=$i+1)
		{
			//return sizeof($answer_pool[$i]);
			if(sizeof($answer_pool[$i])!=0)
			{
				$mean = $mean + $score[$i]/(sizeof($answer_pool[$i]));
				$qid_num = $qid_num + 1.0;
			}
		}
        return $mean/59.0;
    }

	/**
	 * commit::insert()
	 * 
	 * @param array $data
	 * @return
	 */
	function insert($data)
    {
        $data['create_time'] = time();
		$this->db->flush_cache();
		$this->db->insert('wa_commit', $data);
		return ($this->db->affected_rows() == 1);
    }

	/**
	 * commit::update()
	 * 
	 * @param array $data
	 * @return
	 */
	function update($id, $data)
    {
        $this->db->flush_cache();
        $this->db->where('id', $id);
		$this->db->update('wa_commit', $data);
		return ($this->db->affected_rows() == 1);
    }
            
    /**
     * get commit's info by sid
     * @param int id
     * @return mixed $info
     */
	function get($id)
	{
        $this->db->flush_cache();
        $this->db->where('id', $id);
        $query = $this->db->get_where('wa_commit');
        return $query->row();
    }          

    /**
     * Get rank list
     */
    function get_rank($cid, $limit)  
    {

        $this->db->flush_cache();
        $this->db->where('cid', $cid);
        $this->db->order_by('score', 'desc');
        $this->db->limit($limit);
        $query = $this->db->get('wa_commit');
        return $query->result();
    }

         
}
/* End of file commit_model.php */
/* Location: ./application/model/commit_model.php */
