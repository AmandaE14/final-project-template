<?php

namespace app\controllers;

use app\models\Budget;

class FeaturesController extends Controller {
    private $budgetModel;

    public function __construct() {
        $this->budgetModel = new Budget();
    }

    public function budgetPlanner() {
        $this->returnView('../public/assets/views/main/budgetPlanner.html');
    }

    public function saveBudget() {
        header('Content-Type: application/json');
        try {
            $this->budgetModel->saveBudget([
                'month' => $_POST['month'],
                'initial_balance' => $_POST['initial_balance'],
                'income' => $_POST['income'],
                'income_date' => $_POST['income_date'],
                'expense' => $_POST['expense'],
                'expense_date' => $_POST['expense_date'],
            ]);
            echo json_encode(['message' => 'Budget saved successfully!']);
            http_response_code(200);
        } catch (\Exception $e) {
            echo json_encode(['error' => 'Failed to save budget: ' . $e->getMessage()]);
            http_response_code(500);
        }
    }

    public function viewBudgetPlanner() {
        $this->returnView('../public/assets/views/main/viewBudgetPlanner.html');
    }

    public function fetchBudgets() {
        header('Content-Type: application/json');
        try {
            $budgets = $this->budgetModel->getAllBudgets();
            echo json_encode($budgets);
        } catch (\Exception $e) {
            echo json_encode(['error' => 'Failed to fetch budgets: ' . $e->getMessage()]);
            http_response_code(500);
        }
    }
}