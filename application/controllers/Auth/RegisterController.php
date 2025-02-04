<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RegisterController extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Load Dependencies
		$this->load->model('Masyarakat_m');
	}

	// List all your items
	public function index()
	{
		$data['title'] = 'Register';

		$this->form_validation->set_rules('nik','Nik','trim|required|numeric|is_unique[masyarakat.nik_masyarakat]');
		$this->form_validation->set_rules('nama','Nama','trim|required|alpha_numeric_spaces');
		$this->form_validation->set_rules('username','Username','trim|required|alpha_numeric_spaces|callback_username_check');
		$this->form_validation->set_rules('password','Password','trim|required|alpha_numeric_spaces|min_length[6]|max_length[15]');
		$this->form_validation->set_rules('TTL', 'Tanggal Lahir', 'trim|required');
		$this->form_validation->set_rules('pekerjaan', 'Pekerjaan', 'trim|required');
		$this->form_validation->set_rules('pendidikan_terakhir', 'Pendidikan Terakhir', 'trim|required');
		$this->form_validation->set_rules('agama', 'Agama', 'trim|required');
		$this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
		$this->form_validation->set_rules('no_hp','No HP','trim|required|numeric');

		if ($this->form_validation->run() == FALSE) :
			$this->load->view('_part/login_head', $data);
			$this->load->view('register_v');
			$this->load->view('_part/login_footer');
		else :
			$params = [
				'nik'            => htmlspecialchars($this->input->post('nik',TRUE)),
				'nama'			 => htmlspecialchars($this->input->post('nama',TRUE)),
				'username'		 => htmlspecialchars($this->input->post('username',TRUE)),
				'password'		 => password_hash(htmlspecialchars($this->input->post('password',TRUE)), PASSWORD_DEFAULT),
				'TTL'            => htmlspecialchars($this->input->post('TTL', TRUE)),
				'jenis_kelamin'  => htmlspecialchars($this->input->post('jenis_kelamin', TRUE)),
				'pekerjaan'      => htmlspecialchars($this->input->post('pekerjaan', TRUE)),
				'pendidikan_terakhir' => htmlspecialchars($this->input->post('pendidikan_terakhir', TRUE)),
				'agama'          => htmlspecialchars($this->input->post('agama', TRUE)),
				'alamat'		 => htmlspecialchars($this->input->post('alamat', TRUE)),
				'no_hp'          => htmlspecialchars($this->input->post('no_hp', TRUE)),
				'email'          => htmlspecialchars($this->input->post('email', TRUE)),
				'foto_profile'   => 'user.png',
			];

			$resp = $this->Masyarakat_m->create($params);

			if ($resp) :
				$this->session->set_flashdata('msg','<div class="alert alert-primary" role="alert">
					Register berhasil, Silahkan Menunggu Akun Dikonfirmasi Admin!
					</div>');

				redirect('Auth/LoginController');
			else :
				$this->session->set_flashdata('msg','<div class="alert alert-danger" role="alert">
					Register gagal!
					</div>');

				redirect('Auth/RegisterController');
			endif;

		endif;
	}

	public function username_check($str = NULL)
	{
		if (!empty($str)) :
			$masyarakat = $this->db->get_where('masyarakat',['username' => $str])->row_array();
			$petugas    = $this->db->get_where('petugas',['username_petugas' => $str])->row_array();
			$admin      = $this->db->get_where('admin', ['username_admin' => $str])->row_array();

			if ($masyarakat == TRUE OR $petugas == TRUE OR $admin == TRUE) :

				$this->form_validation->set_message('username_check', 'Username ini sudah terdaftar ada.');

				return FALSE;
			else :
				return TRUE;
			endif;
		else :
			$this->form_validation->set_message('username_check', 'Inputan Kosong');

			return FALSE;
		endif;
	}
}

/* End of file RegisterController.php */
/* Location: ./application/controllers/Auth/RegisterController.php */
