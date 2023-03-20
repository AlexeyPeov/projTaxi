<?php

namespace App\Models;
use DateTime;

class TaxiDriver
{
    public static function displayRating(int $reviewsGiven, int $rating, int $reviewHeap): ?int
    {
        if ($reviewsGiven > 9) {
            return $reviewHeap / $reviewsGiven;
        }
        return null;
    }

    public static function validateCreation (array $post) {
        $errors = []; // $errors = TaxiDriver::validateCreation();

        // Validate Taxi Driver fields
        if (empty($_POST['firstName']) || strlen($_POST['firstName']) < 3) {
            $errors['firstName'] = 'The first name must be at least 3 characters.';
        }

        if (empty($_POST['secondName']) || strlen($_POST['secondName']) < 3) {
            $errors['secondName'] = 'The second name must be at least 3 characters.';
        }

        if (empty($_POST['birthday'])) {
            $errors['birthday'] = 'The birthday field is required.';
        } elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $_POST['birthday'])) {
            $errors['birthday'] = 'The birthday is not a valid date.';
        } elseif (strtotime($_POST['birthday']) >= strtotime('-18 years')) {
            $errors['birthday'] = 'You must be at least 18 years old.';
        }

        if (empty($_POST['phoneNumber'])) {
            $errors['phoneNumber'] = 'The phone number field is required.';
        } elseif (!preg_match('/^([0-9\s\-\+\(\)]*)$/', $_POST['phoneNumber']) || strlen($_POST['phoneNumber']) < 10 || strlen($_POST['phoneNumber']) > 19) {
            $errors['phoneNumber'] = 'The phone number must be between 10 and 19 characters and only contain numbers, spaces, and these characters: -+().';
        }

        if (empty($_POST['password'])) {
            $errors['password'] = 'The password field is required.';
        } elseif (strlen($_POST['password']) < 6) {
            $errors['password'] = 'The password must be at least 6 characters.';
        } elseif ($_POST['password'] !== $_POST['password_confirmation']) {
            $errors['password_confirmation'] = 'The password confirmation does not match.';
        }

        // Validate Car fields
        if (empty($_POST['brand'])) {
            $errors['brand'] = 'The brand field is required.';
        }

        if (empty($_POST['plates'])) {
            $errors['plates'] = 'The plates field is required.';
        }

        if (empty($_POST['color'])) {
            $errors['color'] = 'The color field is required.';
        }

        if (empty($_POST['carClass'])) {
            $errors['carClass'] = 'The car class field is required.';
        } elseif (!is_numeric($_POST['carClass']) || $_POST['carClass'] < 1 || $_POST['carClass'] > 3) {
            $errors['carClass'] = 'The car class must be an integer between 1 and 3.';
        }
    }


}