
INSERT INTO BD_CHAT.`User`(username, passwords, FontFamily_id)
VALUES ('ubuntu', 'Demonone@12345', (SELECT `FontFamily_id` FROM `FontFamily` ORDER BY RAND() LIMIT 1)), 
('test', 'Demonone@12345', (SELECT `FontFamily_id` FROM `FontFamily` ORDER BY RAND() LIMIT 1));
