<?php

namespace app\controllers;

class MainController extends Controller {

    public function homepage() {
        $this->returnView(BASE_PATH . "/public/assets/views/main/homepage.html");
    }

    public function features() {
        $viewPath = BASE_PATH . "/public/assets/views/main/features.html";
        if (!file_exists($viewPath)) {
            error_log("Features file not found at path: " . $viewPath);
            $this->notFound();
            return;
        }

        $this->returnView($viewPath);
    }

    public function notFound() {
        $this->returnView(BASE_PATH . "/public/assets/views/main/404.html");
    }

    public function returnView($viewPath) {
        if (file_exists($viewPath)) {
            include $viewPath;
        } else {
            http_response_code(404);
            error_log("View not found: $viewPath");
            echo "View not found: $viewPath";
        }
    }
}