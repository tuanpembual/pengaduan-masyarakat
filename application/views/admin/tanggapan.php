<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

	<?= validation_errors('<div class="alert alert-danger alert-dismissible fade show" role="alert">','<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>') ?>
	<?= $this->session->flashdata('msg'); ?>

	<?php if ( ! empty($data_pengaduan)) : ?>

		<div class="row no-gutters">
		<?php foreach ($data_pengaduan as $dp) : ?>
			<div class="col-md-3">
				<div class="card shadow mb-4" style="width: 24rem;">
					<img src="<?= base_url() ?>assets/uploads/<?= $dp['foto'] ?>" class="card-img-top" alt="Thumbnail Pengaduan">
					<div class="card-body">
						<span class="text-dark">Pelapor :</span> <p><?= $dp['nama_masyarakat'] ?></p>
						<span class="text-dark">Nama Pelaku :</span> <p><?= $dp['nama_pelaku'] ?></p>
						<span class="text-dark">Laporan :</span> <p><?= $dp['isi_laporan'] ?></p>
						<span class="text-dark">Nama Korban :</span> <p><?= $dp['nama_korban'] ?></p>
						<span class="text-dark">Telp :</span> <p><?= $dp['telp'] ?></p>
						<span class="text-dark">Tgl Pengaduan :</span> <p><?= $dp['tgl_pengaduan'] ?></p>
						<span class="text-dark">Jenis Pengaduan: </span> <p><?= $dp['jenis_laporan'] ?></p>
						<span class="text-dark">Lokasi: </span> <p><?= $dp['lokasi_kejadian'] ?></p>
						<span class="text-dark">Kabupaten: </span> <p><?= $dp['kabupaten'] ?></p>
					</div>
					<div class="text-center mb-2">
						<div class="">
							
								<?= form_open('Admin/TanggapanController/tanggapan_detail'); ?>
									<input type="hidden" name="id" value="<?= $dp['id_pengaduan'] ?>">
									<button class="btn btn-success" name="terima">Lihat Detail</button>
								<?= form_close(); ?>
							
						</div>
					</div>
				</div>
			</div>
	<?php endforeach; ?>
		</div>

		<?php else : ?>
			<div class="text-center">Belum Ada Pengaduan</div>
		<?php endif; ?>


	</div>