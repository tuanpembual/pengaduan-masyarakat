<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

  <form class="form-inline" action="LaporanController" method="POST">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
    <div class="form-group mx-sm-3 mb-2">
      <label for="bulan" class="sr-only">Bulan</label>
      <input type="month" class="form-control" id="bulan" name="bulan">
    </div>
    <button type="submit" class="btn btn-primary mb-2">Confirm Filter</button>
  </form>

  <?php if ($laporan) : ?>
    <table class="table">
      <thead class="thead-dark">
        <tr>
          <th scope="col">No</th>
          <th scope="col">Nama Korban</th>
          <th scope="col">Tgl Pengaduan</th>
          <th scope="col">Jenis Pengaduan</th>
          <th scope="col">Lokasi Kejadian</th>
          <th scope="col">Kabupaten</th>
          <th scope="col">Isi Laporan</th>
          <th scope="col">Status</th>
          <th scope="col">Tanggapan</th>
        </tr>
      </thead>
      <tbody>

        <?php $no = 1; ?>
        <?php foreach ($laporan as $l) : ?>
          <tr>
            <th scope="row"><?= $no++; ?></th>
            <td><?= $l['nama_korban'] ?></td>
            <td><?= $l['tgl_pengaduan'] ?></td>
            <td><?= $l['jenis_laporan'] ?></td>
            <td><?= $l['lokasi_kejadian'] ?></td>
            <td><?= $l['nama_kabupaten'] ?></td>
            <td><?= $l['isi_laporan'] ?></td>
            <td><span class="badge badge-primary"><?= $l['status'] ?></span></td>
            <td><?= $l['tanggapan'] == null ? '-' : $l['tanggapan']; ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <a target="_blank" href="<?= base_url('Admin/LaporanController/generate_laporan/' . $bulanTahun) ?>" class="btn btn-primary mt-2">Cetak dan Unduh</a>

  <?php else : ?>
    <p class="text-center">Belum ada data</p>
  <?php endif; ?>
</div>
<!-- /.container-fluid -->