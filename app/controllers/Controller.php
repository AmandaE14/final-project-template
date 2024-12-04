<?php

namespace app\controllers;

abstract class Controller {

    public function returnView($pathToView) {
        if (file_exists($pathToView)) {
            require $pathToView;
            exit();
        } else {
            http_response_code(404);
            echo "View not found: " . htmlspecialchars($pathToView);
            exit();
        }
    }

    public function returnJSON($json) {
        header("Content-Type: application/json");
        echo json_encode($json);
        exit();
    }

    protected function render($viewPath) {
        $fullPath = dirname(__DIR__) . "/views/$viewPath";
        if (file_exists($fullPath)) {
            require $fullPath;
            exit();
        } else {
            http_response_code(404);
            echo "View not found: " . htmlspecialchars($viewPath);
            exit();
        }
    }
}