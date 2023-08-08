 <div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
        <div class="col-lg-7">
          <div class="p-5">
            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-4">Register</h1>
            </div>

            <?= validation_errors('<div class="alert alert-danger alert-dismissible fade show" role="alert">','<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              </div>') ?>

              <?= $this->session->flashdata('msg'); ?>

              <?= form_open('Auth/RegisterController', 'class="user"') ?>
              <div class="form-group">
                <input type="text" class="form-control form-control-user invalid" id="nik" placeholder="NIK" name="nik" value="<?= set_value('nik') ?>">
              </div>
              <div class="form-group">
                <input type="text" class="form-control form-control-user" id="nama" placeholder="Nama" name="nama" value="<?= set_value('nama') ?>">
              </div>
              <div class="form-group">
                <input type="text" class="form-control form-control-user" id="username" placeholder="Username" name="username" value="<?= set_value('username') ?>">  
              </div>
              <div class="form-group">
                <input type="password" class="form-control form-control-user" id="password" placeholder="Password" name="password">
              </div>
              <div class="form-group">
                <input type="text" class="form-control form-control-user" id="alamat" placeholder="Alamat" name="alamat">
              </div>
              <div class="form-group">
                <label for="tanggal_lahir"> Tanggal Lahir </label>
                <input type="date" class="form-control form-control-user" id="tanggal_lahir" placeholder="Tanggal Lahir" name="TTL">
              </div>
              <div class="form-group">
                 <label for="jenis_kelamin"> Jenis Kelamin </label></br>
                 <input type="radio" id="jenis_kelamin" name="jenis_kelamin" value="laki-laki">
                 <label for="html"> Laki - Laki </label>
                 <input type="radio" id="jenis_kelamin" name="jenis_kelamin" value="perempuan">
                 <label for="html"> Perempuan </label>
              </div>
              <div class="form-group">
                <input type="text" class="form-control form-control-user" id="pekerjaan" placeholder="Pekerjaan" name="pekerjaan">         
              </div>
              <div class="form-group">
                <input type="text" class="form-control form-control-user" id="pendidikan_terakhir" placeholder="Pendidikan Terakhir" name="pendidikan_terakhir">         
              </div>
              <div class="form-group">
                <input type="text" class="form-control form-control-user" id="agama" placeholder="Agama" name="agama">         
              </div>
              <div class="form-group">
                <input type="text" class="form-control form-control-user" id="nomorhp" placeholder="No HP" name="no_hp">         
              </div>
              <div class="form-group">
                <input type="email" class="form-control form-control-user" id="email" placeholder="Email" name="email">         
              </div>
              <button type="submit" class="btn btn-primary btn-user btn-block">Register</button>
            </form>
            <hr>
            <div class="text-center">
              <a class="small" href="<?= base_url('Auth/LoginController') ?>">Sudah punya akun? Login!</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>