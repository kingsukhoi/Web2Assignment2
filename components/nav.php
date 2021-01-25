<?php
/** @noinspection ALL */
function generateNavBar()
{
    ?>

    <!--    <div class="row one">-->

    <nav>
        <div id="menuToggle">
            <input type="checkbox"/>
            <span></span>
            <span></span>
            <span></span>
            <ul id="menu">
                <img src="images/logo.png" width="256" height="256">
                <li><?php
                    if (Session_Singleton::SessionStarted()) {
                        $pdo = newConnection();
                        $stmt = $pdo->prepare(
                            'SELECT concat(FirstName, \' \', LastName) FROM art.Customers
WHERE CustomerID=:id');
                        $stmt->execute([':id' => Session_Singleton::GetCustomerID()]);
                        $result = $stmt->fetch()[0];
                        echo "Hello $result" . '!!';
                        $pdo = null;
                    }
                    ?></li>
                <a href="index.php">
                    <li>Home</li>
                </a>
                <a href="about.php">
                    <li>About</li>
                </a>
                <?php
                if (!Session_Singleton::SessionStarted()) {
                    ?>
                    <a href="login.php">
                        <li>Login</li>
                    </a>
                    <a href="signup.php">
                        <li>Sign-up</li>
                    </a>
                <?php } else { ?>
                    <a href="favorites.php">
                        <li>Favorites</li>
                    </a>
                    <a href="services/signout.php">
                        <li>Sign Out</li>
                    </a>
                <?php } ?>

            </ul>
        </div>
    </nav>
    <!--    </div>-->
<?php } ?>