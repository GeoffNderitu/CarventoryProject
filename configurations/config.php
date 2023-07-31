<?php
// Database Configuration
$db_host = 'localhost';
$db_name = 'CarNation';
$db_user = 'root';
$db_password = '';


// Establish Database Connection
$db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
