<?php
include "inc/session.inc.php";
include 'inc/header.inc.php'
?>
<?
include 'components/nav.php';
generateNavBar();
?>
<div id="login" class="container">
    <img src="images/logo.png" width="256" height="256" class="pull-center">
    <form action="services/login.php" method="post">
        <div>
            <div class="five column error"><?echo isset($_GET['error'])?'Error: '. htmlentities($_GET['error']):''?></div>
            <div class="five columns">
                <label for="Username">Email</label>
                <input class="u-full-width" name="email" type="email" placeholder="Email" id="email" required
                       pattern="(?:[a-z0-9!#$%&\\x27*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\\x27*+/=?^_`{|}~-]+)*|\x22(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*\x22)@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])"
                       title="username@provider.com">
            </div>
            <div class="five columns">
                <label for="Username">Password</label>
                <input class="u-full-width" name="password" type="password" placeholder="Password" id="Password" required>
            </div>
            <div class="two columns">
                <label for="exampleEmailInput">&nbsp;</label>
                <input class="button-primary" type="submit" value="Login">
            </div>
        </div>
    </form>
</div>


