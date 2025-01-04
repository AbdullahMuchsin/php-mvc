<!-- Alert Message -->
<?php if (isset($model["error"])) : ?>
    <div id="alertMessage" class="alert alert-danger" role="alert">
        <?= $model["error"] ?>
    </div>
<?php endif; ?>

<!-- Register Form -->
<div class="card" id="registerCard">
    <div class="card-header text-center">
        <h5><i class="fas fa-user-plus"></i> Register</h5>
    </div>
    <div class="card-body">
        <form id="registerForm" action="/register" method="post">
            <div class="form-group">
                <label for="registerId">ID</label>
                <input
                    name="id"
                    type="text"
                    class="form-control"
                    id="registerId"
                    placeholder="Masukkan ID" value="<?= $_POST["id"] ?? "" ?>" />
            </div>
            <div class="form-group">
                <label for="registerName">Nama</label>
                <input
                    name="name"
                    type="text"
                    class="form-control"
                    id="registerName"
                    placeholder="Masukkan Nama" value="<?= $_POST["name"] ?? "" ?>" />
            </div>
            <div class="form-group">
                <label for="registerPassword">Password</label>
                <input
                    name="password"
                    type="password"
                    class="form-control"
                    id="registerPassword"
                    placeholder="Masukkan Password" value="<?= $_POST["password"] ?? "" ?>" />
            </div>
            <button type="submit" class="btn btn-success btn-block">Register</button>
        </form>
        <div class="text-center mt-3">
            <p>
                Sudah punya akun?
                <a href="#" class="text-success" onclick="showLogin()">Login di sini</a>
            </p>
        </div>
    </div>
</div>