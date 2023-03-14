<?php

namespace App\Framework;
use Exception;

function redirect($path = null) {
    if ($path === null) {
        $path = '/';
    }
    header('Location: ' . $path);
    exit;
}

function back() {
    try {
        if (isset($_SERVER['HTTP_REFERER'])) {
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            throw new Exception('No previous page to redirect to');
        }
    } catch (Exception $e) {
        // Handle the exception by redirecting to '/' and displaying an error message
        redirect('/');
        echo 'Failed redirect back - nowhere to return to';
    }
}
