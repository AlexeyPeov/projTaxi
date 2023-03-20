<?php
namespace App;
csrf();
include __DIR__ . "/../app.php";
?>
<style>
    fieldset {
        margin: 15 20px;
    }
</style>

<form id = "register" method="POST" action="/taxidriver/create">
    <input type="hidden" name="_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    <div class="form-container" style="display: flex;">
        <fieldset>
            <legend>Driver</legend>
            <label for="firstName"> First Name </label><br>
            <input type="text" name="firstName" value="<?php echo isset($_SESSION['old']['firstName']) ? htmlspecialchars($_SESSION['old']['firstName'], ENT_QUOTES) : ''; ?>"/>
                <?php if (isset($_SESSION['errors']['firstName'])): ?>
            <p class="text-red-500 text-xs mt-1"><?php echo $_SESSION['errors']['firstName']; ?></p>
            <?php endif; ?>

            <label for="secondName"> Second Name </label><br>
            <input type="text" name="secondName" value="<?php echo isset($_SESSION['old']['secondName']) ? htmlspecialchars($_SESSION['old']['secondName'], ENT_QUOTES) : ''; ?>"/>
                <?php if (isset($_SESSION['errors']['secondName'])): ?>
            <p class="text-red-500 text-xs mt-1"><?php echo $_SESSION['errors']['secondName']; ?></p>
            <?php endif; ?>

            <label for="phoneNumber">Phone Number</label><br>
            <input type="text" name="phoneNumber" id = "phoneNumber" value="<?php echo isset($_SESSION['old']['phoneNumber']) ? htmlspecialchars($_SESSION['old']['phoneNumber'], ENT_QUOTES) : ''; ?>"/>
                <?php if (isset($_SESSION['errors']['phoneNumber'])): ?>
            <p class="text-red-500 text-xs mt-1"><?php echo $_SESSION['errors']['phoneNumber']; ?></p>
            <?php endif; ?>

            <label for="birthday">Day of Birth</label><br>
            <input type="date" name="birthday" value="<?php echo isset($_SESSION['old']['birthday']) ? htmlspecialchars($_SESSION['old']['birthday'], ENT_QUOTES) : ''; ?>"/>

                <?php if (isset($_SESSION['errors']['birthday'])): ?>
            <p class="text-red-500 text-xs mt-1"><?php echo $_SESSION['errors']['birthday']; ?></p>
            <?php endif; ?>
        </fieldset>

        <fieldset>
            <legend>Car</legend>
            <label for="brand">Brand</label><br>
            <input type="text" name="brand" value="<?php echo isset($_SESSION['old']['brand']) ? htmlspecialchars($_SESSION['old']['brand'], ENT_QUOTES) : ''; ?>"/>
                <?php if (isset($_SESSION['errors']['brand'])): ?>
            <p class="text-red-500 text-xs mt-1"><?php echo $_SESSION['errors']['brand']; ?></p>
            <?php endif; ?>

            <label for="plates">Plates</label><br>
            <input type="text" name="plates" value="<?php echo isset($_SESSION['old']['plates']) ? htmlspecialchars($_SESSION['old']['plates'], ENT_QUOTES) : ''; ?>"/>
                <?php if (isset($_SESSION['errors']['plates'])): ?>
            <p class="text-red-500 text-xs mt-1"><?php echo $_SESSION['errors']['plates']; ?></p>
            <?php endif; ?>
            <label for="color">Color</label><br>
            <input type="text" name="color" value="<?php echo isset($_SESSION['old']['color']) ? htmlspecialchars($_SESSION['old']['color'], ENT_QUOTES) : ''; ?>"/>
            <?php if (isset($_SESSION['errors']['color'])): ?>
                <p class="text-red-500 text-xs mt-1"><?php echo $_SESSION['errors']['color']; ?></p>
            <?php endif; ?>
            <label for="carClass">Car Class</label><br>
            <input type="number" name="carClass" value="<?php echo isset($_SESSION['old']['carClass']) ? htmlspecialchars($_SESSION['old']['carClass'], ENT_QUOTES) : ''; ?>"/>
            <?php if (isset($_SESSION['errors']['carClass'])): ?>
                <p class="text-red-500 text-xs mt-1"><?php echo $_SESSION['errors']['carClass']; ?></p>
            <?php endif; ?>
        </fieldset>
    </div>

    <fieldset style="display: inline-block">
        <label for="password">
            Password
        </label><br>
        <input type="password" name="password"
               value="<?php echo isset($_SESSION['old']['password']) ? htmlspecialchars($_SESSION['old']['password'], ENT_QUOTES) : ''; ?>"/>

            <?php if (isset($_SESSION['errors']['password'])): ?>
        <p class="text-red-500 text-xs mt-1"><?php echo $_SESSION['errors']['password']; ?></p>
        <?php endif; ?>


        <label for="password2">
            Confirm Password
        </label><br>
        <input type="password" name="password_confirmation"
               value="<?php echo isset($_SESSION['old']['password_confirmation']) ? htmlspecialchars($_SESSION['old']['password_confirmation'], ENT_QUOTES) : ''; ?>"/>

            <?php if (isset($_SESSION['errors']['password_confirmation'])): ?>
        <p class="text-red-500 text-xs mt-1"><?php echo $_SESSION['errors']['password_confirmation']; ?></p>
        <?php endif; ?>
    </fieldset>

    <fieldset style="display: inline-block">
        <button type="submit" class="bg-laravel text-white rounded py-2 px-4 hover:bg-black">
            Sign Up
        </button>

        <p>
            Already have an account?
            <a href="/taxidriver/login" class="text-laravel">Login</a>
        </p>
    </fieldset>
</form>
<script src="/public/resources/js/parsePhoneNumber.js"></script>
    <?php
    include __DIR__ . "/../footer.php";
    ?>