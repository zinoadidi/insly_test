
/* 
* Program to "print out your name with one of php loops" 
* by Zino Adidi
* Insly Test

Note:
There are other flexible ways to handle the data such as slitting various information 
* such that this information can be easily analysed but i tried to follow the question 
* to the latter so as not to deviate. Also, the use of JSON data type for specific columns
* in the table would make this kind of system more easier to implement but due to the
* availablity of the this feare on older database system, i didnt want to stretch the answer.
*/
drop database employee_data;
CREATE DATABASE employee_data;

USE employee_data;

CREATE TABLE IF NOT EXISTS `employees` (
    `id` int(255) NOT NULL AUTO_INCREMENT,
    `ssn` varchar(30) NULL,    
    `name` varchar(100) NOT NULL,
    `id_code` varchar(30) NOT NULL,
    `is_current_employee` varchar(4) NOT NULL,
    `email` varchar(100) NOT NULL,
    `phone` varchar(20) NOT NULL,
    `address` varchar(100) DEFAULT NULL,
    `birth_date` date NOT NULL,
    `date_created` timestamp NOT NULL,
    `last_modified` varchar(30) DEFAULT NULL,    
    PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `employees_info_english` (
    `id` int(255) NOT NULL AUTO_INCREMENT,
    `employees_id` varchar(255) NOT NULL,    
    `Introduction` varchar(255) NOT NULL,
    `previous_work_experience` varchar(255) NOT NULL,
    `education_information` varchar(255) NOT NULL,
    `date_created` timestamp NOT NULL,
    `last_modified` varchar(30) DEFAULT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `employees_info_spanish` (
    `id` int(255) NOT NULL AUTO_INCREMENT,
    `employees_id` varchar(255) NOT NULL,    
    `Introduction` varchar(255) NOT NULL,
    `previous_work_experience` varchar(255) NOT NULL,
    `education_information` varchar(255) NOT NULL,
    `date_created` timestamp NOT NULL,
    `last_modified` varchar(255) DEFAULT NULL,
    PRIMARY KEY (`id`)
);


CREATE TABLE IF NOT EXISTS `employees_info_french` (
    `id` int(255) NOT NULL AUTO_INCREMENT,
    `employees_id` varchar(255) NOT NULL,    
    `Introduction` varchar(255) NOT NULL,
    `previous_work_experience` varchar(255) NOT NULL,
    `education_information` varchar(255) NOT NULL,
    `date_created` timestamp NOT NULL,
    `last_modified` varchar(255) DEFAULT NULL,
    PRIMARY KEY (`id`)
);


CREATE TABLE IF NOT EXISTS `logs` (
    `id` int(255) NOT NULL AUTO_INCREMENT,
    `employee_id` varchar(255) NOT NULL,
    `creator_name` varchar(255) NOT NULL,
    `creator_id` varchar(255) NOT NULL,
    `action_type` varchar(255) DEFAULT NULL,
    `discription` varchar(50) DEFAULT NULL,
    `date_created` timestamp NOT NULL,
    PRIMARY KEY (`id`)
);


INSERT INTO `employee_data`.`employees` (`id`, `ssn`, `name`, `id_code`, `is_current_employee`, `email`, `phone`, `address`, `birth_date`, `date_created`, `last_modified`) VALUES (0, 'WA1299676990', 'ZINO ADIDI', 'QW12200R49', 'YES', 'zinoadidi@gmail.com', '+37257853542', 'Suur-Sojamae', CURDATE(), NOW(), NOW());
INSERT INTO `employee_data`.`employees_info_english` (`id`, `employees_id`, `Introduction`, `previous_work_experience`, `education_information`, `date_created`, `last_modified`) VALUES ('0', '0', 'data in english', 'data in english', 'data in english', NOW(), NOW());
INSERT INTO `employee_data`.`employees_info_french` (`id`, `employees_id`, `Introduction`, `previous_work_experience`, `education_information`, `date_created`, `last_modified`) VALUES ('0', '0', 'data in french', 'data in french', 'data in french', NOW(), NOW());
INSERT INTO `employee_data`.`employees_info_spanish` (`id`, `employees_id`, `Introduction`, `previous_work_experience`, `education_information`, `date_created`, `last_modified`) VALUES ('0', '0', 'data in spanish', 'data in spanish', 'data in spanish', NOW(), NOW());


select * from employees 
inner join employees_info_french on employees.id = employees_info_french.id
inner join employees_info_spanish on employees.id = employees_info_spanish.id
inner join employees_info_english on employees.id = employees_info_english.id;


