<?php
namespace App\Controllers;


use App\Framework\Redirect;

class TaxiDriverController
{
    public function index (){
        signedIn() ? require 'index' : require 'signup';

        return view('taxidrivers.index');
    }

    public function auth() {
        require __DIR__ . '/../Views/taxidrivers/auth.php';
    }


    // Show Login Form
    public function login() {
        require __DIR__ . '/../Views/taxidrivers/login.php';
    }

    public function signup() {

        require __DIR__ . '/../Views/taxidrivers/signup.php';
    }

    public function create (){

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $_SESSION['old'] = $_POST;
                Redirect::back();
                exit;
            }

            // Hash Password
            if (empty($errors)) {
                $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
            }
        }

        unset($_SESSION['errors']);
        unset($_SESSION['old']);

    }

    // Create New User
    public function store(Request $request) {
        $formFieldsTaxiDriver = $request->validate([
            'firstName' => ['required', 'min:3'],
            'secondName' => ['required', 'min:3'],
            'birthday' => ['required', 'date', 'before:' . Carbon::now()->subYears(18)->toDateString()],
            'phoneNumber' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:19',
            'password' => 'required|confirmed|min:6',

        ]);
        $formFieldsCar = $request->validate([
            'brand'=> ['required','string'],
            'plates'=> ['required','string'],
            'color'=> ['required','string'],
            'carClass'=> ['required','integer','between:1,3'],

        ]);
        // Hash Password
        $formFieldsTaxiDriver['password'] = bcrypt($formFieldsTaxiDriver['password']);

        $car = Car::create($formFieldsCar);
        $formFieldsTaxiDriver['carDriving'] = $car->id;
        // Create TaxiDriver
        $taxiDriver = TaxiDriver::create($formFieldsTaxiDriver);

        // Login
        auth()->login($taxiDriver);
        return redirect()->route('taxidriver.show', ['id' => $taxiDriver->id])
            ->with('message', 'Your account has been created, you are logged in');
    }

    public function show(int $id) {
        if($id!= auth()->id()) {
            abort(403, 'Unauthorized Action');
        } else {
            $taxiDriver = TaxiDriver::find(auth()->id())->getAttributes();
            $car = Car::find($taxiDriver['carDriving']);
            $orders = Order::where('class', $car->carClass)->where('orderStatus', Order::STATE_NEW)->get();
            $hisOrders = Order::where('taxiDriverId', $taxiDriver['id'])
                ->whereIn('orderStatus', [Order::STATE_ACCEPTED, Order::STATE_IN_PROGRESS])
                ->get();

            return view('taxidrivers.show', [
                'taxiDriver' => $taxiDriver,
                'orders' => $orders,
                'hisOrders' => $hisOrders,
                'car' => $car,
            ]);
        }

    }

    // Authenticate TaxiDriver
    public function authenticate(Request $request) {
        $formFields = $request->validate([
            'phoneNumber' => 'required',//|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'password' => 'required'
        ]);
        $taxiDriver = TaxiDriver::where('phoneNumber', $formFields['phoneNumber'])->first();
        if(auth()->attempt($formFields)) {
            $request->session()->regenerate();

            return redirect()->route('taxidriver.show', ['id' => $taxiDriver->id])
                ->with('message', 'Your account has been created, you are logged in');
        }

        return back()->withErrors(['phoneNumber' => 'Invalid Credentials'])->onlyInput('phoneNumber');
    }
    public function logout(Request $request) {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('taxidriver')->with('message', 'You have been logged out!');

    }
}
