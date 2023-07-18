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

	public function update($data) 
	{
		$admin_params = [
			'nama_admin'     => $data['nama'],
			'password_admin' => $data['password'],
		];

		return $this->db->update($this->table, $admin_params, ['id_admin' => $data['id']]);
	}

}

/* End of file Admin_m.php */
/* Location: ./application/models/Admin_m.php */