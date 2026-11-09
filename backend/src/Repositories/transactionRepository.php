<?php
namespace App\Repositories;

use App\config\Database;
use PDO;

class transactionRepository
{
    private PDO $db;
    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function getTransaction()
    {


        $query = 'SELECT * FROM transaction';
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $resutl = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resutl;
    }



    public function postExpense(array $data)
    {

        try {
            $this->db->beginTransaction();
            $stmtWalletCheck = $this->db->prepare('SELECT balance FROM wallets WHERE id = :wallet_id AND user_id = :user_id FOR UPDATE');
            $stmtWalletCheck->execute([
                'wallet_id' => $data['wallet_id'],
                'user_id' => $data['user_id']
            ]);
            $wallet = $stmtWalletCheck->fetch(PDO::FETCH_ASSOC);

            if (!$wallet) {
                throw new \Exception("Wallet Not Found");
            }

            if (($wallet['balance'] - $data['amount']) < 0) {
                throw new \Exception('Insuficient Balance');
            }


            $queryAddExpenses = 'INSERT INTO transaction (amount, category_id, note, trx_date, type, user_id, wallet_id) VALUES (?,?,?,?,?,?,?)';
            $stmt = $this->db->prepare($queryAddExpenses);
            $transactionAddExepense = $stmt->execute(
                [
                    $data['amount'],
                    $data['category_id'],
                    $data['note'],
                    $data['trx_date'],
                    $data['type'],
                    $data['user_id'],
                    $data['wallet_id'],
                ]
            );
            if (!$transactionAddExepense) {
                throw new \Exception('Add Transaction Expense failed');
            }

            $queryUpdateWallet = 'UPDATE wallets SET balance = balance - :amount WHERE id = :wallet_id AND user_id = :user_id';
            $stmtWallet = $this->db->prepare($queryUpdateWallet);
            $updateWallets = $stmtWallet->execute([
                'amount' => $data['amount'],
                'wallet_id' => $data['wallet_id'],
                'user_id' => $data['user_id']
            ]);

            if (!$updateWallets) {
                throw new \Exception('Unnable to refress wallet');
            }

            $this->db->commit();
            return [
                'id' => $this->db->lastInsertId(),
                'message' => "Data Successfully inserted"
            ];

            //
        } catch (\Throwable $th) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            http_response_code(400);
            echo json_encode([
                'status' => 'error',
                'message' => $th->getMessage()
            ]);
            exit;
        }
    }


    public function updatedExpense(array $data)
    {
        try {
            $this->db->beginTransaction();
            $stmtWalletCheck = $this->db->prepare("SELECT balance FROM wallets WHERE id = :id AND user_id = :user_id FOR UPDATE");
            $stmtWalletCheck->execute([
                'id' => $data['wallet_id'],
                'user_id' => $data['user_id']
            ]);
            $wallet = $stmtWalletCheck->fetch(PDO::FETCH_ASSOC);

            if (!$wallet) {
                throw new \Exception('Wallet Not Found');
            }
            ;

            if (($wallet['balance'] - $data['amount']) < 0) {
                throw new \Exception('Insuficient Balance');
            }
            ;


            $query = "UPDATE transaction SET amount = :amount, category_id = :category_id, note = :note, trx_date = :trx_date, type= :type, wallet_id=:wallet_id WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $updateTransactionExpenses = $stmt->execute([
                'amount' => $data['amount'] ?? null,
                'category_id' => $data['category_id'] ?? null,
                'note' => $data['note'] ?? null,
                'trx_date' => $data['trx_date'] ?? null,
                'type' => $data['type'] ?? null,
                'id' => $data['id'],
                'wallet_id' => $data['wallet_id'] ?? null
            ]);

            if (!$updateTransactionExpenses) {
                throw new \Exception('Updated Transaction Expense failed');
            }


            $queryUpdateWallet = 'UPDATE wallets  SET balance = :balance - :amount WHERE id=:wallet_id AND user_id = :user_id';

            $stmtWallet = $this->db->prepare($queryUpdateWallet);
            $updateWallets = $stmtWallet->execute([
                'id' => $data['wallet_id'],
                'user_id' => $data['user_id']
            ]);

            if (!$updateWallets) {
                throw new \Exception('Unnable to refress wallet');
            }

            $this->db->commit();
            return [
                'id' => $this->db->lastInsertId(),
                'message' => "Data Successfully inserted"
            ];

        } catch (\Throwable $th) {
            if($this->db->inTransaction()){
                $this->db->rollBack();
            }
            http_response_code(400);
            echo json_encode([
                'status' => 'error',
                'message' => $th ->getMessage()
            ]);
        }


    }

    public function deleteExpense($id)
    {
        try {
            $query = 'DELETE FROM transaction WHERE id = :id';
            $stmt = $this->db->prepare($query);
            $stmt->execute(['id' => $id]);
            if ($stmt->rowCount() > 0) {
                return true; // Berhasil dihapus
            } else {
                return false; // ID tidak ditemukan di database
            }
            ;
        } catch (\Throwable $th) {
            return $th;
        }

    }

}
?>