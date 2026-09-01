<?php

$db_host = "localhost";
$db_user = "root";
$db_password = "123456";
$db_name = "gadget_store";


// Connect to MySQL server (without selecting database)
$conn = new mysqli($db_host, $db_user, $db_password);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");


// --------------------------------------------------
// 1. Drop existing database
// --------------------------------------------------

if (!$conn->query("DROP DATABASE IF EXISTS `$db_name`")) {
    die("Could not drop database: " . $conn->error);
}


// --------------------------------------------------
// 2. Create fresh database
// --------------------------------------------------

if (!$conn->query("CREATE DATABASE `$db_name` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci")) {
    die("Could not create database: " . $conn->error);
}


// Select the new database
$conn->select_db($db_name);


// --------------------------------------------------
// 3. Migration folder
// --------------------------------------------------

$migrationsDir = __DIR__ . "/migrations";

$files = glob($migrationsDir . "/*.sql");

if (!$files) {
    die("No migration files found.");
}

sort($files);


// --------------------------------------------------
// 4. Create migration tracking table
// --------------------------------------------------

if (!$conn->query("
    CREATE TABLE IF NOT EXISTS database_migrations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        migration VARCHAR(255) NOT NULL UNIQUE,
        executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )
")) {
    die("Could not create migration tracking table: " . $conn->error);
}


// --------------------------------------------------
// 5. Run all SQL migration files
// --------------------------------------------------

foreach ($files as $file) {

    $migration = basename($file);

    echo "Running: $migration<br>";

    $sql = file_get_contents($file);

    if ($sql === false) {
        echo "Could not read: $migration<br>";
        continue;
    }


    // Execute SQL file
    if (!$conn->multi_query($sql)) {
        echo "Failed: $migration - " . $conn->error . "<br>";

        // Clear remaining queries
        while ($conn->more_results()) {
            $conn->next_result();
        }

        continue;
    }


    // Wait for all queries to finish
    while ($conn->more_results()) {

        if (!$conn->next_result()) {
            break;
        }

        if ($conn->errno) {
            echo "Failed: $migration - " . $conn->error . "<br>";
            break;
        }
    }


    // Mark migration as executed
    $stmt = $conn->prepare(
        "INSERT INTO database_migrations (migration) VALUES (?)"
    );

    $stmt->bind_param("s", $migration);
    $stmt->execute();

    echo "Applied: $migration<br>";
}


$conn->close();

echo "<br>Database replaced and migration completed.";

?>