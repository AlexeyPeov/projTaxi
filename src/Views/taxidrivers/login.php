<?php
namespace App;
csrf();
include __DIR__ . "/../app.php";
?>

<div class="center" style="scale: 150%">
    <div class="form-container" style="display: flex;">
        <form method="POST" id = "login" action="/taxidriver/authenticate">
            <input type="hidden" name="_token" value="<?php echo $_SESSION['csrf_token']; ?>">

            <label for="phoneNumber">Phone Number</label>
            <input type="text" name="phoneNumber" id = "phoneNumber" value="<?php echo isset($_SESSION['old']['phoneNumber']) ? htmlspecialchars($_SESSION['old']['phoneNumber'], ENT_QUOTES) : ''; ?>"/>

            <?php if (isset($_SESSION['errors']['phoneNumber'])): ?>
            <p class="text-red-500 text-xs mt-1"><?php echo $_SESSION['errors']['phoneNumber']; ?></p>
            <?php endif; ?>

            <label for="password" class="inline-block text-lg mb-2">
                Password
            </label>
            <input type="password" class="border border-gray-200 rounded p-2 w-full" name="password"
                   value="<?php echo isset($_SESSION['old']['password']) ? htmlspecialchars($_SESSION['old']['password'], ENT_QUOTES) : ''; ?>"/>

            <?php if (isset($_SESSION['errors']['password'])): ?>
            <p class="text-red-500 text-xs mt-1"><?php echo $_SESSION['errors']['password']; ?></p>
            <?php endif; ?>

            <div class="mb-6">
                <button type="submit" id = "submit" class="bg-laravel text-white rounded py-2 px-4 hover:bg-black">
                    Sign In
                </button>
            </div>

            <div class="mt-8">
                <p>
                    Don't have an account?
                    <a href="/taxidriver/signup" class="text-laravel">Sign Up</a>
                </p>
            </div>
        </form>
    </div>
</div>

<script src="/public/resources/js/parsePhoneNumber.js"></script>


<?php
include __DIR__ . "/../footer.php";
?>