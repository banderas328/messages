<?php
// migrate.php

$dbFile = __DIR__ . '/database.sqlite';
$pdo = new PDO('sqlite:' . $dbFile);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$migrationFile = __DIR__ . '/migrations/001_create_tables.sql';
$sql = file_get_contents($migrationFile);

try {
    $pdo->exec($sql);
    echo "Migration applied successfully.\n";
} catch (PDOException $e) {
    echo "Migration failed: " . $e->getMessage() . "\n";
}
