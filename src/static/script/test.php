<?php
require_once './src/static/script/modele.php';

$host = 'aws-0-eu-west-3.pooler.supabase.com';
$dbname = 'postgres';
$user = 'postgres.vicnhizlpnnchlerpqtr';
$password = 'SAEMLF2025.';
$port = '5432'; // Par défaut, 5432

// Création de la connexion avec PDO
$dsn = "pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password";
$connexion = new PDO($dsn);

echo"yeah";
//set_time_limit(5000);
//chargementFichier("./src/data/restaurants_orleans.json");
//set_time_limit(30);

//utilisateurExistant("", "")

//insertClient("Test", "Test", "+33 6 04 50 50 50", "aaaa", 24, 45, 45234, "UwU", true);
//echo utilisateurExistant("aaaa", "UwU") ? "Il existe" : "Il existe pas";