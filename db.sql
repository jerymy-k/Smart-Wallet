CREATE DATABASE SmartWallet;
use SmartWallet;
CREATE Table incomes (
    id int PRIMARY KEY AUTO_INCREMENT,
    montant DECIMAL(10,2) NOT NULL,
    laDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
    descri TEXT
);
CREATE Table expenses (
    id int PRIMARY KEY AUTO_INCREMENT,
    montant DECIMAL(10,2) NOT NULL,
    laDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
    descri TEXT
);
