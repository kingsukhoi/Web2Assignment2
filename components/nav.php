<?php
/** @noinspection ALL */
?>

<div class="row one">
    <div class="two columns">
        <header>
            <nav>
                <div id="menuToggle">
                    <input type="checkbox"/>
                    <span></span>
                    <span></span>
                    <span></span>
                    <ul id="menu">
                        <img src="images/logo.png" width="256" height="256">
                        <a href="index.php">
                            <li>Home</li>
                        </a>
                        <a href="about.php">
                            <li>About</li>
                        </a>

                        <a href="single-artist.php">
                            <li>Single Artist</li>
                        </a>
                        <?
                        if(!Session_Singleton::SessionStarted()){
                            ?>
                            <a href="login.php">
                                <li>Login</li>
                            </a>
                            <a href="signup.php">
                                <li>Sign-up</li>
                            </a>
                        <?} else{
                            include "db/db_helper.php";
                            $pdo = newConnection();
                            $stmt = $pdo -> prepare(
'SELECT concat(FirstName, \' \', LastName) FROM art.Customers
WHERE CustomerID=:id');
                            $stmt->execute([':id'=>Session_Singleton::GetCustomerID()]);
                            $result = $stmt->fetch()[0];

                            ?>
                            <li>Hello <?echo htmlentities($result)?></li>
                            <a href="services/signout.php"><li>Sign Out</li></a>
                        <?}?>
                    </ul>
                </div>
            </nav>

            <!--</header>-->
    </div>
</div>