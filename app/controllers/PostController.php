<?php

namespace app\controllers;

use app\models\Post;

class PostController extends Controller {
    public function postsAdd() {
        $this->returnView(BASE_PATH . "/public/assets/views/posts/postsAdd.html");
    }

    public function handlePostsAdd() {
        $post = new Post();
        $data = [
            'title' => $_POST['title'] ?? '',
            'content' => $_POST['content'] ?? ''
        ];

        if (empty($data['title']) || empty($data['content'])) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Title and content are required.']);
            return;
        }

        $result = $post->create($data);
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Post added successfully!']);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => 'Failed to add the post.']);
        }
    }

    public function postsView() {
        $this->returnView(BASE_PATH . "/public/assets/views/posts/postsView.html");
    }

    public function getPosts() {
        $post = new Post();
        header('Content-Type: application/json'); 
        try {
            $posts = $post->getAllPosts();
            echo json_encode($posts);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to fetch posts.']);
        }
    }

    public function postsUpdate($id) {
        $post = new Post();
        $postData = $post->getPostById($id);
        $this->returnView(BASE_PATH . "/public/assets/views/posts/postsUpdate.html", ['postData' => $postData]);
    }

    public function updatePost() {
        $id = $_POST['post_id'] ?? null;
        $title = $_POST['title'] ?? null;
        $content = $_POST['content'] ?? null;

        $post = new Post();
        $result = $post->update($id, $title, $content);
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Post updated successfully!']);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => 'Failed to update the post.']);
        }
    }

    public function deletePost() {
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'] ?? null;

        if (!$id) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'ID is required']);
            return;
        }

        $post = new Post();
        $result = $post->delete($id);
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Post deleted successfully!']);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => 'Failed to delete the post.']);
        }
    }
}