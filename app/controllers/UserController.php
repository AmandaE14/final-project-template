<?php

namespace app\controllers;

use app\models\User;

class UserController extends Controller {
    public function register() {
        header('Content-Type: application/json');

        try {
            error_log("UserController::register called");

            if (empty($_POST['username']) || empty($_POST['password'])) {
                http_response_code(400);
                echo json_encode(['error' => 'Username and password cannot be empty.']);
                return;
            }

            $username = htmlspecialchars(trim($_POST['username']));
            $password = trim($_POST['password']);

            if (strlen($password) < 6 || !preg_match('/[^a-zA-Z0-9]/', $password)) {
                http_response_code(400);
                echo json_encode(['error' => 'Password must be at least 6 characters long and include a special character.']);
                return;
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $user = new User();
            $user->create(['username' => $username, 'password' => $hashedPassword]);

            http_response_code(200);
            echo json_encode(['success' => 'User registered successfully!']);
        } catch (\Exception $e) {
            error_log("Error in register: " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error.']);
        }
    }
}