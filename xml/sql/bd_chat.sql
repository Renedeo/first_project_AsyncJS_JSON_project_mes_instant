DROP TABLE IF EXISTS `Message`;

DROP TABLE IF EXISTS `User`;

DROP TABLE IF EXISTS `FontFamily`;

CREATE TABLE
    IF NOT EXISTS `FontFamily` (
        `FontFamily_id` INT PRIMARY KEY AUTO_INCREMENT,
        `font_family` VARCHAR(255) NOT NULL
    );

CREATE TABLE
    IF NOT EXISTS `User` (
        `id_user` INT NOT NULL AUTO_INCREMENT,
        `username` VARCHAR(255),
        `passwords` VARCHAR(255),
        `FontFamily_id` INT DEFAULT NULL,
        `Connected` TINYINT(1) DEFAULT 0,
        PRIMARY KEY (`id_user`, `username`),
        FOREIGN KEY (`FontFamily_id`) REFERENCES `FontFamily`(`FontFamily_id`)
    );

CREATE TABLE
    IF NOT EXISTS `Message` (
        `id_mes` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        `id_user` INT NOT NULL,
        `content` TEXT NOT NULL,
        `date` DATETIME NOT NULL,
        `milliseconds` INT NOT NULL,
        FOREIGN KEY (`id_user`) REFERENCES `User`(`id_user`)
    );
INSERT INTO FontFamily (font_family)
VALUES 
('Consolas'),
('Courier'),
('Lucidatypewriter'),
('Monaco'),
('Comic Sans MS'),
('Lucida Sans Typewriter'),
('Arial Rounded MT Bold'),
('Marlett'),
('Webdings'),
('Wingdings'),
('MingLiU_HKSCS-ExtB'),
('Courier New'),
('Lucida Console'),
('Andale Mono'),
('Arial Black'),
('Brush Script'),
('Century Gothic'),
('Ink Free'),
('Lucida Handwriting'),
('MV Boli'),
('Segoe Print'),
('Segoe Script');



