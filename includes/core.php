<?php
include_once 'db.php';

// Create `user_profiles` table if it doesn't exist
$tableSql = "CREATE TABLE IF NOT EXISTS user_profiles (
    sr_num INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    father_name VARCHAR(100) NOT NULL,
    cnic_number VARCHAR(15) NOT NULL UNIQUE,
    mobile_number VARCHAR(15) NOT NULL,

    guarantor1_name VARCHAR(100),
    guarantor1_cnic VARCHAR(15),
    guarantor1_picture VARCHAR(255),

    guarantor2_name VARCHAR(100),
    guarantor2_cnic VARCHAR(15),
    guarantor2_picture VARCHAR(255),

    guarantor3_name VARCHAR(100),
    guarantor3_cnic VARCHAR(15),
    guarantor3_picture VARCHAR(255),

    guarantor4_name VARCHAR(100),
    guarantor4_cnic VARCHAR(15),
    guarantor4_picture VARCHAR(255),

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (!$conn->query($tableSql)) {
    error_log("Failed to create table 'user_profiles': " . $conn->error);
}
