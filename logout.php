<?php
include 'includes/core/init.php';
change_user_loggedin_status($session_user_id, 0);
session_destroy();
header('Location: index.php');
?>