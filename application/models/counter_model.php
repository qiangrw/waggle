<?php
/**
 * Counter Model Class
 *
 * @author QiangRunwei <qiangrw@gmail.com>
 * @version	1.0
 */
 
class Counter_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
 
	/**
	 * Counter::insert()
	 * 
	 * @param array $data
	 * @return
	 */
	function insert($data)
    {
        $data['create_time'] = time();
		$this->db->flush_cache();
		$this->db->insert('wa_counter', $data);
		return ($this->db->affected_rows() == 1);
    }

	/**
	 * Counter::update()
	 * 
	 * @param array $data
	 * @return
	 */
	function update($id, $data)
    {
        $this->db->flush_cache();
        $this->db->where('id', $id);
		$this->db->update('wa_counter', $data);
		return ($this->db->affected_rows() == 1);
    }
            
    /**
     * get counter's info by sid
     * @param int id
     * @return mixed $info
     */
	function get($id)
	{
        $this->db->flush_cache();
        $this->db->where('id', $id);
        $query = $this->db->get_where('wa_counter');
        return $query->row();
	}          
         
}
/* End of file counter_model.php */
/* Location: ./application/model/counter_model.php */
