<?php
//tragt hier eure verbindungsdaten zur datenbank ein
$db_host = 'localhost';
$db_name = 'praxis login';
$db_user = 'root';
$db_password = '';
$pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);