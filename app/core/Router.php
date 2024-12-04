<?php

namespace app\core;

use app\controllers\MainController;
use app\controllers\PostController;
use app\controllers\UserController;
use app\controllers\FeaturesController;

class Router {
    public $urlArray;
    private $basePath;

    public function __construct($basePath) {
        $this->basePath = $basePath;
        $this->urlArray = $this->routeSplit();
        error_log("Routing to: " . print_r($this->urlArray, true)); 
        $this->handleRoutes();
    }

    protected function routeSplit() {
        $removeQueryParams = strtok($_SERVER["REQUEST_URI"], '?');
        $trimmedPath = str_replace($this->basePath, '', $removeQueryParams);
        return array_filter(explode("/", $trimmedPath));
    }

    protected function handleRoutes() {
        $mainController = new MainController();
        $postController = new PostController();
        $userController = new UserController();
        $featuresController = new FeaturesController();

        
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            switch ($this->urlArray[0] ?? '') {
                case '':
                    $mainController->homepage();
                    break;
                case 'features':
                    $mainController->features();
                    break;
                case 'posts-add':
                    $postController->postsAdd();
                    break;
                case 'posts-view':
                    $postController->postsView();
                    break;
                case 'posts-update':
                    if (isset($_GET['id'])) {
                        $postController->postsUpdate($_GET['id']);
                    } else {
                        $mainController->notFound();
                    }
                    break;
                case 'budget-planner':
                    $featuresController->budgetPlanner();
                    break;
                case 'view-budget-planner':
                    $featuresController->viewBudgetPlanner();
                    break;
                case 'api':
                    if (isset($this->urlArray[1])) {
                        switch ($this->urlArray[1]) {
                            case 'posts':
                                $postController->getPosts();
                                break;
                            case 'budgets':
                                $featuresController->fetchBudgets();
                                break;
                            default:
                                $mainController->notFound();
                                break;
                        }
                    }
                    break;
                default:
                    $mainController->notFound();
                    break;
            }
        }
        elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($this->urlArray[0]) && $this->urlArray[0] === 'api') {
                switch ($this->urlArray[1] ?? '') {
                    case 'users':
                        if ($this->urlArray[2] === 'register') {
                            $userController->register();
                        } else {
                            http_response_code(404);
                            echo json_encode(['error' => 'Route not found.']);
                        }
                        break;
                    case 'postsAdd':
                        $postController->handlePostsAdd();
                        break;
                    case 'postsUpdate':
                        $postController->updatePost();
                        break;
                    case 'postsDelete':
                        $postController->deletePost();
                        break;
                    case 'budget':
                        $featuresController->saveBudget();
                        break;
                    default:
                        http_response_code(404);
                        echo json_encode(['error' => 'Route not found.']);
                        break;
                }
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Invalid endpoint.']);
            }
        }
    }
}