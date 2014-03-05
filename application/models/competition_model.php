<?php
/**
 * Competition Model Class
 *
 * @author QiangRunwei <qiangrw@gmail.com>
 * @version	1.0
 */

class Competition_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    /**
     * Competition::insert()
     * 
     * @param array $data
     * @return
     */
    function insert($data)
    {
        $data['create_time'] = time();
        $this->db->flush_cache();
        $this->db->insert('wa_competition', $data);
        return ($this->db->affected_rows() == 1);
    }

    /**
     * Competition::insert()
     * 
     * @param array $data
     * @return
     */
    function update($id, $data)
    {
        $this->db->flush_cache();
        $this->db->where('id', $id);
        $this->db->update('wa_competition', $data);
        return ($this->db->affected_rows() == 1);
    }

    /**
     * get competition's info by sid
     * @param int id
     * @return mixed $info
     */
    function get($id)
    {
        $this->db->flush_cache();
        $this->db->where('id', $id);
        $query = $this->db->get('wa_competition');
        return $query->row();
    }   

    /**
     * get all the competition list
     */
    function gets()  
    {

        $this->db->flush_cache();
        $query = $this->db->get('wa_competition');
        return $query->result();
    }

    /**
     * check if the competition has closed
     */
    function expired($id)
    {
        return ($this->get($id)->deadline < time());
    }

}
/* End of file competition_model.php */
/* Location: ./application/model/competition_model.php */
