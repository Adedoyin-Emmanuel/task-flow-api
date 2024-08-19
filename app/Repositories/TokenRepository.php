<?php


namespace App\Repositories;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Models\Token;
use Exception;



class TokenRepository{

    protected function generateToken(){
        return Str::random(60);
    }

    public function createToken(string $tokenType, string $userId){
        try {
            $token = Token::create([
                'user_id' => $userId,
                'type' => $tokenType,
                'token' => $this->generateToken(),
                'expires_at' => now()->addHours(1)
            ]);

            return $token->token;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    public function findToken(string $token){
        try {

            return Token::where('token', $token )->where('expires_at', '>', now())->first();

        } catch (Exception $exception) {
            throw $exception;
        }
    }



    public function deleteToken(string $token){

        try {
            return Token::where('token', $token)->delete();
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}


