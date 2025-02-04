<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PengaduanController extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    //Load Dependencies
    is_logged_in();
    if ( ! empty($this->session->userdata('level'))) :
      redirect('Auth/BlockedController');
    endif;

    $this->load->model('Pengaduan_m');
    $this->load->model('Kabupaten_m');
  }

  // List all your items
  public function index()
  {
    $data['title'] = 'Pengaduan';
    $masyarakat = $this->db->get_where('masyarakat',['username' => $this->session->userdata('username')])->row_array();
    $data['data_pengaduan'] = $this->Pengaduan_m->data_pengaduan_masyarakat_nik($masyarakat['nik_masyarakat'])->result_array();
    $data['data_kabupaten'] = $this->Kabupaten_m->get_all()->result_array();

    $this->form_validation->set_rules('isi_laporan','Isi Laporan Pengaduan','trim|required');
    $this->form_validation->set_rules('kabupaten', "Kabupaten", 'trim|required');

    if ($this->form_validation->run() == FALSE) :
      $this->load->view('_part/backend_head', $data);
      $this->load->view('_part/backend_sidebar_v');
      $this->load->view('_part/backend_topbar_v');
      $this->load->view('masyarakat/pengaduan');
      $this->load->view('_part/backend_footer_v');
      $this->load->view('_part/backend_foot');
    else :
      $upload_foto = $this->upload_foto('foto'); // parameter nama foto

      if ($upload_foto['status'] == FALSE) :
        $this->session->set_flashdata('msg','<div class="alert alert-danger" role="alert">' . $upload_foto['foto'] . '</div>');

        redirect('Masyarakat/PengaduanController');
      else :

        $params = [
          'tgl_pengaduan'   => date('Y-m-d'),
          'nik_masyarakat'  => $masyarakat['nik_masyarakat'],
          'hubungan'        => htmlspecialchars($this->input->post('hubungan',true)),
          'lokasi_kejadian' => htmlspecialchars($this->input->post('lokasi_kejadian',true)),
          'nama_korban'     => htmlspecialchars($this->input->post('nama_korban',true)),
          'nama_pelaku'     => htmlspecialchars($this->input->post('nama_pelaku',true)),
          'jenis_laporan'   => htmlspecialchars($this->input->post('jenis_laporan',true)),
          'isi_laporan'     => htmlspecialchars($this->input->post('isi_laporan',true)),
          'id_kabupaten'    => htmlspecialchars($this->input->post('kabupaten', true)),
          'foto'            => $upload_foto['foto'],
          'status'          => 'Diajukan'
        ];

        $resp = $this->Pengaduan_m->create($params);

        if ($resp) :
          $this->session->set_flashdata('msg','<div class="alert alert-primary" role="alert">
            Laporan berhasil dibuat
            </div>');

          redirect('Masyarakat/PengaduanController');
        else :
          $this->session->set_flashdata('msg','<div class="alert alert-danger" role="alert">
            Laporan gagal dibuat!
            </div>');

          redirect('Masyarakat/PengaduanController');
        endif;

      endif;
    endif;
  }

  public function pengaduan_detail($id)
  {

    $cek_data = $this->db->get_where('pengaduan',['id_pengaduan' => htmlspecialchars($id)])->row_array();

    if ( ! empty($cek_data)) :

      $data['title'] = 'Detail Pengaduan';

      $data['data_pengaduan'] = $this->Pengaduan_m->data_pengaduan_tanggapan(htmlspecialchars($id))->row_array();
      if ($data['data_pengaduan']) :
        $this->load->view('_part/backend_head', $data);
        $this->load->view('_part/backend_sidebar_v');
        $this->load->view('_part/backend_topbar_v');
        $this->load->view('masyarakat/pengaduan_detail');
        $this->load->view('_part/backend_footer_v');
        $this->load->view('_part/backend_foot');
      else :
        $this->session->set_flashdata('msg','<div class="alert alert-danger" role="alert">
          Pengaduan sedang di proses!
          </div>');

        redirect('Masyarakat/PengaduanController');     
      endif;
      
    else :
      $this->session->set_flashdata('msg','<div class="alert alert-danger" role="alert">
        data tidak ada
        </div>');

      redirect('Masyarakat/PengaduanController');     
    endif;
  }

  public function pengaduan_batal($id)
  {
    $cek_data = $this->db->get_where('pengaduan',['id_pengaduan' => htmlspecialchars($id)])->row_array();

    if ( ! empty($cek_data)) :

      if ($cek_data['status'] == 'Diajukan') :

        $resp = $this->db->delete('pengaduan',['id_pengaduan' => $id]);

        // hapus file
        $path = './assets/uploads/'.$cek_data['foto'];
        unlink($path);

        if ($resp) :
          $this->session->set_flashdata('msg','<div class="alert alert-primary" role="alert">
            Hapus pengaduan berhasil
            </div>');

          redirect('Masyarakat/PengaduanController');
        else :
          $this->session->set_flashdata('msg','<div class="alert alert-danger" role="alert">
            Hapus pengaduan gagal!
            </div>');

          redirect('Masyarakat/PengaduanController');
        endif;

      else :
        $this->session->set_flashdata('msg','<div class="alert alert-danger" role="alert">
          Pengaduan sedang di proses!
          </div>');

        redirect('Masyarakat/PengaduanController');
      endif;

    else :
      $this->session->set_flashdata('msg','<div class="alert alert-danger" role="alert">
        data tidak ada
        </div>');

      redirect('Masyarakat/PengaduanController');       
    endif;
  }

  public function edit($id)
  {
    $cek_data = $this->db->get_where('pengaduan',['id_pengaduan' => htmlspecialchars($id)])->row_array();

    if ( ! empty($cek_data)) :

      if ($cek_data['status'] == 'Diajukan') :

        $data['title'] = 'Edit Pengaduan';
        $data['pengaduan'] = $cek_data;

        $this->form_validation->set_rules('isi_laporan','Isi Laporan Pengaduan','trim|required');
        $this->form_validation->set_rules('foto','Foto Pengaduan','trim');
        
        if ($this->form_validation->run() == FALSE) :
          $this->load->view('_part/backend_head', $data);
          $this->load->view('_part/backend_sidebar_v');
          $this->load->view('_part/backend_topbar_v');
          $this->load->view('masyarakat/edit_pengaduan');
          $this->load->view('_part/backend_footer_v');
          $this->load->view('_part/backend_foot');
        else :
          $upload_foto = empty($_FILES['foto']['name']) ? $cek_data : $this->upload_foto('foto');

          if ($upload_foto['status'] == FALSE) :
            $this->session->set_flashdata('msg','<div class="alert alert-danger" role="alert">' . $upload_foto['foto'] . '</div>');

            redirect('Masyarakat/PengaduanController');
          else :

            // hapus file
          if (!empty($_FILES['foto']['name'])) :
            $path = './assets/uploads/'.$cek_data['foto'];
            unlink($path);
          endif;

            $params = [
              'hubungan'        => htmlspecialchars($this->input->post('hubungan',true)),
              'lokasi_kejadian' => htmlspecialchars($this->input->post('lokasi_kejadian',true)),
              'nama_korban'     => htmlspecialchars($this->input->post('nama_korban',true)),
              'nama_pelaku'     => htmlspecialchars($this->input->post('nama_pelaku',true)),
              'isi_laporan'     => htmlspecialchars($this->input->post('isi_laporan',true)),
              'foto'            => $upload_foto['foto'],
            ];

            $resp = $this->db->update('pengaduan',$params,['id_pengaduan' => $id]);;

            if ($resp) :
              $this->session->set_flashdata('msg','<div class="alert alert-primary" role="alert">
                Laporan berhasil dibuat
                </div>');

              redirect('Masyarakat/PengaduanController');
            else :
              $this->session->set_flashdata('msg','<div class="alert alert-danger" role="alert">
                Laporan gagal dibuat!
                </div>');

              redirect('Masyarakat/PengaduanController');
            endif;

          endif;

        endif;

      else :
        $this->session->set_flashdata('msg','<div class="alert alert-danger" role="alert">
          Pengaduan sedang di proses!
          </div>');

        redirect('Masyarakat/PengaduanController');
      endif;

    else :
      $this->session->set_flashdata('msg','<div class="alert alert-danger" role="alert">
        data tidak ada
        </div>');

      redirect('Masyarakat/PengaduanController');       
    endif;
  }

  private function upload_foto($foto)
  {
    $config['max_size']             = $_FILES['foto']['type'] == 'video/mp4' ? 25000 : 2048;
    $config['upload_path']          = './assets/uploads/';
    $config['allowed_types']        = 'jpeg|jpg|png|mp4';
    $config['remove_spaces']        = TRUE;
    $config['detect_mime']          = TRUE;
    $config['mod_mime_fix']         = TRUE;
    $config['encrypt_name']         = TRUE;

    $this->load->library('upload', $config);

    if ( ! $this->upload->do_upload($foto)) :
      return ['status' => FALSE, 'foto' => $this->upload->display_errors()];
    else :
      return ['status' => TRUE, 'foto' => $this->upload->data('file_name')];
    endif;
  }
}

/* End of file PengaduanController.php */
/* Location: ./application/controllers/Masyarakat/PengaduanController.php */
