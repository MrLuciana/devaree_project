CREATE TABLE `admin`(
    `adm_id` INT(2) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `adm_title` VARCHAR(30) NOT NULL,
    `adm_fname` VARCHAR(30) NOT NULL,
    `adm_lname` VARCHAR(30) NOT NULL,
    `adm_username` VARCHAR(30) NOT NULL,
    `adm_password` VARCHAR(100) NOT NULL,
    `adm_avatar` VARCHAR(30) NOT NULL
);
CREATE TABLE `customers`(
    `cus_id` INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `cus_fname` VARCHAR(30) NOT NULL,
    `cus_lname` VARCHAR(30) NOT NULL,
    `cus_phone` VARCHAR(20) NOT NULL,
    `cus_email` VARCHAR(50) NOT NULL,
    `cus_gender` VARCHAR(5) NOT NULL COMMENT 'male,female,others',
    `cus_birthdate` DATE NOT NULL,
    `cus_address` TEXT NOT NULL,
    `cus_created_at` TIMESTAMP NOT NULL
);
CREATE TABLE `employees`(
    `emp_id` INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `emp_fname` VARCHAR(30) NOT NULL,
    `emp_lname` VARCHAR(30) NOT NULL,
    `emp_position` VARCHAR(30) NOT NULL,
    `emp_phone` VARCHAR(20) NOT NULL,
    `emp_email` VARCHAR(50) NOT NULL,
    `emp_hire_date` DATE NOT NULL
);
CREATE TABLE `services`(
    `ser_id` INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `ser_code` VARCHAR(10) NOT NULL,
    `ser_name` VARCHAR(50) NOT NULL,
    `ser_description` TEXT NOT NULL,
    `cat_id` INT(2) NOT NULL,
    `ser_price1` FLOAT(53) NOT NULL,
    `ser_price2` FLOAT(53) NOT NULL,
    `ser_price3` FLOAT(53) NOT NULL,
    `ser_active` VARCHAR(5) NOT NULL DEFAULT '0' COMMENT 'yes,no'
);
CREATE TABLE `packages`(
    `pac_id` INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `pac_code` VARCHAR(10) NOT NULL,
    `pac_name` VARCHAR(50) NOT NULL,
    `pac_description` TEXT NOT NULL,
    `cat_id` INT(2) NOT NULL,
    `pac_price1` FLOAT(53) NOT NULL,
    `pac_price2` FLOAT(53) NOT NULL,
    `pac_price3` FLOAT(53) NOT NULL,
    `pac_active` VARCHAR(5) NOT NULL DEFAULT '0' COMMENT 'yes,no'
);
CREATE TABLE `categories`(
    `cat_id` INT(2) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `cat_name` VARCHAR(50) NOT NULL
);
CREATE TABLE `bookings`(
    `boo_id` INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `cus_id` INT(5) NOT NULL,
    `emp_id` INT(5) NOT NULL,
    `ser_id` INT(5) NOT NULL,
    `pac_id` INT(5) NOT NULL,
    `boo_date` DATETIME NOT NULL,
    `boo_amount` FLOAT(53) NOT NULL,
    `boo_status` VARCHAR(20) NOT NULL DEFAULT 'pending' COMMENT '\'pending\', \'confirmed\', 
\'completed\',\'cancelled\'',
    `boo_notes` TEXT NOT NULL,
    `boo_created_at` TIMESTAMP NOT NULL,
    `boo_updated_at` TIMESTAMP NOT NULL
);
CREATE TABLE `payments`(
    `pay_id` INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `boo_id` INT(5) NOT NULL,
    `pay_amount` DECIMAL(10, 2) NOT NULL,
    `pay_method` VARCHAR(20) NOT NULL COMMENT '\'cash\',\'credit_car
 d\',\'bank_transfer\',\'
 e-wallet\'',
    `pay_status` VARCHAR(20) NOT NULL DEFAULT 'pending',
    `pay_transaction_date` TIMESTAMP NOT NULL
);
ALTER TABLE
    `bookings` ADD CONSTRAINT `bookings_pac_id_foreign` FOREIGN KEY(`pac_id`) REFERENCES `packages`(`pac_id`);
ALTER TABLE
    `bookings` ADD CONSTRAINT `bookings_ser_id_foreign` FOREIGN KEY(`ser_id`) REFERENCES `services`(`ser_id`);
ALTER TABLE
    `services` ADD CONSTRAINT `services_cat_id_foreign` FOREIGN KEY(`cat_id`) REFERENCES `categories`(`cat_id`);
ALTER TABLE
    `bookings` ADD CONSTRAINT `bookings_cus_id_foreign` FOREIGN KEY(`cus_id`) REFERENCES `customers`(`cus_id`);
ALTER TABLE
    `packages` ADD CONSTRAINT `packages_cat_id_foreign` FOREIGN KEY(`cat_id`) REFERENCES `categories`(`cat_id`);
ALTER TABLE
    `bookings` ADD CONSTRAINT `bookings_emp_id_foreign` FOREIGN KEY(`emp_id`) REFERENCES `employees`(`emp_id`);
ALTER TABLE
    `payments` ADD CONSTRAINT `payments_boo_id_foreign` FOREIGN KEY(`boo_id`) REFERENCES `bookings`(`boo_id`);