<!-- Alert Message -->
<?php if (isset($model["error"])) : ?>
    <div id="alertMessage" class="alert alert-danger" role="alert">
        <?= $model["error"] ?>
    </div>
<?php endif; ?>

<!-- Update Password -->
<div class="container">
    <div class="card">
        <div class="card-header text-center">
            <h5><i class="fas fa-lock"></i> Update Password</h5>
        </div>
        <div class="card-body">
            <form action="/user/update-password" method="post">
                <div class="form-group">
                    <label for="passwordId">ID</label>
                    <input
                        type="text"
                        class="form-control"
                        id="passwordId"
                        disabled
                        placeholder="Masukkan ID" value="<?= $model["user"]["id"] ?>" />
                </div>
                <div class="form-group">
                    <label for="currentPassword">Sandi Sekarang</label>
                    <input
                        name="oldPassword"
                        type="password"
                        class="form-control"
                        id="currentPassword"
                        placeholder="Masukkan Sandi Sekarang" />
                </div>
                <div class="form-group">
                    <label for="newPassword">Sandi Baru</label>
                    <input
                        name="newPassword"
                        type="password"
                        class="form-control"
                        id="newPassword"
                        placeholder="Masukkan Sandi Baru" />
                </div>
                <button type="submit" class="btn btn-success btn-block">
                    Update Password
                </button>
            </form>
        </div>
    </div>
</div>