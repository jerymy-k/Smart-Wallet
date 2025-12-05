CREATE DATABASE SmartWallet ;
USE SmartWallet;
CREATE TABLE incomes(
    id INT PRIMARY KEY AUTO_INCREMENT ,
    montant DECIMAL(10,2) NOT NULL ,
    laDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    descri TEXT
);
CREATE TABLE expenses(
    id INT PRIMARY KEY AUTO_INCREMENT ,
    montant DECIMAL(10,2) NOT NULL ,
    laDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    descri TEXT
);
INSERT INTO incomes (montant , descri ) VALUES ('$montant_incomes' , '$incomes_desc');
INSERT INTO expenses (montant , descri ) VALUES ('$montant_expenses' , '$expenses_desc');
UPDATE incomes 
        SET montant='$montant', descri='$descripcion' 
        WHERE id=$id;
UPDATE expenses 
        SET montant='$montant', descri='$descripcion' 
        WHERE id=$id;
DELETE FROM incomes WHERE id=$id;
SET @num := 0;
UPDATE incomes SET id = (@num := @num + 1) ORDER BY id;
ALTER TABLE incomes AUTO_INCREMENT = 1;
DELETE FROM expenses WHERE id=$id;
SET @num := 0;
UPDATE expenses SET id = (@num := @num + 1) ORDER BY id;
ALTER TABLE expenses AUTO_INCREMENT = 1;

