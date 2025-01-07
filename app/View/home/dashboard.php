<!-- Dashboard -->
<div class="container">
    <div class="card">
        <div class="card-header text-center">
            <h5><i class="fas fa-tachometer-alt"></i> Hello, <?= $model["user"]["name"] ?></h5>
        </div>
        <div class="card-body text-center">
            <h4>Selamat datang di Pertanian Kita!</h4>
            <div class="dashboard-btn py-1">
                <button class="btn btn-info btn-block" onclick="showProfile()">
                    <i class="fas fa-user"></i> Show Profile
                </button>
            </div>
            <div class="dashboard-btn py-1">
                <button class="btn btn-warning btn-block" onclick="updatePassword()">
                    <i class="fas fa-key"></i> Update Password
                </button>
            </div>
            <div class="dashboard-btn py-1">
                <button class="btn btn-danger btn-block" onclick="logout()">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </div>
        </div>
    </div>
</div>