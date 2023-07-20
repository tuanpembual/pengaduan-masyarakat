<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

  <div class="row">
    <div class="col-lg-8">
      <?= $this->session->flashdata('pesan'); ?>
    </div>
  </div>

  <div class="card mb-3 col-lg-8">
    <div class="row no-gutters">
      <?php if ($this->session->userdata('level') != 'superadmin'): ?>
        <div class="col-md-4">
          <img src="<?= base_url('assets/profile/'.$user['foto_profile']) ?>" class="card-img" alt="img user">
        </div>
      <?php endif; ?>
      <div class="col-md-8">
        <div class="card-body">
        <?php if ($this->session->userdata('level') != 'superadmin'): ?>
          <h5 class="card-title">Nama : <?= $this->session->userdata('level') == NULL ? $user['nama_masyarakat'] : $user['nama_petugas']; ?></h5>
          <p class="card-text">NIK    : <?= $this->session->userdata('level') == NULL ? $user['nik_masyarakat'] : $user['nik_petugas']; ?></p>
          <p class="card-text">Alamat : <?= $user['alamat'] ?></p>
          <p class="card-text">Telp   : <?= $user['telp'] ?></p>
          <!-- <p class="card-text"><small class="text-muted">Member since </small></p> -->
          <!-- <p><button class="btn btn-success" onclick="alert('halaman belum dibuat')">Ganti Foto</button></p> -->
        <?php else: ?>
          <h5 class="card-title"> Nama : <?= $user['nama_admin']; ?> </h5>
        <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

</div>
        <!-- /.container-fluid