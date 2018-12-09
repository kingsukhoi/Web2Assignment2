<?php
/** @noinspection ALL */
function generateNavBar($pdo = null)
{
    if (!pdo) {
        include "db/db_helper.php";
        $pdo = newConnection();
    }
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
                            <li><?
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

                            <a href="single-artist.php">
                                <li>Single Artist</li>
                            </a>
                            <a href="single-painting.php">
                                <li>Single Image</li>
                            </a>

                            <a href="single-genre.php">
                                <li>Single-Genre</li>
                            </a>
                            <a href="single-gallery.php">
                                <li>Single-Gallery</li>
                            </a>
                            <?
                            if (!Session_Singleton::SessionStarted()) {
                                ?>
                                <a href="login.php">
                                    <li>Login</li>
                                </a>
                                <a href="signup.php">
                                    <li>Sign-up</li>
                                </a>
                            <? } else { ?>
                                <a href="services/signout.php">
                                    <li>Sign Out</li>
                                </a>
                            <? } ?>

                        </ul>
                    </div>
                </nav>

                <!--</header>-->
        </div>
    </div>
<? } ?>