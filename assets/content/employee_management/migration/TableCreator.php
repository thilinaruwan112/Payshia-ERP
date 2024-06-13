<?php

// TableCreator.php
class TableCreator
{
    private $db;
    private $lastError;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function CreateEmployeeTable()
    {
        $query  = "CREATE TABLE  IF NOT EXISTS employee_details (
                id INT AUTO_INCREMENT PRIMARY KEY,
                full_name VARCHAR(255) NOT NULL,
                name_with_initials VARCHAR(255) NOT NULL,
                phone_number VARCHAR(20) NOT NULL,
                national_id_number VARCHAR(20) NOT NULL,
                date_of_birth DATE NOT NULL,
                gender ENUM('Male', 'Female', 'Other') NOT NULL, 
                married_status ENUM('Single', 'Married', 'Divorced', 'Widowed') NOT NULL, 
                address_line_1 VARCHAR(255) NOT NULL,
                address_line_2 VARCHAR(255) NOT NULL,
                city VARCHAR(255) NOT NULL,
                permanent_address_line_1 VARCHAR(255) NOT NULL,
                permanent_address_line_2 VARCHAR(255) NOT NULL,
                permanent_city VARCHAR(255) NOT NULL, 
                employee_id VARCHAR(50) NOT NULL,
                date_of_hire DATE NOT NULL,
                employee_type ENUM('Full-time', 'Part-time', 'Contract') NOT NULL, 
                work_location VARCHAR(255) NOT NULL,
                department VARCHAR(255) NOT NULL, 
                position VARCHAR(255) NOT NULL, 
                nic VARCHAR(255) NOT NULL, 
                cover_image VARCHAR(255),
                grama_niladhari_certificate VARCHAR(255),
                police_certificate VARCHAR(255),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at datetime NOT NULL,
                created_by  VARCHAR(255) NOT NULL
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_sinhala_ci";


        if ($this->db->executeQuery($query)) {
            echo "Table employee_details created successfully.";
        } else {
            $this->lastError = $this->db->getLastError();
            echo "Failed to create table: " . $this->lastError;
        }
    }

    public function alterEmployeeTable($alterQuery)
    {
        if ($this->db->alterTable($alterQuery)) {
            echo "Table altered successfully.";
        } else {
            $this->lastError = $this->db->getLastError();
            echo "Failed to alter table: " . $this->lastError;
        }
    }

    public function dropEmployeeTable()
    {
        $query = "DROP TABLE IF EXISTS employee_details";
        if ($this->db->executeQuery($query)) {
            echo "Table employee_details dropped successfully.";
        } else {
            $this->lastError = $this->db->getLastError();
            echo "Failed to drop table: " . $this->lastError;
        }
    }



    // Position Table
    public function CreatePositionTable()
    {
        $query  = "CREATE TABLE  IF NOT EXISTS employee_position (
                id INT AUTO_INCREMENT PRIMARY KEY,
                position_name VARCHAR(255) NOT NULL,
                is_active int(2),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at datetime NOT NULL,
                created_by  VARCHAR(255) NOT NULL
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_sinhala_ci";

        try {
            $this->db->executeQuery($query);
            return true;
        } catch (PDOException $e) {
            $this->lastError = $e->getMessage();
            return false;
        }
    }


    // Position Table
    public function CreateDepartmentTable()
    {
        $query  = "CREATE TABLE  IF NOT EXISTS employee_departments (
                id INT AUTO_INCREMENT PRIMARY KEY,
                department_name VARCHAR(255) NOT NULL,
                is_active int(2) DEFAULT 1,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at datetime NOT NULL,
                created_by  VARCHAR(255) NOT NULL
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_sinhala_ci";

        try {
            $this->db->executeQuery($query);
            return true;
        } catch (PDOException $e) {
            $this->lastError = $e->getMessage();
            return false;
        }
    }

    // Work Locations Table
    public function CreateWorkLocationTable()
    {
        $query  = "CREATE TABLE  IF NOT EXISTS employee_worklocations (
                id INT AUTO_INCREMENT PRIMARY KEY,
                work_location_name VARCHAR(255) NOT NULL,
                is_active int(2) DEFAULT 1,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at datetime NOT NULL,
                created_by  VARCHAR(255) NOT NULL
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_sinhala_ci";

        try {
            $this->db->executeQuery($query);
            return true;
        } catch (PDOException $e) {
            $this->lastError = $e->getMessage();
            return false;
        }
    }


    public function getLastError()
    {
        return $this->lastError;
    }
}
