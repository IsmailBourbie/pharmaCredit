--  drop tables if exists

DROP TABLE IF EXISTS tracing;
DROP TABLE IF EXISTS clients;

CREATE TABLE clients (
nom varchar(120) PRIMARY KEY,
credit_amount DOUBLE NOT NULL DEFAULT 0,
payroll_amount DOUBLE NOT NULL DEFAULT 0
);

CREATE TABLE tracing (
id INT PRIMARY KEY AUTO_INCREMENT, 
nom varchar(120) NOT NULL,
credit_amount DOUBLE NULL,
payroll_amount DOUBLE NULL,
notification VARCHAR(255) NULL,
`current_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (nom) REFERENCES clients(nom)
);