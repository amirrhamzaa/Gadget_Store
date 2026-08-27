<?php

$db_host = "localhost";
$db_user = "root";
$db_password = "123456";
$db_name = "gadget_store";

$conn = new mysqli($db_host, $db_user, $db_password, $db_name);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

// Create migration tracking table
$conn->query("
    CREATE TABLE IF NOT EXISTS database_migrations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        migration VARCHAR(255) NOT NULL UNIQUE,
        executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )
");

$migrationsDir = __DIR__ . "/migrations";

$files = glob($migrationsDir . "/*.sql");

if (!$files) {
    die("No migration files found.");
}

sort($files);

foreach ($files as $file) {

    $migration = basename($file);

    // Check if migration already executed
    $stmt = $conn->prepare(
        "SELECT id FROM database_migrations WHERE migration = ?"
    );

    $stmt->bind_param("s", $migration);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Already applied: $migration<br>";
        continue;
    }

    // Read SQL file
    $sql = file_get_contents($file);

    if ($sql === false) {
        echo "Could not read: $migration<br>";
        continue;
    }

    // Execute migration
    if ($conn->multi_query($sql)) {

        // Wait for all queries to finish
        while ($conn->more_results() && $conn->next_result()) {
        }

        if ($conn->errno) {
            echo "Failed: $migration - " . $conn->error . "<br>";
            continue;
        }

        $stmt = $conn->prepare(
            "INSERT INTO database_migrations (migration) VALUES (?)"
        );

        $stmt->bind_param("s", $migration);
        $stmt->execute();

        echo "Applied: $migration<br>";

    } else {
        echo "Failed: $migration - " . $conn->error . "<br>";
    }
}

$conn->close();

echo "<br>Migration process completed.";

?>