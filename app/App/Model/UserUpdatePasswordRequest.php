<?php

namespace AbdullahMuchsin\BelajarPhpLoginManagement\App\Model;

class UserUpdatePasswordRequest {
    public string $id;
    public string $oldPassword;
    public string $newPassword;
}