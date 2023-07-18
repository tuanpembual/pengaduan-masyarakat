<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PetugasController extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Load Dependencies
		is_logged_in();
		if ($this->session->userdata('level') != 'admin') :
			redirect('Auth/BlockedController');
		endif;
		$this->load->model('Petugas_m');
		$this->load->model('Kabupaten_m');
		$this->load->model('PetugasKabupaten_m');
	}

	// List all your items
	public function index()
	{
		$data['title']          = 'Tambah Petugas';
		$data['data_petugas']   = $this->Petugas_m->get_all_petugas()->result_array();
		$data['data_kabupaten'] = $this->Kabupaten_m->get_all()->result_array();

		$this->form_validation->set_rules('nama','Nama','trim|required|alpha_numeric_spaces');
		$this->form_validation->set_rules('username','Username','trim|required|alpha_numeric_spaces|callback_username_check');
		$this->form_validation->set_rules('password','Password','trim|required|alpha_numeric_spaces|min_length[6]|max_length[15]');
		$this->form_validation->set_rules('nik','NIK','trim|required|numeric');
		$this->form_validation->set_rules('alamat','Alam','trim|required');
		$this->form_validation->set_rules('telp','Telp','trim|required|numeric');
		$this->form_validation->set_rules('level','Level','trim|required');

		if (htmlspecialchars($this->input->post('level', TRUE)) == 'petugas') :
			$this->form_validation->set_rules('kabupaten', 'Kabupaten', 'trim|required');
		endif;

		if ($this->form_validation->run() == FALSE) :
			$this->load->view('_part/backend_head', $data);
			$this->load->view('_part/backend_sidebar_v');
			$this->load->view('_part/backend_topbar_v');
			$this->load->view('admin/petugas');
			$this->load->view('_part/backend_footer_v');
			$this->load->view('_part/backend_foot');
		else :
			$params = [
				'nama_petugas'        => htmlspecialchars($this->input->post('nama',TRUE)),
				'username_petugas'    => htmlspecialchars($this->input->post('username',TRUE)),
				'password_petugas'    => password_hash(htmlspecialchars($this->input->post('password',TRUE)), PASSWORD_DEFAULT),
				'nik_petugas'         => htmlspecialchars($this->input->post('nik',TRUE)),
				'alamat'              => htmlspecialchars($this->input->post('alamat',TRUE)),
				'telp'                => htmlspecialchars($this->input->post('telp',TRUE)),
				'level'               => htmlspecialchars($this->input->post('level',TRUE)),
				'foto_profile'        => 'user.png',
			];

			$response = $this->Petugas_m->create($params);

			if ($response) :
				if (htmlspecialchars($this->input->post('level', TRUE)) == 'petugas') :
					$kabupaten = htmlspecialchars($this->input->post('kabupaten', TRUE));
					$nama = htmlspecialchars($this->input->post('nama', TRUE));

					$petugas_kabupaten = $this->PetugasKabupaten_m->create([
						'kabupaten_id' => $kabupaten,
						'petugas_id' => $response,
						'nama_petugaskab' => $nama,
					]);
				endif;

				$this->session->set_flashdata('msg','<div class="alert alert-primary" role="alert">
					Buat akun petugas berhasil
					</div>');

				redirect('Admin/PetugasController');
			else :
				$this->session->set_flashdata('msg','<div class="alert alert-danger" role="alert">
					Buat akun petugas berhasil!
					</div>');

				redirect('Admin/PetugasController');
			endif;
		endif;
	}

	public function delete($id)
	{

	$id_petugas = htmlspecialchars($id); // id petugas
	$cek_data   = $this->db->get_where('petugas',['id_petugas' => $id_petugas])->row_array();

	if ( ! empty($cek_data)) :
		$resp = $this->db->delete('petugas',['id_petugas' => $id_petugas]);
		if ($cek_data['level'] == 'petugas'):
			$this->db->delete('petugas_kabupaten', ['petugas_id' => $id_petugas]);
		endif;

		if ($resp) :
			$this->session->set_flashdata('msg','<div class="alert alert-primary" role="alert">
				Akun berhasil dihapus
				</div>');

			redirect('Admin/PetugasController');
		else :
			$this->session->set_flashdata('msg','<div class="alert alert-danger" role="alert">
				Akun gagal dihapus!
				</div>');

			redirect('Admin/PetugasController');
		endif;
	else :
		$this->session->set_flashdata('msg','<div class="alert alert-danger" role="alert">
			Data tidak ada
			</div>');

		redirect('Admin/PetugasController');
	endif;

}

public function edit($id)
{
		$id_petugas = htmlspecialchars($id); // id petugas
		$cek_data   = $this->db->get_where('petugas',['id_petugas' => $id_petugas])->row_array();

		if ( ! empty($cek_data)) :

			$data['title']          = 'Edit Petugas';
			$data['petugas']        = $cek_data;
			$data['data_kabupaten'] = $this->Kabupaten_m->get_all()->result_array();

			$this->form_validation->set_rules('nama','Nama','trim|required|alpha_numeric_spaces');
			$this->form_validation->set_rules('telp','Telp','trim|required|numeric');
			$this->form_validation->set_rules('level','Level','trim|required');

			if (htmlspecialchars($this->input->post('level', TRUE)) == 'petugas') :
				$this->form_validation->set_rules('kabupaten', 'Kabupaten', 'trim|required');
			endif;

			if ($this->form_validation->run() == FALSE) :
				$this->load->view('_part/backend_head', $data);
				$this->load->view('_part/backend_sidebar_v');
				$this->load->view('_part/backend_topbar_v');
				$this->load->view('admin/edit_petugas');
				$this->load->view('_part/backend_footer_v');
				$this->load->view('_part/backend_foot');
			else :

			$params = [
				'id'        => $id_petugas,
				'nama'      => htmlspecialchars($this->input->post('nama', TRUE)),
				'telp'      => htmlspecialchars($this->input->post('telp', TRUE)),
				'level'     => htmlspecialchars($this->input->post('level', TRUE)),
				'kabupaten' => htmlspecialchars($this->input->post('kabupaten', TRUE)),
			];

			$resp = $this->Petugas_m->update($params);

			if ($resp) :
				$this->session->set_flashdata('msg','<div class="alert alert-primary" role="alert">
					Akun petugas berhasil di edit
					</div>');

				redirect('Admin/PetugasController');
			else :
				$this->session->set_flashdata('msg','<div class="alert alert-danger" role="alert">
					Akun petugas gagal di edit!
					</div>');

				redirect('Admin/PetugasController');
			endif;

			endif;

		else :
			$this->session->set_flashdata('msg','<div class="alert alert-danger" role="alert">
				Data tidak ada
				</div>');

			redirect('Admin/PetugasController');
		endif;
	}

	public function username_check($str = NULL)
	{
		if (!empty($str)) :
			$masyarakat = $this->db->get_where('masyarakat',['username' => $str])->row_array();
			$petugas  = $this->db->get_where('petugas',['username_petugas' => $str])->row_array();

			if ($masyarakat == true || $petugas == true) :

				$this->form_validation->set_message('username_check', 'Username ini sudah terdaftar ada.');

				return false;
			else :
				return true;
			endif;
		else :
			$this->form_validation->set_message('username_check', 'Inputan Kosong');

			return false;
		endif;
	}
}

/* End of file PetugasController.php */
/* Location: ./application/controllers/Admin/PetugasController.php */
