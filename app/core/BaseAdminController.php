<?php
// app/core/BaseAdminController.php

abstract class BaseAdminController extends Controller
{
    protected function requireAdminAuth($jsonResponse = false): void
    {
        if (!Auth::isLoggedIn() || !$this->isAdmin()) {
            if ($jsonResponse) {
                $this->jsonError('Unauthorized access');
            }
            $this->redirect('admin', 'login');
        }
    }

    protected function isAuthenticatedAndAdmin(): bool
    {
        return Auth::isLoggedIn() && $this->isAdmin();
    }

    protected function isAdmin(): bool
    {
        $user = Auth::getUser();
        return $user && in_array($user['role'] ?? '', ['admin', 'manager', 'staff']);
    }

    protected function redirect($controller, $action = '', $params = []): void
    {
        $url = $this->buildUrl($controller, $action, $params);
        header('Location: ' . $url);
        exit;
    }

    protected function buildUrl($controller, $action = '', $params = []): string
    {
        $url = "index.php?controller=$controller";
        if ($action) $url .= "&action=$action";
        foreach ($params as $key => $value) {
            $url .= "&$key=" . urlencode($value);
        }
        return $url;
    }

    protected function isPostRequest(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    protected function jsonResponse(): void
    {
        header('Content-Type: application/json');
    }

    protected function jsonError(string $message, bool $refreshCaptcha = false): void
    {
        $response = ['success' => false, 'message' => $message];
        if ($refreshCaptcha) {
            $response['refresh_captcha'] = true;
        }
        echo json_encode($response);
        exit;
    }

    protected function jsonSuccess(string $message, array $extra = []): void
    {
        echo json_encode(array_merge(['success' => true, 'message' => $message], $extra));
        exit;
    }

    protected function setFlashMessage(string $type, string $message): void
    {
        $_SESSION[$type] = $message;
    }

    protected function getPost(string $key, $filter = null)
    {
        $value = $_POST[$key] ?? '';
        
        if ($filter === 'trim') {
            return trim($value);
        }
        
        return $value;
    }

    protected function generateCsrfToken(): void
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
    }

    protected function generateAdminCsrfToken(): void
    {
        if (empty($_SESSION['admin_csrf_token'])) {
            $_SESSION['admin_csrf_token'] = bin2hex(random_bytes(32));
        }
    }

    protected function validateCsrfToken($token): bool
    {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }

    protected function validateAdminCsrfToken($token): bool
    {
        return isset($_SESSION['admin_csrf_token']) && hash_equals($_SESSION['admin_csrf_token'], $token);
    }

    protected function generateCaptcha(): void
    {
        $_SESSION['admin_num1'] = rand(10, 20);
        $_SESSION['admin_num2'] = rand(5, 15);
        $_SESSION['admin_math_answer'] = $_SESSION['admin_num1'] + $_SESSION['admin_num2'];
    }

    protected function validateCaptcha(int $userAnswer): bool
    {
        $captchaAnswer = $_SESSION['admin_math_answer'] ?? 0;
        return $userAnswer === $captchaAnswer;
    }

    protected function logActivity($userId, $action, $details): void
    {
        if (property_exists($this, 'logModel')) {
            $this->logModel->logActivity($userId, $action, $details);
        }
    }

    protected function destroySession(): void
    {
        session_unset();
        session_destroy();
    }
}