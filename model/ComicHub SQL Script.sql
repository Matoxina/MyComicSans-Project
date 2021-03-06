CREATE DATABASE IF NOT EXISTS comichub;
USE comichub;

CREATE TABLE IF NOT EXISTS User(
ID INT NOT NULL AUTO_INCREMENT,
Username VARCHAR(15) UNIQUE,
Userimg VARCHAR(30),
Pass VARCHAR(100),
Email VARCHAR(70), 
Birthdate DATE,
PRIMARY KEY(ID)

);

CREATE TABLE IF NOT EXISTS Comic(
ID INT NOT NULL AUTO_INCREMENT,
UserID INT NOT NULL,
ComicName VARCHAR(50),
Sinopsis MEDIUMTEXT,
Genre VARCHAR(100),
NSFW TINYINT,
Global_Rating FLOAT,
PRIMARY KEY (ID),
FOREIGN KEY (UserID) REFERENCES User(ID)
);

CREATE TABLE IF NOT EXISTS Chapter(
ID INT NOT NULL AUTO_INCREMENT,
ComicID INT NOT NULL,
ChapterName VARCHAR(45),
Path VARCHAR(60),
PRIMARY KEY (ID),
FOREIGN KEY (ComicID) REFERENCES Comic(ID) 
);

CREATE TABLE IF NOT EXISTS Commentary(
ID INT NOT NULL AUTO_INCREMENT,
PRIMARY KEY(ID),
UserID INT NOT NULL,
ChapterID INT NOT NULL,
Content VARCHAR(200),
FOREIGN KEY (UserID) REFERENCES User(ID),
FOREIGN KEY (ChapterID) REFERENCES Chapter(ID)

);

CREATE TABLE IF NOT EXISTS Review(
ID INT NOT NULL AUTO_INCREMENT,
PRIMARY KEY(ID),
UserID INT NOT NULL,
ComicID INT NOT NULL,
Rating FLOAT, 
Content VARCHAR(400),
FOREIGN KEY (ComicID) REFERENCES Comic(ID),
FOREIGN KEY (UserID) REFERENCES User(ID)
);

CREATE TABLE IF NOT EXISTS UserSettings(
ID INT NOT NULL AUTO_INCREMENT,
NSFWOnFeed TINYINT,
NSFWOnSearch TINYINT,
FavouriteGenres VARCHAR(90),
LastPasswordChange DATE,
PasswordRestored TINYINT,
PRIMARY KEY (ID)
);

CREATE TABLE IF NOT EXISTS ReadList(
ID INT NOT NULL AUTO_INCREMENT,
UserID INT NOT NULL,
Comics VARCHAR(300),
ReadListName VARCHAR(50),
PRIMARY KEY (ID),
FOREIGN KEY (UserID) REFERENCES User(ID)
);


DELIMITER //
CREATE TRIGGER set_settings AFTER INSERT ON User FOR EACH ROW 
BEGIN
	SET @current_date = CURDATE();
    INSERT INTO UserSettings(ID,NSFWOnFeed,NSFWOnSearch,FavouriteGenres,LastPasswordChange,PasswordRestored) 
    VALUES (NULL,0,0,NULL,@current_date ,0);
    
END //

DELIMITER ;
 
DELIMITER // 
CREATE TRIGGER adjust_rating AFTER INSERT ON Review FOR EACH ROW
-- faz média do rating de um comic
BEGIN 
	SET @last_inserted_id =LAST_INSERT_ID();
    SET @comic_id_of_row = (SELECT ComicID FROM Review WHERE ID = @last_inserted_id);
	SET @average_rating = (SELECT AVG(Rating) FROM Review WHERE ComicID = @comic_id_of_row);
    UPDATE Comic SET Global_rating = @average_rating WHERE ID =  @comic_id_of_row;
END//

DELIMITER ;
