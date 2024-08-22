<?php

namespace App\Repositories;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Exception;


class UserRepository
{

    public function getUser(string $id){

        try {
            return User::find($id);
        } catch (Exception $exception) {
            throw $exception;
        }
    }


    public function getAllProjectManagers()
    {
        try {
            return User::where('role', 'project manager')->get();
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}
