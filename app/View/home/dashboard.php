<!-- Dashboard -->
<div class="container">
    <div class="card">
        <div class="card-header text-center">
            <h5><i class="fas fa-tachometer-alt"></i> Hello, <?= $model["user"]["name"] ?></h5>
        </div>
        <div class="card-body text-center">
            <h4>Selamat datang di Pertanian Kita!</h4>
            <div class="dashboard-btn py-1">
                <a href="/user/update" class="btn btn-info btn-block">
                    <i class="fas fa-user"></i> Edit Profile
                </a>
            </div>
            <div class="dashboard-btn py-1">
                <a href="/user/update-password"  class="btn btn-warning btn-block">
                    <i class="fas fa-key"></i> Update Password
                </a>
            </div>
            <div class="dashboard-btn py-1">
                <a href="/logout" class="btn btn-danger btn-block">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </div>
</div>