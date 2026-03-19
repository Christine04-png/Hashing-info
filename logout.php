<?php
session_start();
session_unset();
session_destroy();

// redirect to main login page
header("Location: login.php");
exit();
?>