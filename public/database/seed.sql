DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

INSERT INTO users (username, password)
VALUES 
    ('testuser1', 'password123'),
    ('testuser2', 'mypassword456'),
    ('testuser3', 'securepass789');
