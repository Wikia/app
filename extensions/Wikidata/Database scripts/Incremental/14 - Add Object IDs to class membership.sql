START TRANSACTION;

INSERT INTO `script_log` (`time`, `script_name`)
	VALUES (NOW(), '14 - Add Object IDs to class membership.sql');
	
CREATE TABLE `temporary_class_membership` (
	`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`class_mid` INT NOT NULL,
	`class_member_mid` INT NOT NULL,
	KEY `class_class_member` (`class_mid`, `class_member_mid`)
);

INSERT INTO `temporary_class_membership` (class_mid, class_member_mid) (
	SELECT DISTINCT class_mid, class_member_mid
	FROM uw_class_membership
);
	
INSERT INTO `objects` (`table`, `original_id`, UUID)
	(SELECT DISTINCT 'uw_class_membership', id, UUID() FROM temporary_class_membership);
	
ALTER TABLE uw_class_membership
	ADD `class_membership_id` INT NOT NULL FIRST,
	ADD INDEX (`class_membership_id`);	
	
UPDATE uw_class_membership, temporary_class_membership, objects 
	SET uw_class_membership.class_membership_id=objects.object_id 
	WHERE temporary_class_membership.id=objects.original_id AND objects.table='uw_class_membership'
	AND uw_class_membership.class_mid=temporary_class_membership.class_mid
	AND uw_class_membership.class_member_mid=temporary_class_membership.class_member_mid;
	
DROP TABLE `temporary_class_membership`;
	
COMMIT;
