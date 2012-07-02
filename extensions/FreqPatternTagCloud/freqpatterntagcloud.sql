CREATE TABLE IF NOT EXISTS /*_*/fptc_associationrules (
	`rule_id` int(11) NOT NULL PRIMARY KEY auto_increment,
	`p_id` int(8) NOT NULL COMMENT 'Attribute',
	`rule_support` float(5,3) NOT NULL,
	`rule_confidence` float(5,3) NOT NULL
)/*$wgDBTableOptions*/;

CREATE INDEX /*i*/p_id ON /*_*/fptc_associationrules (p_id);

CREATE TABLE IF NOT EXISTS /*_*/fptc_items (
	`o_id` INT(8) NOT NULL,
	`rule_id` INT NOT NULL,
	`item_order` TINYINT(1) NOT NULL,
	PRIMARY KEY ( `o_id` , `rule_id` )
)/*$wgDBTableOptions*/;