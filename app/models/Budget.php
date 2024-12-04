<?php

namespace app\models;

use PDO;
use PDOException;

class Budget extends Model {
    protected $table = 'budget';
    private $pdo;

    public function __construct() {
        $this->pdo = $this->connect();
    }

    private function connect() {
        $host = $_ENV['DBHOST'] ?? 'localhost'; 
        $db = $_ENV['DBNAME'] ?? 'finance_tracker';
        $user = $_ENV['DBUSER'] ?? 'root';
        $pass = $_ENV['DBPASS'] ?? 'root';
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            return new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function saveBudget($data) {
        $stmt = $this->pdo->prepare("INSERT INTO {$this->table} (month, initial_balance, income, income_date, expense, expense_date) 
                  VALUES (:month, :initial_balance, :income, :income_date, :expense, :expense_date)");
        $stmt->execute($data);
    }

    public function getAllBudgets() {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table}");
        $stmt->execute();
        return $stmt->fetchAll();
    }
}