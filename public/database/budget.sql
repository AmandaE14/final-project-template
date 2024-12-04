CREATE TABLE budget (
    id INT AUTO_INCREMENT PRIMARY KEY,
    month VARCHAR(50) NOT NULL,
    initial_balance DECIMAL(10, 2) NOT NULL,
    income DECIMAL(10, 2) NOT NULL,
    income_date DATE DEFAULT NULL,
    expense DECIMAL(10, 2) NOT NULL,
    expense_date DATE DEFAULT NULL
);