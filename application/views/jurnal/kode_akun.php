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
    <div class="col-md-1">
      <button type="button" id="upload" class="btn btn-primary mb-3">Upload</button>
    </div>
    <?php if ($akun) : ?>
      <div class="col-md-1">
        <a href="<?= base_url('jurnal/deleteakun') ?>" class="btn btn-danger">Delete</a>
      </div>
    <?php endif ?>
  </div>
  <?php
  if ($akun) : ?>
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
            $i = 1;
            foreach ($akun as $k) :
            ?>
              <tr>
                <th scope="row"><?= $i++ ?></th>
                <td><?= $k["kode_akun"] ?></td>
                <td><?= $k["nama_akun"] ?></td>
                <td><?= $k["saldo_normal"] ?></td>
              </tr>
            <?php
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