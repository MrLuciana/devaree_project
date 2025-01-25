CREATE TABLE `admin`(
    `adm_id` INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `adm_title` VARCHAR(50) NOT NULL,
    `adm_fname` VARCHAR(50) NOT NULL,
    `adm_lname` VARCHAR(50) NOT NULL,
    `adm_username` VARCHAR(50) NOT NULL,
    `adm_password` VARCHAR(70) NOT NULL,
    `adm_avatar` VARCHAR(50) NOT NULL
);
CREATE TABLE `customers`(
    `customer_id` INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `customer_fname` VARCHAR(50) NOT NULL,
    `customer_lname` VARCHAR(50) NOT NULL,
    `customer_phone` VARCHAR(10) NOT NULL,
    `customer_email` VARCHAR(50) NOT NULL,
    `customer_gender` ENUM('male', 'female', 'others') NOT NULL,
    `customer_birthdate` DATE NOT NULL,
    `customer_address` TEXT NOT NULL,
    `customer_created_at` TIMESTAMP NOT NULL
);
CREATE TABLE `employees`(
    `employee_id` INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `employee_fname` VARCHAR(50) NOT NULL,
    `employee_lname` VARCHAR(50) NOT NULL,
    `employee_position` VARCHAR(50) NOT NULL,
    `employee_phone` VARCHAR(10) NOT NULL,
    `employee_email` VARCHAR(50) NOT NULL,
    `employee_hire_date` DATE NOT NULL
);
CREATE TABLE `services`(
    `service_id` INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `service_code` VARCHAR(10) NOT NULL,
    `service_name` VARCHAR(50) NOT NULL,
    `service_description` TEXT NOT NULL,
    `cats_id` INT(5) NOT NULL,
    `service_price1` INT(5) NOT NULL,
    `service_price2` INT(5) NOT NULL,
    `service_price3` INT(5) NOT NULL,
    `service_status` BOOLEAN NOT NULL DEFAULT '0'
);
CREATE TABLE `courses`(
    `course_id` INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `course_code` VARCHAR(10) NOT NULL,
    `course_name` VARCHAR(50) NOT NULL,
    `course_description` TEXT NOT NULL,
    `cats_id` INT(5) NOT NULL,
    `course_price1` INT(5) NOT NULL,
    `course_price2` INT(5) NOT NULL,
    `course_price3` INT(5) NOT NULL,
    `course_status` BOOLEAN NOT NULL DEFAULT '0'
);
CREATE TABLE `categories`(
    `cats_id` INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `cats_name` VARCHAR(50) NOT NULL,
    `cats_status` BOOLEAN NOT NULL DEFAULT '0'
);
CREATE TABLE `appointments`(
    `appointment_id` INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `customer_id` INT(5) NOT NULL,
    `employee_id` INT(5) NOT NULL,
    `service_id` INT(5) NOT NULL,
    `course_id` INT(5) NOT NULL,
    `appointment_date` DATETIME NOT NULL,
    `appointment_status` ENUM(
        'pending',
        'confirmed',
        'completed',
        'cancelled'
    ) NOT NULL DEFAULT 'pending',
    `appointment_notes` TEXT NOT NULL,
    `appointment_created_at` TIMESTAMP NOT NULL,
    `appointment_updated_at` TIMESTAMP NOT NULL
);
CREATE TABLE `payments`(
    `payment_id` INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `appointment_id` INT NOT NULL,
    `payment_amount` DECIMAL(10, 2) NOT NULL,
    `payment_method` ENUM(
        'cash',
        'credit_card',
        'bank_transfer',
        'e-wallet'
    ) NOT NULL,
    `payment_status` ENUM('pending', 'paid', 'cancelled') NOT NULL DEFAULT 'pending',
    `payment_transaction_date` TIMESTAMP NOT NULL
);
ALTER TABLE
    `appointments` ADD CONSTRAINT `appointments_course_id_foreign` FOREIGN KEY(`course_id`) REFERENCES `courses`(`course_id`);
ALTER TABLE
    `appointments` ADD CONSTRAINT `appointments_service_id_foreign` FOREIGN KEY(`service_id`) REFERENCES `services`(`service_id`);
ALTER TABLE
    `services` ADD CONSTRAINT `services_cats_id_foreign` FOREIGN KEY(`cats_id`) REFERENCES `categories`(`cats_id`);
ALTER TABLE
    `appointments` ADD CONSTRAINT `appointments_customer_id_foreign` FOREIGN KEY(`customer_id`) REFERENCES `customers`(`customer_id`);
ALTER TABLE
    `courses` ADD CONSTRAINT `courses_cats_id_foreign` FOREIGN KEY(`cats_id`) REFERENCES `categories`(`cats_id`);
ALTER TABLE
    `appointments` ADD CONSTRAINT `appointments_employee_id_foreign` FOREIGN KEY(`employee_id`) REFERENCES `employees`(`employee_id`);
ALTER TABLE
    `payments` ADD CONSTRAINT `payments_appointment_id_foreign` FOREIGN KEY(`appointment_id`) REFERENCES `appointments`(`appointment_id`);