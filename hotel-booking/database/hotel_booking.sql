-- Create Database
CREATE DATABASE IF NOT EXISTS hotel_booking;
USE hotel_booking;

-- Users Table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('user','admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Rooms Table
CREATE TABLE IF NOT EXISTS rooms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    room_name VARCHAR(100) NOT NULL,
    room_type VARCHAR(50) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    description TEXT,
    image VARCHAR(255),
    capacity INT NOT NULL,
    status ENUM('available','booked') DEFAULT 'available',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Bookings Table
CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    room_id INT NOT NULL,
    check_in DATE NOT NULL,
    check_out DATE NOT NULL,
    guests INT NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    status ENUM('pending','confirmed','cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (room_id) REFERENCES rooms(id)
);

-- Payments Table
CREATE TABLE IF NOT EXISTS payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    booking_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    payment_method VARCHAR(50),
    payment_status ENUM('paid','unpaid','pending') DEFAULT 'unpaid',
    transaction_id VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (booking_id) REFERENCES bookings(id)
);

-- Insert Sample Data
INSERT INTO rooms (room_name, room_type, price, description, image, capacity) VALUES
('Deluxe Single Room', 'single', 89.99, 'Elegant single room with modern amenities and city view.', 'room1.jpg', 1),
('Standard Double Room', 'double', 129.99, 'Spacious double room perfect for couples.', 'room2.jpg', 2),
('King Suite', 'suite', 199.99, 'Luxurious suite with separate living area.', 'room3.jpg', 2),
('Twin Room', 'double', 119.99, 'Comfortable room with two twin beds.', 'room4.jpg', 2),
('Presidential Suite', 'deluxe', 299.99, 'Ultimate luxury experience with premium furnishings.', 'room5.jpg', 4),
('Garden View Room', 'double', 139.99, 'Beautiful room overlooking the hotel gardens.', 'room6.jpg', 2);

-- Create Indexes
CREATE INDEX idx_user_email ON users(email);
CREATE INDEX idx_booking_user ON bookings(user_id);
CREATE INDEX idx_booking_room ON bookings(room_id);
CREATE INDEX idx_booking_dates ON bookings(check_in, check_out);
CREATE INDEX idx_payment_booking ON payments(booking_id);
