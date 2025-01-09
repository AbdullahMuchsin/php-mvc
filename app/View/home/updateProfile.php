<!-- Alert Message -->
<?php if (isset($model["error"])) : ?>
    <div id="alertMessage" class="alert alert-danger" role="alert">
        <?= $model["error"] ?>
    </div>
<?php endif; ?>


<!-- Update Profile -->
<div class="container">
    <div class="card">
        <div class="card-header text-center">
            <h5><i class="fas fa-user-edit"></i> Update Profile</h5>
        </div>
        <div class="card-body">
            <form method="post" action="/user/update">
                <div class="form-group">
                    <label for="profileId">ID</label>
                    <input
                        type="text"
                        class="form-control"
                        id="profileId"
                        placeholder="ID"
                        disabled value="<?= $model["user"]["id"] ?? "" ?>" />
                </div>
                <div class="form-group">
                    <label for="profileName">Nama</label>
                    <input
                        name="name"
                        type="text"
                        class="form-control"
                        id="profileName"
                        placeholder="Masukkan Nama"
                        value="<?= $model["user"]["name"] ?? "" ?>" />
                </div>
                <button type="submit" class="btn btn-success btn-block">
                    Update Profile
                </button>
            </form>
        </div>
    </div>
</div>