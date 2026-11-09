<?php
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

require_once __DIR__ . '/../vendor/autoload.php';
// Config
require_once __DIR__ . '/../src/Config/Env.php';
require_once __DIR__ . '/../src/Config/Database.php';

// Repositories
require_once __DIR__ . '/../src/Repositories/UserRepository.php';

// Controllers
require_once __DIR__ . '/../src/Controllers/AuthController.php';

// Load .env
App\Config\Env::load(__DIR__ . '/../.env');

// Routes
require_once __DIR__ . '/../routes/api.php';