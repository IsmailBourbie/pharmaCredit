--  drop tables if exists

DROP TABLE IF EXISTS payment;
DROP TABLE IF EXISTS credit;
DROP TABLE IF EXISTS clients;

CREATE TABLE clients (
nom varchar(120) PRIMARY KEY
);

CREATE TABLE credit (
id INT PRIMARY KEY AUTO_INCREMENT, 
nom varchar(120) NOT NULL,
credit_amount DOUBLE NOT NULL,
notification VARCHAR(255) NULL,
FOREIGN KEY (nom) REFERENCES clients(nom)
);

CREATE TABLE payment (
id INT PRIMARY KEY AUTO_INCREMENT,
payroll_amount DOUBLE NOT NULL,
nom varchar(120) NOT NULL,
`current_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (nom) REFERENCES clients(nom)
);



-- SELECT
--     clients.*,
--     credit.credit_amount,
--     payment.payroll_amount,
--     payment.current_date
-- FROM
--     (
--         (
--             `clients`
--         INNER JOIN credit ON clients.nom = credit.nom
--         )
--     INNER JOIN payment ON clients.nom = payment.nom
--     )
-- WHERE
--     clients.nom = "fazoo"