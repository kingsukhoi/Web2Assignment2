<html lang="en">
<?php
include 'inc/header.inc'
?>

<body>
<?
include 'components/nav.php'
?>
<div id="login" class="container">
    <form action="services/signup.php" method="post">
        <div class="row">
            <div class="five columns">
                <label for="Username">Firstname</label>
                <input class="u-full-width" name="firstname" type="text" placeholder="First Name" id="firstname">
            </div>
            <div class="five columns">
                <label for="Username">Last name</label>
                <input class="u-full-width" name="lastname" type="text" placeholder="Last Name" id="lastname">
            </div>
            <div class="five columns">
                <label for="city">City</label>
                <input class="u-full-width" name="city" type="text" placeholder="City" id="city">
            </div>
            <div class="five columns">
                <label for="country">Country</label>
                <input class="u-full-width" name="country" type="text" placeholder="Country" id="country">
            </div>
            <div class="five columns">
                <label for="email">Email</label>
                <input class="u-full-width" name="email" type="text" placeholder="Email" id="email">

            </div>
            <div class="five columns">
                <label for="pass1">Password</label>
                <input class="u-full-width" name="password" type="password" placeholder="Password" id="pass1">
            </div>
            <div class="five columns">
                <label for="pass2">Repeat Password</label>
                <input class="u-full-width" type="password" placeholder="Repeat Password" id="pass2">
            </div>
            <div class="two columns">
                <label for="exampleEmailInput">&nbsp;</label>
                <input class="button-primary" type="submit" value="Sign up">
            </div>
        </div>
    </form>
</div>
<script src="js/signup.js"></script>
</body>

</html>