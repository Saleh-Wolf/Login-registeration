<?php
// إعدادات الاتصال
$host = "localhost";
$user = "root";
$pass = "";

// اتصال بدون اسم داتابيز أولاً
$con = mysqli_connect($host, $user, $pass);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// خلق الداتابيز `info` لو مش موجودة
$create_db = "CREATE DATABASE IF NOT EXISTS info";
if (mysqli_query($con, $create_db)) {
    // اختيار الداتابيز
    mysqli_select_db($con, "info");
    
    // خلق جدول `users`
    $create_table = "
    CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        phone VARCHAR(20) NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    if (mysqli_query($con, $create_table)) {
        echo "<!-- Database & Table created successfully -->";
    } else {
        die("Error creating table: " . mysqli_error($con));
    }
} else {
    die("Error creating database: " . mysqli_error($con));
}
?>
