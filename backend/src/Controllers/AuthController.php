<?php
namespace App\Controllers;


use App\Middleware\AuthMiddleware;
use App\Repositories\user_repository;
use Firebase\JWT\JWT;

class AuthController
{
    private user_repository $userRepository;
    public function __construct()
    {
        $this->userRepository = new user_repository();
    }

    public function register(): void
    {
        // Configure the response header so that it is read as JSON by the client.
        header('Content-Type: application/json');

        // accept input from body request
        $rawInput = file_get_contents('php://input');
        $data = json_decode($rawInput, true) ?? [];

        // Validation user inputs
        $name = $data['name'] ?? '';
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        if (empty($name) || empty($email) || empty($password)) {
            http_response_code(400);
            echo json_encode(
                [
                    'status' => "error",
                    'message' => 'Name, Email and Password must be filled'
                ]
            );
            return;

        }

        // Validation Email Format 
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo json_encode([
                'status' => 'error',
                'message' => 'Email format not valid'
            ]);
            return;
        }

        if (strlen($password) < 6) {
            http_response_code(400);
            echo json_encode([
                'status' => 'error',
                'message' => "Password must be six character in minimum"
            ]);
            return;
        }
        try {
            $existingUser = $this->userRepository->findUserByEmail($email);
            if ($existingUser) {
                http_response_code(409);
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Email has already been registered, please use another email'
                ]);
                return;
            }

            // hash password using the Bcrypt
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Save the new user to database 
            $newUser = $this->userRepository->createUser([
                'name' => $name,
                'email' => $email,
                'password' => $hashedPassword
            ]);

            http_response_code(201);
            echo json_encode([
                'status' => 'success',
                'message' => 'registered succesfully',
                'data' => $newUser
            ]);


        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(
                [
                    'status' => 'error',
                    'message' => 'Server error ' . $e->getMessage()
                ]
            );
        }
        ;
    }

    public function login(): void
    {
        header('Content-Type : application/json');
        $rawInput = file_get_contents("php://input");
        $data = json_decode($rawInput, TRUE) ?? [];

        $email = $data['email'] ?? "";
        $password = $data['password'] ?? "";

        if (empty($email) || empty($password)) {
            http_response_code(400);
            echo json_encode([
                'status' => 'error',
                'message' => 'Email and Password must be filled'
            ]);

            return;
        }




        $user = $this->userRepository->findUserByEmail($email);

        if (!$user || !password_verify($password, $user['password'])) {
            http_response_code(401);
            echo json_encode([
                'status' => 'error',
                'message' => 'Incorrect Email or  Password'
            ]);
            return;
        }
        ;
        // Payload for JWT Token 
        $issuedAt = time();
        $expirationTime = $issuedAt + 3600;
        $payload = [
            'iat' => $issuedAt,
            'exp' => $expirationTime,
            'data' => [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email']
            ]
        ];

        $secretKey = $_ENV['jwt_secret'];
        $jwt = JWT::encode($payload, $secretKey, 'HS256');

        setcookie('session_token', $jwt, [
            'expires' => $expirationTime,
            'path' => '/',
            'domain' => '',
            'secure' => false,
            'httponly' => true,
            'samesite' => 'lax'
        ]);

        http_response_code(200);
        echo json_encode([
            'status' => 'success',
            'message' => 'Login succesfully',
            'data' => [
                'user' => [
                    'id' => $user['id'],
                    'email' => $user['email'],
                    'name' => $user['name']
                ]
            ]
        ]);

    }
    public function profile(): void
    {
        header('Content-Type: application/json' );
        $userData =  AuthMiddleware::handle();

        http_response_code(200);
        echo json_encode([
            'status' => 'succesfully', 
            'message' => 'Authorized',
            'data' =>[
                'user' => $userData
        ]
        ]);
        exit();
    }
}
;



?>