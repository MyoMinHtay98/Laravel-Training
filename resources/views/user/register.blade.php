@extends('layout')

@section('content')
<div class="container">
    <form action="register.php" method="POST" class="login-email">
        <p class="login-text" style="font-size: 2rem; font-weight: 800;">Register</p>
        <div class="input-group">
            <input type="text" placeholder="Name" name="name" required>
            <?php
            if (isset($errors['name'])) {
                echo "<span>" . $errors['name'] . "</span>";
            }
            ?>
        </div>
        <div class="input-group">
            <input type="text" placeholder="Email" name="email" required>
            <?php
            if (isset($errors['email'])) {
                echo "<span>" . $errors['email'] . "</span>";
            }
            ?>
        </div>
        <div class="input-group">
            <input type="password" placeholder="Password" minlength="8" maxlength="8" name="password" required>
            <?php
            if (isset($errors['password'])) {
                echo "<span>" . $errors['password'] . "</span>";
            }
            ?>
        </div>
        <div class="input-group">
            <input type="datetime-local" name="dob" required>
            <?php
            if (isset($errors['dob'])) {
                echo "<span>" . $errors['dob'] . "</span>";
            }
            ?>
        </div>
        <div class="form-group">
            <label for="gender">Gender</label>
            <label><input type="radio" name="gender" value="Male" />Male</label>
            <label><input type="radio" name="gender" value="Female" />Female</label>
            <?php
            if (isset($errors['gender'])) {
                echo "<span>" . $errors['gender'] . "</span>";
            }
            ?>
        </div>
        <div class="input-group">
            <input type="text" placeholder="Phone Number" name="phno" required>
            <?php
            if (isset($errors['phno'])) {
                echo "<span>" . $errors['phno'] . "</span>";
            }
            ?>
        </div>
        <div class="input-group">
            <input type="text" placeholder="Address" name="address" required>
            <?php
            if (isset($errors['address'])) {
                echo "<span>" . $errors['address'] . "</span>";
            }
            ?>
        </div>
        <div class="input-group">
            <button name="save" class="btn">Register</button>
        </div>
        <p class="login-register-text">Have an account? <a href="../login.php">Login Here</a>.</p>
    </form>
</div>
@endsection