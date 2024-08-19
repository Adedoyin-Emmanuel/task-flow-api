<?php


use App\Repositories;
use Illuminate\Support\Str;
use App\Models\Token;



class TokenRepository{

    protected function generateToken(){
        return Str::random(60);
    }

    public function createToken(string $tokenType, string $userId){
        try {
            Token::create([
                'user_id' => $userId,
                'type' => $tokenType,
                'token' => $this->generateToken()
            ]);
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}


