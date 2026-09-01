```php
<?php

$db_host = "localhost";
$db_user = "root";
$db_password = "123456";
$db_name = "gadget_store";


// --------------------------------------------------
// 1. Connect to MySQL server
// --------------------------------------------------

$conn = new mysqli($db_host, $db_user, $db_password);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");


// --------------------------------------------------
// 2. Find latest SQL migration file
// --------------------------------------------------

$migrationsDir = __DIR__ . "/migrations";

$files = glob($migrationsDir . "/*.sql");

if (!$files) {
    die("No migration files found.");
}

// Sort by filename
sort($files);

// Get the latest SQL file
$latestFile = end($files);

$migration = basename($latestFile);

echo "Latest migration: $migration<br>";


// --------------------------------------------------
// 3. Read latest SQL file
// --------------------------------------------------

$sql = file_get_contents($latestFile);

if ($sql === false) {
    die("Could not read: $migration");
}


// --------------------------------------------------
// 4. Drop existing database
// --------------------------------------------------

if (!$conn->query("DROP DATABASE IF EXISTS `$db_name`")) {
    die("Could not drop database: " . $conn->error);
}

echo "Old database removed.<br>";


// --------------------------------------------------
// 5. Create fresh database
// --------------------------------------------------

if (!$conn->query("
    CREATE DATABASE `$db_name`
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_general_ci
")) {
    die("Could not create database: " . $conn->error);
}

echo "New database created.<br>";


// --------------------------------------------------
// 6. Select database
// --------------------------------------------------

$conn->select_db($db_name);


// --------------------------------------------------
// 7. Execute latest SQL file
// --------------------------------------------------

if (!$conn->multi_query($sql)) {
    die("Failed: $migration - " . $conn->error);
}


// Wait for all queries to finish
while ($conn->more_results()) {

    if (!$conn->next_result()) {

        if ($conn->errno) {
            die("Failed: $migration - " . $conn->error);
        }

        break;
    }

    if ($conn->errno) {
        die("Failed: $migration - " . $conn->error);
    }
}


echo "Applied: $migration<br>";


// --------------------------------------------------
// 8. Close connection
// --------------------------------------------------

$conn->close();

echo "<br>Database update completed successfully.";

?>
```
