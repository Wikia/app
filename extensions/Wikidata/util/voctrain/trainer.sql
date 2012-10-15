DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `exercises`;
DROP TABLE IF EXISTS `auth`;



CREATE TABLE `auth` (
	username VARCHAR(50) default '' NOT NULL,
	password VARCHAR(32) default '' NOT NULL,
	`uiLanguage` 	CHAR(3) ,
	PRIMARY KEY (username),
	KEY (password)
) ENGINE=INNODB;

CREATE TABLE `exercises` (
	`id` 			INT 		PRIMARY KEY NOT NULL AUTO_INCREMENT,
	`username` 		VARCHAR(50)	,
	`master_id`		INT		,
	`completion`		SMALLINT,
	`questionLanguages`	VARCHAR(50)	,
	`answerLanguages`	VARCHAR(50) ,
	`exercise`		LONGTEXT,
	KEY(username),
	KEY(master_id),
	FOREIGN KEY (`username`) REFERENCES `auth`(`username`)
		ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=INNODB;




