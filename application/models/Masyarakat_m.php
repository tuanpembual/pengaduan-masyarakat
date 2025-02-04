<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Masyarakat_m extends CI_Model {

	private $table = 'masyarakat';
	private $primary_key = 'nik';
	
	public function create($data)
	{
		$data_masyarakat = array(
			'nik_masyarakat' => $data['nik'],
			'username'       => $data['username'],
			'password'       => $data['password']
		);

		$save_masyarakat = $this->db->insert('masyarakat', $data_masyarakat);
		$id_masyarakat   = $this->db->insert_id();

		if(!$save_masyarakat) {
			return false;
		}

		$detail_masyarakat = array(
			'id_masyarakat'    => $id_masyarakat,
			'nama_masyarakat'  => $data['nama'],
			'TTL'              => $data['TTL'],
			'jenis_kelamin'    => $data['jenis_kelamin'],
			'pekerjaan'        => $data['pekerjaan'],
			'pendidikan_terakhir' => $data['pendidikan_terakhir'],
			'agama'            => $data['agama'],
			'alamat'           => $data['alamat'],
			'no_hp'            => $data['no_hp'],
			'email'            => $data['email'],
			'foto_profile'     => $data['foto_profile']
		);

		$save_detail_masyarakat = $this->db->insert('masyarakat_detail', $detail_masyarakat);

		return $save_detail_masyarakat;
	}

	public function get_all() {
		$this->db->select('masyarakat.nik_masyarakat, masyarakat_detail.nama_masyarakat, masyarakat.username, masyarakat_detail.no_hp, masyarakat.is_verified');
		$this->db->from($this->table);
		$this->db->join('masyarakat_detail', 'masyarakat_detail.id_masyarakat = masyarakat.id_masyarakat', 'inner');

		return $this->db->get();
	}
}

/* End of file Masyarakat_m.php */
/* Location: ./application/models/Masyarakat_m.php */