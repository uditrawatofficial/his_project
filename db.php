<?php
require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$host = $_ENV['DB_HOST'];
$port = $_ENV['DB_PORT'];
$dbname = $_ENV['DB_NAME'];
$user = $_ENV['DB_USER'];
$pass = $_ENV['DB_PASS'];
$errors = [];

try {
    $conn = "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=require;options=endpoint=ep-polished-dream-az8ryx2i-pooler";
    $conn = new PDO($conn, $user, $pass, 
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    echo " CONNECTED SUCCESFULLY ";
} catch (PDOException $e) 
{
    echo ("Database connection failed:" . ($e->getMessage()));
     $errors[] = "Unable to connect to the database.";
}
if ($conn) {
    try {
        $stmt = $conn->query("SELECT * FROM patients ORDER BY p_id");
        $rows = $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Query failed: " . $e->getMessage());

        if ($e->getCode() === '42P01') 
            { 
            $errors[] = "A required table is missing. Please contact support.";

        } else {
            $errors[] = "Unable to complete the request.";
        }
    }
}

if (!empty($errors)) {
    foreach ($errors as $err) {
        echo($err) . "\n";
    }
}
if ($conn) {
    try {
        $stmt = $conn->query("SELECT * FROM doctors ORDER BY d_id");
        $rows = $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Query failed: " . $e->getMessage());

        if ($e->getCode() === '42P01') 
            { 
            $errors[] = "A required table is missing. Please contact support.";
            
        } else {
            $errors[] = "Unable to complete the request.";
        }
    }
}

if (!empty($errors)) {
    foreach ($errors as $err) {
        echo($err) . "\n";
    }
}
if ($conn) {
    try {
        $stmt = $conn->query("SELECT * FROM appointments ORDER BY p_id");
        $rows = $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Query failed: " . $e->getMessage());

        if ($e->getCode() === '42P01') 
            { 
            $errors[] = "A required table is missing. Please contact support.";
            
        } else {
            $errors[] = "Unable to complete the request.";
        }
    }
}

if (!empty($errors)) {
    foreach ($errors as $err) {
        echo($err) . "\n";
    }
}