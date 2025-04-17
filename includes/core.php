<?php
include_once 'db.php';

// Create `user_profiles` table if it doesn't exist (with new fields)
$tableSql = "CREATE TABLE IF NOT EXISTS user_profiles (
    sr_num INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    father_name VARCHAR(100) NOT NULL,
    cnic_number VARCHAR(15) NOT NULL UNIQUE,
    mobile_number VARCHAR(15) NOT NULL,
    mobile_number_2 VARCHAR(15),
    account_number VARCHAR(50),
    occupation VARCHAR(100),
    previous_account_number VARCHAR(50),
    reference VARCHAR(100),

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

// Create `loan` table if it doesn't exist
$loanTableSql = "CREATE TABLE IF NOT EXISTS loan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    entry_date DATE NOT NULL,
    month VARCHAR(20) NOT NULL,
    khata_number VARCHAR(50) NOT NULL,
    description TEXT,
    debit DECIMAL(10,2) DEFAULT 0,
    credit DECIMAL(10,2) DEFAULT 0,
    balance DECIMAL(10,2) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (!$conn->query($loanTableSql)) {
    error_log("Failed to create table 'loan': " . $conn->error);
}
?>