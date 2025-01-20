CREATE TABLE IF NOT EXISTS users
(
    id       SERIAL PRIMARY KEY,
    email    VARCHAR(255) NOT NULL UNIQUE,
    role     VARCHAR(20)  NOT NULL,
    password TEXT         NOT NULL
);