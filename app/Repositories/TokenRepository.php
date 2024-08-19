<?php


namespace App\Repositories;
use App\Models\Token;
use Illuminate\Support\Str;
use Exception;



class TokenRepository{

    protected function generateToken(){
        return Str::random(60);
    }

    public function createToken(string $tokenType, string $userId){
        try {
            Token::create([
                'user_id' => $userId,
                'type' => $tokenType,
                'token' => $this->generateToken(),
                'expires_at' => now()->addHours(1)
            ]);
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}


