<?php
namespace App\Repositories;

use App\config\Database;
use PDO;

class user_repository
{
    private PDO $db;
    public function __construct()
    {
        $this->db = Database::getConnection();
    }


    #Find user by email -> using for ensure email is unique
    public function findUserByEmail(string $email): ?array
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => $email]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    public function createUser(array $data): array
    {

        $this->db->beginTransaction();
        $sql = "INSERT INTO users (name, email, password) VALUES (:name,:email, :password) RETURNING *";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['name' => $data['name'], 'email' => $data['email'], 'password' => $data['password']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        $sqlWallet = "INSERT INTO wallets (user_id, name, type, initial_balance) VALUES (:user_id, :name, :type, :initial_balance)";
        $stmtWallet = $this->db->prepare($sqlWallet);
        $stmtWallet-> execute([
        'user_id' => $user['id'],
        'name' => "Cash",
        'type' => 'cash',
        'initial_balance' => 0.00
        ]);
        $this->db->commit();

        return $user;
    }


}

?>