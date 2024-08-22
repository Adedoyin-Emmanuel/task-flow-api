<?php

namespace App\Http\Controllers\User;

use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;

class UserController extends Controller
{


    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getProjectManagers(Request $request)
    {
        try {
            $projectManagers = $this->userRepository->getAllProjectManagers();
            return response()->json([
                "success" => true,
                "data" => $projectManagers
            ]);
        } catch (Exception $exception) {
            return response()->json(["message" => $exception->getMessage()], 500);
        }
    }
}
