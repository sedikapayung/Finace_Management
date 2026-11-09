<?php
require_once __DIR__ . '/../src/Config/Env.php';
require_once __DIR__ . '/../src/Config/Database.php';

use App\Config\Env;
use App\Config\Database;

Env::load(__DIR__ . '/../.env');

try {
    $db = Database::getConnection();
    
    // Otomatis mencari semua file berformat .sql di dalam folder migrations
    $migrationFiles = glob(__DIR__ . '/migrations/*.sql');

    if (empty($migrationFiles)) {
        echo "Tidak ada file migrasi yang ditemukan.\n";
        exit;
    }

    foreach ($migrationFiles as $filePath) {
        // Mengambil nama file saja dari path lengkapnya (untuk ditampilkan di pesan echo)
        $migrationFile = basename($filePath);
        
        if (file_exists($filePath)) {
            $sql = file_get_contents($filePath);
            $db->exec($sql);
            echo "Migration Execution Successfully : {$migrationFile}\n";
        }
    }

    echo "Migration database succesfully \n";

} catch (Exception $e) {
    echo "Migration database fail: " . $e->getMessage();
}
?>