<?php
session_start();
session_unset();
session_destroy();
setcookie('remember_me', '', time() - (86400 * 30), "/");
header("Location: login.php");
exit();
