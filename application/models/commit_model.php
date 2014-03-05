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
         
}
/* End of file commit_model.php */
/* Location: ./application/model/commit_model.php */
