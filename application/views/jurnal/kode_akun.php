<!-- Begin Page Content -->
<div class="container-fluid">
  <div class="row">
    <div class="col-md-4">
      <div class="input-group mb-3">
        <div class="custom-file">
          <label class="custom-file-label" id="fileUpLabel" for="fileUpload">Choose file</label>
          <input type="file" class="custom-file-input" id="fileUpload" accept=".xls,.xlsx" data-url="<?= base_url() ?>">
        </div>
      </div>
    </div>
    <div class="col">
      <button type="button" id="upload" class="btn btn-primary mb-3">Upload</button>
    </div>
  </div>
  <?php if (isset($_SESSION['kode'])) : ?>
    <div class="row">
      <div class="col-md-10">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Kode Akun</th>
              <th scope="col">Nama Akun</th>
              <th scope="col">Saldo Normal</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $kode = json_decode($_SESSION['kode']);
            unset($_SESSION['kode']);
            $i = 1;
            foreach ($kode as $k) :
            ?>
              <tr>
                <th scope="row"><?= $i ?></th>
                <td><?= $k->kode_akun ?></td>
                <td><?= $k->nama_akun ?></td>
                <td><?= $k->saldo_normal ?></td>
              </tr>
            <?php
              $i++;
            endforeach;
            ?>
          </tbody>
        </table>
      </div>
    </div>
  <?php endif ?>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->