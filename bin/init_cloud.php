<?php
declare(strict_types=1);

require dirname(__DIR__) . '/app/bootstrap.php';

try {
    $pdo = db();
    echo "Connected to database successfully.\n";

    // Check if tables exist
    $tables = $pdo->query("SHOW TABLES LIKE 'admins'")->fetchAll();
    if (empty($tables)) {
        echo "Initializing database schema...\n";
        $schemaSql = file_get_contents(dirname(__DIR__) . '/database/schema.sql');
        $pdo->exec($schemaSql);
        echo "Database schema imported.\n";

        // Apply migrations
        $mig1 = dirname(__DIR__) . '/database/migrations/20261021_update_about_content_and_locations.sql';
        if (is_file($mig1)) {
            $pdo->exec(file_get_contents($mig1));
            echo "Migration 20261021 applied.\n";
        }

        // Seed default admin
        $adminEmail = 'admin@happyhomecare.com';
        $adminPass = 'Admin@12345678';
        $stmt = $pdo->prepare('INSERT INTO admins (name, email, password_hash) VALUES (?, ?, ?)');
        $stmt->execute(['Site Admin', $adminEmail, password_hash($adminPass, PASSWORD_DEFAULT)]);
        echo "Default admin account created ($adminEmail).\n";
    } else {
        echo "Database tables already exist. Skipping schema initialization.\n";
    }
} catch (Throwable $e) {
    echo "Database init notice: " . $e->getMessage() . "\n";
}
