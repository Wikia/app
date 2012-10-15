CREATE TABLE `script_log` (
	`script_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`time` DATETIME NOT NULL,
	`script_name` VARCHAR(128) NOT NULL,
	`comment` VARCHAR(128) NOT NULL
);

INSERT INTO `script_log` (`time`, `script_name`)
	VALUES
		(NOW(), '1 - Remove old versioning columns.sql'), 
		(NOW(), '2 - Create new versioning.sql'), 
		(NOW(), '3 - Create new versioning.sql'), 
		(NOW(), '4 - Add source id column.sql'), 
		(NOW(), '5 - Create new versioning.sql'),
		(NOW(), '6 - Remove set_id from uw_alt_meaningtexts.sql'),
		(NOW(), '7 - Objects.sql'),
		(NOW(), '8 - Move class membership to separate table.sql'),
		(NOW(), '9 - Add UUIDs to objects.sql'),
		(NOW(), '10 - Add database script log.sql'); 