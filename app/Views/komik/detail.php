<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container">
    <div class="row">
        <div class="col">
            <h2 class="mt-2">Detail Komik</h2>
            <div class="card mb-3">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <img class="img" src="/img/<?= $komik['sampul']; ?>">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?= $komik['judul']; ?></h5>
                            <p class="card-text"><b>Penulis : </b><?= $komik['penulis']; ?></p>
                            <p class="card-text"><small class="text-muted"><b>Penerbit : </b><?= $komik['penerbit']; ?></small></p>

                            <a href="/komik/edit/<?= $komik['slug']; ?>" class="btn btn-warning">Edit</a>

                            <form class="d-inline" action="/komik/<?= $komik['id']; ?>" method="POST">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="_method" value="DELETE">

                                <button type="submit" class="btn btn-danger" onclick="return confirm('apakaha anda yakin')">Delete</button>
                            </form>

                            <!-- <a href="/komik/delete/<//?= $komik['id']; ?>" class="btn btn-danger">Delete</a> -->
                            <br>
                            <a href="/komik">Kembali ke daftar komik</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>