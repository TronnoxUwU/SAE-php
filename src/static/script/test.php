<?php

$host = 'aws-0-eu-west-3.pooler.supabase.com';
$dbname = 'postgres';
$user = 'postgres.vicnhizlpnnchlerpqtr';
$password = 'SAEMLF2025.';
$port = '6543'; // Par défaut, 5432

// Création de la connexion avec PDO
$dsn = "pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password";
$pdo = new PDO($dsn);

echo"yeah";