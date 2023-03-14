<?php

namespace App\Framework;

use Exception;
use JetBrains\PhpStorm\NoReturn;

class Redirect {
    public static function redirect($path = null): void
    {
        if ($path === null) {
            $path = '/';
        }
        header('Location: ' . $path);
        exit;
    }

    public static function back(): void
    {
        try {
            if (isset($_SERVER['HTTP_REFERER'])) {
                self::redirect($_SERVER['HTTP_REFERER']);
            } else {
                throw new Exception('No previous page to redirect to');
            }
        } catch (Exception $e) {
            echo 'Failed redirect back at Redirect::back() - nowhere to return to';
            die();
        }
    }
}