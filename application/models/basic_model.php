<?php
/**
 * Basic Model Class
 *
 * @author QiangRunwei <qiangrw@gmail.com>
 * @version	1.0
 */
 
class Basic_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
 
	/**
	 * Basic::insert()
	 * 
	 * @param array $data
	 * @return
	 */
	function insert($data)
    {
        $data['create_time'] = time();
		$this->db->flush_cache();
		$this->db->insert('wa_basic', $data);
		return ($this->db->affected_rows() == 1);
    }

	/**
	 * Basic::update()
	 * 
	 * @param array $data
	 * @return
	 */
	function update($id, $data)
    {
        $this->db->flush_cache();
        $this->db->where('id', $id);
		$this->db->update('wa_basic', $data);
		return ($this->db->affected_rows() == 1);
    }
            
    /**
     * get basic's info by sid
     * @param int id
     * @return mixed $info
     */
	function get($id)
	{
        $this->db->flush_cache();
        $this->db->where('id', $id);
        $query = $this->db->get_where('wa_basic');
        return $query->row();
	}          
         
}
/* End of file basic_model.php */
/* Location: ./application/model/basic_model.php */
