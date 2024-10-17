CREATE DATABASE pickup_system;

USE pickup_system;

CREATE TABLE pickup_requests (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    po_number VARCHAR(50) NOT NULL,
    part_name VARCHAR(100) NOT NULL,
    quantity INT(11) NOT NULL,
    dimensi_part VARCHAR(255) NOT NULL,
    weight INT(11) NOT NULL,
    pickup_address VARCHAR(255) NOT NULL,
    destination_address VARCHAR(255) NOT NULL,
    pickup_date DATE NOT NULL,
    supplier_name VARCHAR(100) NOT NULL,
    requester_name VARCHAR(100) NOT NULL,
    import_documents TEXT NOT NULL,
    shipping_options VARCHAR(10),
    request_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);