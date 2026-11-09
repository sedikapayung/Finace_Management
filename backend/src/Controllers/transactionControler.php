<?php
namespace App\Controllers;


use App\Middleware\AuthMiddleware;
use App\Repositories\transaction;
use App\Repositories\transactionRepository;

class transactionControler
{

    private transactionRepository $transaction;
    protected array $userData;
    protected int $currentUserId;

    public function __construct()
    {
        $this->transaction = new transactionRepository();
        $this->userData = AuthMiddleware::handle();

        $this->currentUserId = (int) ($this->userData['id'] ?? $this->userData['user_id'] ?? null);

    }

    public function getAllTransaction()
    {

        $data = $this->transaction->getTransaction();

        header('Content-Type: application/json');

        if ($data) {
            http_response_code(200);
            echo json_encode([
                'status' => 'succussfully',
                'data' => $data
            ]);
        } else {
            http_response_code(404);
            echo json_encode([
                'status' => 'error',
                'message' => 'data not found'
            ]);
        }
        ;
    }


    public function addDataExpense(): void
    {

        header('Content-Type: aplication/json');
        $input = file_get_contents('php://input');
        $data = json_decode($input, true) ?? [];
        if (!is_array($data)) {
            http_response_code(400);
            echo json_encode([
                'status' => 'error',
                'message' => 'Invalid JSON payload provided'
            ]);
            return;
        }
        $requiredFileds = ['amount', 'category_id', 'trx_date', 'type', 'wallet_id'];

        $emptyField = [];

        // data validation

        foreach ($requiredFileds as $fields) {
            if (empty($data[$fields])) {
                $emptyField[] = $fields;
            }
            ;
        }
        if (!empty($emptyField)) {
            http_response_code(400);
            echo json_encode([
                'status' => 'error',
                'message' => 'Several data required fill',
                'data' => $emptyField
            ]);

        }


        $expenseData = [
            'amount' => (float) $data['amount'],
            'category_id' => (int) $data['category_id'],
            'note' => isset($data['note']) ? htmlspecialchars($data['note']) : null,
            'trx_date' => $data['trx_date'],
            'type' => htmlspecialchars($data['type']),
            'user_id' => (int) $this->currentUserId,
            'wallet_id' => (int) $data['wallet_id'],
        ];
        $result = $this->transaction->postExpense($expenseData);
        if ($result) {
            http_response_code(201);
            echo json_encode([
                'status' => 'succesfully',
                'Message' => 'created expense data succsesfully',
                'data' => [
                    'data' => $result
                ]
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                'status' => 'failed',
                'message' => 'Failed to insert expense to the database',

            ]);
        }

    }

    public function updateDataExpense($id)
    {
        header('Content-Type: application/json');

        $input = file_get_contents('php://input');
        $data = json_decode($input, true) ?? [];


        if (!is_array($data)) {
            http_response_code(400);
            echo json_encode([
                'status' => 'error',
                'message' => "Invalid json payload provided"
            ]);
        }

        $requiredcolom = ['amount', 'category_id', 'trx_date', 'type', 'wallet_id'];

        $empty_value = [];

        foreach ($requiredcolom as $required) {
            if (empty($data[$required])) {
                $empty_value[] = $required;
            }
            ;
        }
        ;

        if (!empty($empty_value)) {
            http_response_code(400);
            echo json_encode([
                'status' => 'error',
                'message' => 'several fields required',
                'data' => $empty_value
            ]);
        }
        $ExpensesDataUpdate = [
            'amount' => (float) $data['amount'],
            'category_id' => (int) $data['category_id'],
            'note' => isset($data['note']) ? htmlspecialchars($data['note']) : null,
            'trx_date' => $data['trx_date'],
            'type' => htmlspecialchars($data['type']),
            'wallet_id' => (int) $data['wallet_id'],
            'id' => (int) $id
        ];

        $result = $this->transaction->updatedExpense($ExpensesDataUpdate);

        try {
            if ($result) {
                http_response_code(200);
                echo json_encode([
                    'status' => 'succesfully',
                    'message' => 'Expenses succesfully updated',
                    'data' => $result
                ]);
            } else {
                http_response_code(500);
                echo json_encode([
                    'status' => 'error',
                    'message' => $result
                ]);
            }
        } catch (\Throwable $th) {
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => $th
            ]);
        }
    }

    public function deleteExpenseData($id)
    {
        header('Content-Type : apllication/json');
        try {
            $result = $this->transaction->deleteExpense($id);
            if($result){
                http_response_code(200);
                echo json_encode([
                    'status' => 'succesfully',
                    'message' => 'Data succesfully deleted'
                ]);
            } else {
                http_response_code(404);
                echo json_encode([
                    'status' => 'error',
                    'message' => 'the data has been deleted'
                ]);
            }
        } catch (\Throwable $th) {
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => $th
            ]);
        }

    }
}
?>