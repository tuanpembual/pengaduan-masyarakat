<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_m extends CI_Model {

	private $table = 'admin';
	private $primary_key = 'id_admin';

	public function get_all() 
	{
		$this->db->select('*');
		$this->db->from($this->table);
		
		return $this->db->get();
	}

	public function create($data) 
	{
		$this->db->insert($this->table, $data);

		return $this->db->insert_id();
	}

}

/* End of file Petugas_m.php */
/* Location: ./application/models/Petugas_m.php */