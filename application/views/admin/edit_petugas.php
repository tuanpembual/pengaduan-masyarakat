<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <a href="<?= base_url('Admin/PetugasController') ?>" class="btn btn-dark"><i class="fas fa-arrow-left"></i></a>
  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

  <?= validation_errors('<div class="alert alert-danger alert-dismissible fade show" role="alert">','<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  </div>') ?>
  <?= $this->session->flashdata('msg'); ?>

  <div class="row">
    <div class="col-lg-6">

    <?= form_open('Admin/PetugasController/edit/'.$petugas['id_petugas']); ?>

    <div class="form-group">
      <label for="nama">Nama</label>
      <input type="text" class="form-control" id="nama" placeholder="" name="nama" value="<?= $petugas['nama_petugas'] ?>">
    </div>

    <div class="form-group">
      <label for="telp">Telp</label>
      <input type="text" class="form-control" id="telp" placeholder="" name="telp" value="<?= $petugas['telp'] ?>">
    </div>

    <div class="form-group">
      <label for="alamat">Alamat</label>
      <input type="text" class="form-control" id="alamat" placeholder="" name="alamat" value="<?= $petugas['alamat'] ?>">
    </div>

    <div class="form-group">
      <label for="password">Passsword</label>
      <input type="password" class="form-control" id="password" name="password" placeholder="">
    </div>

    <div class="form-group">
        <label for="kabupaten"> Kabupaten </label>
        <select name="kabupaten" id="kabupaten" class="form-control"> 
          <option value=""> -- Pilih Kabupaten -- </option>
          <?php foreach( $data_kabupaten as $kabupaten ) : ?>
            <option value="<?= $kabupaten["id_kabupaten"] ?>" <?= $petugas_kab == $kabupaten["id_kabupaten"] ? 'selected' : "" ?>> <?= $kabupaten["nama_kabupaten"] ?></option>
          <?php endforeach; ?>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
    <?= form_close(); ?>
  </div>
</div>

<!-- /.container-fluid -->
</div>