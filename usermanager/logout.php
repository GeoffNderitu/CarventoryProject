<?php
require_once '../configurations/functions.php';
// require_once ("..configurations/config.php");


startSession();
session_destroy();
redirectTo('../index.php');
?>
