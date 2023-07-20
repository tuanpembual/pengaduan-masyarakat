<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

  <?= validation_errors('<div class="alert alert-danger alert-dismissible fade show" role="alert">','<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  </div>') ?>
  <?= $this->session->flashdata('msg'); ?>

  <div class="row">
    <div class="col-lg-6">

    <?= form_open('Admin/PetugasController'); ?>

    <div class="form-group">
      <label for="nama">Nama</label>
      <input type="text" class="form-control" id="nama" placeholder="" name="nama" value="<?= set_value('nama') ?>">
    </div>

    <div class="form-group">
      <label for="nik">NIK</label>
      <input type="text" class="form-control" id="nik" placeholder="" name="nik" value="<?= set_value('nik') ?>">
    </div>

    <div class="form-group">
      <label for="username">Username</label>
      <input type="text" class="form-control" id="username" name="username" placeholder="" value="<?= set_value('username') ?>"> 
    </div>

    <div class="form-group">
      <label for="password">Passsword</label>
      <input type="password" class="form-control" id="password" name="password" placeholder="">
    </div>

    <div class="form-group">
      <label for="alamat">Alamat</label>
      <input type="text" class="form-control" id="alamat" placeholder="" name="alamat" value="<?= set_value('alamat') ?>">
    </div>

    <div class="form-group">
      <label for="telp">Telp</label>
      <input type="text" class="form-control" id="telp" placeholder="" name="telp" value="<?= set_value('telp') ?>">
    </div>
    <div class="form-group">
        <label for="kabupaten"> Kabupaten </label>
        <select name="kabupaten" id="kabupaten" class="form-control"> 
          <option value=""> -- Pilih Kabupaten -- </option>
          <?php foreach( $data_kabupaten as $kabupaten ) : ?>
            <option value="<?= $kabupaten["id_kabupaten"] ?>"> <?= $kabupaten["nama_kabupaten"] ?></option>
          <?php endforeach; ?>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
    <?= form_close(); ?>
  </div>
</div>

<!-- Page Heading -->
<h1 class="h3 mb-4 mt-5 text-gray-800">Data Petugas</h1>

<div class="table-responsive">
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nama</th>
      <th scope="col">Username</th>
      <th scope="col">Telp</th>
      <th scope="col">Kabupaten</th>
      <th scope="col">Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php $no = 1; ?>
    <?php foreach ($data_petugas as $dp) : ?>
      <tr>
        <th scope="row"><?= $no++; ?></th>
        <td><?= $dp['nama_petugas']; ?></td>
        <td><?= $dp['username_petugas']; ?></td>
        <td><?= $dp['telp']; ?></td>
        <td>
          <?php if ($dp['kabupaten']) : ?>
            <?= $dp['kabupaten'] ?>
          <?php else: ?>
            
          <?php endif; ?>
        </td>
        <td>
          <?php if ($dp['kabupaten']): ?>
            <a href="<?= base_url('Admin/PetugasController/edit/'.$dp['id_petugas']) ?>" class="btn btn-info">Edit</a>
            <a href="<?= base_url('Admin/PetugasController/delete/'.$dp['id_petugas']) ?>" class="btn btn-warning">Hapus</a>
          <?php endif; ?>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
</div>

<!-- /.container-fluid -->
</div>