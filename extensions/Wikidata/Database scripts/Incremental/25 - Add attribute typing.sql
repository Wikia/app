ALTER TABLE `uw_class_attributes` ADD COLUMN `attribute_type` char(4) NOT NULL DEFAULT 'TEXT' AFTER `attribute_mid`;

CREATE TABLE `uw_option_attribute_options` (
	`option_id`				int(11) NOT NULL DEFAULT 0,
	`attribute_id`			int(11)	NOT NULL DEFAULT 0,
	`option_mid`			int(11) NOT NULL DEFAULT 0,
	`language_id`			int(11) NOT NULL DEFAULT 0,
	`add_transaction_id`	int(11) NOT NULL DEFAULT 0,
	`remove_transaction_id`	int(11) NULL
);

CREATE TABLE `uw_option_attribute_values` (
	`value_id`				int(11) NOT NULL DEFAULT 0,
	`object_id`				int(11) NOT NULL DEFAULT 0,
	`option_id`				int(11) NOT NULL DEFAULT 0,
	`add_transaction_id`	int(11) NOT NULL DEFAULT 0,
	`remove_transaction_id`	int(11) NULL
);

INSERT INTO `script_log` (`time`, `script_name`)
        VALUES (NOW(), '25 - Add attribute typing.sql');
