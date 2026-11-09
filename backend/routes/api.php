<?php
use App\Controllers\AuthController;
use App\Controllers\transactionControler;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/api/register') {
    $controler = new AuthController();
    $controler->register();
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/api/login') {
    $controler = new AuthController();
    $controler->login();
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_SERVER['REQUEST_URI'] === '/api/profile') {
    $controler = new AuthController();
    $controler->profile();
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_SERVER['REQUEST_URI'] === '/api/getAllTransaction') {
    $controler = new transactionControler();
    $controler->getAllTransaction();
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/api/addExpense') {
    $controler = new transactionControler();
    $controler->addDataExpense();
    exit();
}

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);


if ($_SERVER['REQUEST_METHOD'] === 'POST' && preg_match('#^/api/updateExpense/(\d+)$#', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), $matches)) {

    $id = $matches[1];

    $controler = new transactionControler();
    $controler->updateDataExpense($id);
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && preg_match('#^/api/deleteExpense/(\d+)$#', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), $matches)) {

    $id = $matches[1];

    $controler = new transactionControler();
    $controler->deleteExpenseData($id);
    exit();
}
?>