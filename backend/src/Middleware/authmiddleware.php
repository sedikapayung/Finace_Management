<?php 
namespace app\Middleware;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthMiddleware {
    public static function handle(): array {
        $jwt = $_COOKIE['session_token']?? null;
        
        if(!$jwt){
            http_response_code(401);
            echo json_encode([
                'status' => 'error',
                'message' => 'Unauthorized: No token rpovided'
            ]);
            exit();
        };
        try {
            $secretKey = $_ENV['jwt_secret'];
            $decodeJwt = JWT::decode($jwt, new Key($secretKey, 'HS256'));
            return (array) $decodeJwt->data;
        
        } catch (\Throwable $th) {
            http_response_code(401);
            echo json_encode([
                'status' => 'error',
                'message' => 'Unauthorized : Invalid Token'
            ]);
            exit();
        }
    }
    
}
