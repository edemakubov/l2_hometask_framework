CREATE TABLE IF NOT EXISTS cart
(
    id    SERIAL PRIMARY KEY,
    user_id INT NOT NULL,
    inventory_id INT NOT NULL,
    quantity INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users (id),
    FOREIGN KEY (inventory_id) REFERENCES inventory (id)
);