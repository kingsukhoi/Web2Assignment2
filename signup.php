<?include "inc/session.inc.php";?>
<html lang="en">
<?php
include 'inc/header.inc.php'
?>

<body>
<?
include 'components/nav.php'
?>
<div id="login" class="container">
    <form action="services/signup.php" method="post">
        <div class="row">
            <?
            if (isset($_GET['error'])) {
                ?>
                <div class="error five column"><strong>Error: </strong><?echo htmlentities($_GET['error'])?></div>
                <?
            }
            ?>
            <div class="five columns">
                <label for="Username">Firstname</label>
                <input class="u-full-width" name="firstname" type="text" placeholder="First Name" id="firstname" required>
            </div>
            <div class="five columns">
                <label for="Username">Last name</label>
                <input class="u-full-width" name="lastname" type="text" placeholder="Last Name" id="lastname" required>
            </div>
            <div class="five columns">
                <label for="city">City</label>
                <input class="u-full-width" name="city" type="text" placeholder="City" id="city" required>
            </div>
            <div class="five columns">
                <label for="country">Country</label>
                <input class="u-full-width" name="country" type="text" placeholder="Country" id="country" required>
            </div>
            <div class="five columns">
                <label for="email">Email</label>
                <!--regex from https://emailregex.com/-->
                <input class="u-full-width" name="email" type="email" placeholder="Email" id="email" required
                pattern="(?:[a-z0-9!#$%&\\x27*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\\x27*+/=?^_`{|}~-]+)*|\x22(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*\x22)@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])"
                title="username@provider.com">

            </div>
            <div class="five columns">
                <label for="pass1">Password</label>
                <input class="u-full-width" name="password" type="password" placeholder="Password" id="password" required>
            </div>
            <div class="five columns">
                <label for="pass2">Repeat Password</label>
                <input class="u-full-width" type="password" placeholder="Repeat Password" id="confirm-password" required>
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