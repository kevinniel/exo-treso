<?php

$host = '127.0.0.1';
$port = '8889';
$db   = 'blog';
$user = 'blog';
$pass = 'blog';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host:$port;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// récupération d'infos en SQL (execution d'une requete en select)
$stmt = $pdo->query('SELECT * FROM categories');
while ($row = $stmt->fetch())
{
    // echo $row . "\n";
    echo("<pre>");
    echo("<code>");
    var_dump($row);
    echo("</code>");
    echo("</pre>");
}

// insertion d'une valeur en BDD
$value_to_insert = "ruby";

$stmt = $pdo->prepare('INSERT INTO categories (name) VALUES (?)');
$stmt->bindParam(1, $value_to_insert, PDO::PARAM_STR);
$stmt->execute();