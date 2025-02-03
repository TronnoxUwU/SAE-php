<?php

$host = '@dab065e6-321b-4b4a-a173-b1dff4e871d5.supabase.co';
$dbname = 'public';
$user = 'dab065e6-321b-4b4a-a173-b1dff4e871d5';
$password = 'test';
$port = '5432'; // Par défaut, 5432

// Création de la connexion avec PDO
$dsn = "pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password";
$pdo = new PDO($dsn);
