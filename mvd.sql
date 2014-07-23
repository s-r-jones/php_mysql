-- destroy the tables first
DROP TABLE IF EXISTS plateAssignment;
DROP TABLE IF EXISTS car;
DROP TABLE IF EXISTS plate;
DROP TABLE IF EXISTS driver;

CREATE TABLE driver
(
    -- NOT NULL makes the attribute required
    licenseNo CHAR(9) NOT NULL,
    name VARCHAR(40) NOT NULL,
    birthday DATE NOT NULL,
    PRIMARY KEY(licenseNo)
);

CREATE TABLE plate
(
    plateNo CHAR(7) NOT NULL,
    -- make foreign keys the same type
    ownerId CHAR(9) NOT NULL,
    year YEAR NOT NULL,
    -- foreign keys must be indexed first!
    INDEX(ownerId),
    -- then delcare the relation (foreign key)
    FOREIGN KEY(ownerId) REFERENCES driver(licenseNo) ON UPDATE CASCADE,
    Primary KEY(plateNo)
);

CREATE TABLE car
(
    id INT UNSIGNED NOT NULL Auto_INCREMENT,
    make VARCHAR(40) NOT NULL,
    model VARCHAR(40) NOT NULL,
    Primary KEY(id),
    -- a unique index enforces the make and model cannot be duplicated
    UNIQUE(make, model)
);

CREATE TABLE plateAssignment
(
    carid INT UNSIGNED NOT NULL,
    plateNo CHAR(7) NOT NULL,
    -- foreign keys need to be indexed first
    INDEX(carId),
    INDEX(plateNo),
    -- ensure the same car doesn't get two plates
    PRIMARY KEY(carId, plateNo),
    -- create foreign keys
    FOREIGN KEY(carId) REFERENCES car(id),
    FOREIGN KEY(plateNo) REFERENCES plate(plateNo)

);


