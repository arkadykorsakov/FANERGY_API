<?php

namespace App\Repositories\Interfaces;

use App\Models\User;
use App\Models\UserPostAccess;
use Illuminate\Http\UploadedFile;

interface UserPostAccessRepositoryInterface
{
    public function create(array $data):UserPostAccess;
}
