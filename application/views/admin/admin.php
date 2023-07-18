<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

  <?= validation_errors('<div class="alert alert-danger alert-dismissible fade show" role="alert">','<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  </div>') ?>
  <?= $this->session->flashdata('msg'); ?>

  <div class="row">
    <div class="col-lg-6">

    <?= form_open('Admin/AdminController'); ?>

    <div class="form-group">
      <label for="nama">Nama</label>
      <input type="text" class="form-control" id="nama" placeholder="" name="nama" value="<?= set_value('nama') ?>">
    </div>

    <div class="form-group">
      <label for="username">Username</label>
      <input type="text" class="form-control" id="username" name="username" placeholder="" value="<?= set_value('username') ?>"> 
    </div>

    <div class="form-group">
      <label for="password">Passsword</label>
      <input type="password" class="form-control" id="password" name="password" placeholder="">
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
    <?= form_close(); ?>
  </div>
</div>

<!-- Page Heading -->
<h1 class="h3 mb-4 mt-5 text-gray-800">Data Admin</h1>

<div class="table-responsive">
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nama</th>
      <th scope="col">Username</th>
      <th scope="col">Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php $no = 1; ?>
    <?php foreach ($data_petugas as $dp) : ?>
      <tr>
        <th scope="row"><?= $no++; ?></th>
        <td><?= $dp['nama_admin']; ?></td>
        <td><?= $dp['username_admin']; ?></td>
        <td>
        <?php if ($dp['username_admin'] == $this->session->userdata('username')) : ?>
          <small>Tidak ada aksi</small>
        <?php else : ?>
          <a href="<?= base_url('Admin/AdminController/edit/'.$dp['id_admin']) ?>" class="btn btn-info">Edit</a>
          <a href="<?= base_url('Admin/AdminController/delete/'.$dp['id_admin']) ?>" class="btn btn-warning">Hapus</a>
        <?php endif; ?>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
</div>

<!-- /.container-fluid -->
</div>