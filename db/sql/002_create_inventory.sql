CREATE TABLE IF NOT EXISTS inventory
(
    id          SERIAL PRIMARY KEY,
    title       VARCHAR(255) NOT NULL,
    description TEXT,
    price       INT          NOT NULL
);