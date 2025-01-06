<!-- Alert Message -->
<?php if (isset($model["error"])) : ?>
    <div id="alertMessage" class="alert alert-danger" role="alert">
        <?= $model["error"] ?>
    </div>
<?php endif; ?>

<!-- Login Form -->
<div class="card mb-4">
    <div class="card-header text-center">
        <h5><i class="fas fa-sign-in-alt"></i> Login</h5>
    </div>
    <div class="card-body">
        <form id="loginForm" action="/login" method="post">
            <div class="form-group">
                <label for="loginId">ID</label>
                <input
                    name="id"
                    type="text"
                    class="form-control"
                    id="loginId"
                    placeholder="Masukkan ID"
                    required />
            </div>
            <div class="form-group">
                <label for="loginPassword">Password</label>
                <input
                    name="password"
                    type="password"
                    class="form-control"
                    id="loginPassword"
                    placeholder="Masukkan Password"
                    required />
            </div>
            <button type="submit" class="btn btn-success btn-block">Login</button>
        </form>
    </div>
</div>