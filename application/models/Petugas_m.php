<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Petugas_m extends CI_Model {

	private $table = 'petugas';
	private $primary_key = 'id_petugas';

	public function create($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}	

	public function get_petugas_by_username($username)
	{
		return $this->db->get_where('petugas', ['username_petugas' => $username]);
	}

	public function get_petugas_kabupaten($id) 
	{
		return $this->db->get_where('petugas_kabupaten', ['id_petugas' => $id]);
	}

	public function get_all_petugas()
	{
		$this->db->select("petugas.*, kabupaten.nama_kabupaten as kabupaten");
		$this->db->from($this->table);
		$this->db->join("petugas_kabupaten", "petugas_kabupaten.id_petugas = petugas.id_petugas", "left");
		$this->db->join("kabupaten", "kabupaten.id_kabupaten = petugas_kabupaten.id_kabupaten", "left");
		
		return $this->db->get();
	}

	public function update($params) 
	{
		$petugas_kabupaten = $this->db->get_where('petugas_kabupaten', ['id_petugas' => $params['id']])->row_array();
		$petugas_params    = [
			'nama_petugas'     => $params['nama'],
			'alamat'           => $params['alamat'],
			'password_petugas' => $params['password'],
			'telp'             => $params['telp'],
		];
		$kabupaten_params  = [
			'id_petugas'      => $params['id'],
			'id_kabupaten'    => $params['kabupaten'],
			'nama_petugaskab' => $params['nama'],
		];

		$petugas_result   = $this->db->update('petugas', $petugas_params, ['id_petugas' => $params['id']]);
		$kabupaten_result = $this->db->update('petugas_kabupaten', $kabupaten_params, ['id_petugas' => $params['id']]); 

		if ( $petugas_result && $kabupaten_result ) return TRUE;
		
		return FALSE;
	}
}

/* End of file Petugas_m.php */
/* Location: ./application/models/Petugas_m.php */