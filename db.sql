DROP TABLE cars;
CREATE TABLE cars
(
    id         INT AUTO_INCREMENT PRIMARY KEY,
    brand      VARCHAR(255) NOT NULL,
    model      VARCHAR(255) NOT NULL,
    year       VARCHAR(255) NOT NULL,
    volume     float        NOT NULL,
    fuel       varchar(64)  NOT NULL,
    price      int          NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE rent
(
    id         INT AUTO_INCREMENT PRIMARY KEY,
    car_id     INT  NOT NULL,
    startDate  date NOT NULL,
    endDate    date NOT NULL,
    fullName   varchar(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


select *
from rent;



INSERT INTO cars (brand, model, year, volume, fuel, price)
VALUES ('Toyota', 'Corolla', '2022', 1.8, 'Gasoline', 25000),
       ('Honda', 'Civic', '2023', 1.5, 'Gasoline', 27000),
       ('Ford', 'Mustang', '2021', 5.0, 'Gasoline', 45000),
       ('Tesla', 'Model 3', '2023', 0.0, 'Electric', 55000),
       ('BMW', 'X5', '2022', 3.0, 'Diesel', 65000),
       ('Volkswagen', 'Golf', '2021', 1.4, 'Gasoline', 28000),
       ('Mercedes-Benz', 'C-Class', '2023', 2.0, 'Gasoline', 50000),
       ('Audi', 'A4', '2022', 2.0, 'Gasoline', 48000),
       ('Hyundai', 'Tucson', '2023', 2.5, 'Gasoline', 32000),
       ('Nissan', 'Leaf', '2022', 0.0, 'Electric', 35000);

INSERT INTO cars (brand, model, year, volume, fuel, price)
VALUES ('Mazda', 'CX-5', '2023', 2.5, 'Gasoline', 33000),
       ('Subaru', 'Outback', '2022', 2.4, 'Gasoline', 36000),
       ('Kia', 'Sportage', '2023', 2.0, 'Hybrid', 31000),
       ('Chevrolet', 'Bolt', '2023', 0.0, 'Electric', 32000),
       ('Lexus', 'RX', '2022', 3.5, 'Hybrid', 55000),
       ('Volvo', 'XC60', '2023', 2.0, 'Plug-in Hybrid', 54000),
       ('Porsche', '911', '2023', 3.0, 'Gasoline', 110000),
       ('Jeep', 'Wrangler', '2022', 3.6, 'Gasoline', 40000),
       ('Land Rover', 'Range Rover', '2023', 3.0, 'Diesel', 95000),
       ('Acura', 'MDX', '2023', 3.5, 'Gasoline', 58000);
select *
from cars;


ALTER TABLE cars
    ADD COLUMN description TEXT;

ALTER TABLE cars
    ADD COLUMN isFree BOOLEAN DEFAULT true;

ALTER TABLE cars
    ADD COLUMN photos LONGTEXT;

ALTER table rent
    add column days INT;
alter table rent
    add column userId int;
ALTER TABLE rent
    add column isEnd BOOLEAN default false;
UPDATE cars
SET description = 'Reliable and fuel-efficient compact sedan'
WHERE brand = 'Toyota';

UPDATE cars
SET description = 'Popular compact car known for its performance'
WHERE brand = 'Honda';

UPDATE cars
SET description = 'Iconic American muscle car with powerful engine'
WHERE brand = 'Ford';

UPDATE cars
SET description = 'All-electric sedan with advanced autopilot features'
WHERE brand = 'Tesla';

UPDATE cars
SET description = 'Luxury SUV with excellent handling and comfort'
WHERE brand = 'BMW';

UPDATE cars
SET description = 'Compact hatchback with German engineering'
WHERE brand = 'Volkswagen';

UPDATE cars
SET description = 'Elegant luxury sedan with cutting-edge technology'
WHERE brand = 'Mercedes-Benz';

UPDATE cars
SET description = 'Premium compact executive car with quattro all-wheel drive'
WHERE brand = 'Audi';

UPDATE cars
SET description = 'Stylish compact SUV with modern features'
WHERE brand = 'Hyundai';

UPDATE cars
SET description = 'Affordable all-electric hatchback with good range'
WHERE brand = 'Nissan';

UPDATE cars
SET description = 'Sporty compact SUV with responsive handling'
WHERE brand = 'Mazda';

UPDATE cars
SET description = 'Rugged all-wheel drive wagon with off-road capability'
WHERE brand = 'Subaru';

UPDATE cars
SET description = 'Fuel-efficient hybrid SUV with spacious interior'
WHERE brand = 'Kia';

UPDATE cars
SET description = 'Compact electric vehicle with impressive range'
WHERE brand = 'Chevrolet';

UPDATE cars
SET description = 'Luxurious hybrid SUV combining comfort and efficiency'
WHERE brand = 'Lexus';

UPDATE cars
SET description = 'Safe and eco-friendly plug-in hybrid SUV'
WHERE brand = 'Volvo';

UPDATE cars
SET description = 'High-performance sports car with iconic design'
WHERE brand = 'Porsche';

UPDATE cars
SET description = 'Legendary off-road SUV with removable top'
WHERE brand = 'Jeep';

UPDATE cars
SET description = 'Premium luxury SUV with exceptional off-road capabilities'
WHERE brand = 'Land Rover';

UPDATE cars
SET description = 'Upscale three-row SUV with advanced technology'
WHERE brand = 'Acura';

UPDATE cars
SET description = 'No description available'
WHERE description IS NULL
   OR description = '';


select *
from cars;

select *
from rent;

select rent.car_id,
       rent.startDate,
       rent.endDate,
       rent.days,
       rent.isEnd,
       rent.userId,
       cars.id,
       cars.brand,
       cars.model,
       cars.year,
       cars.volume,
       cars.fuel,
       cars.price,
       cars.isFree,
       users.userId,
       users.email,
       users.fullName,
       users.birthDate
from ((rent
    inner join cars on rent.car_id = cars.id)
    inner join users on rent.userId = users.userId);

DELETE
from rent;


UPDATE cars
set isFree = 1
WHERE isFree = 0;



CREATE TABLE users
(
    userId         INT PRIMARY KEY AUTO_INCREMENT,
    email          VARCHAR(255) NOT NULL UNIQUE,
    fullName       VARCHAR(255) NOT NULL,
    hashedPassword VARCHAR(255) NOT NULL,
    birthDate      DATE
);
ALTER TABLE users
    ADD COLUMN isAdmin BOOLEAN DEFAULT FALSE;


SELECT userId, email, fullName, birthDate, isAdmin
FROM users
WHERE userId = 3

drop table users;



select *
from rent