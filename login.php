<?php
include "inc/session.inc.php";
include 'inc/header.inc'
?>
<?
include 'components/nav.php'
?>
<div id="login" class="container">
    <form action="services/login.php" method="post">
        <div class="row">
            <div class="five column error"><?echo 'Error: '. htmlentities($_GET['error'])?></div>
            <div class="five columns">
                <label for="Username">Username</label>
                <input class="u-full-width" name="username" type="text" placeholder="Username" id="Username">
            </div>
            <div class="five columns">
                <label for="Username">Password</label>
                <input class="u-full-width" name="password" type="password" placeholder="Password" id="Password">
            </div>
            <div class="two columns">
                <label for="exampleEmailInput">&nbsp;</label>
                <input class="button-primary" type="submit" value="Login">
            </div>
        </div>
    </form>
</div>


