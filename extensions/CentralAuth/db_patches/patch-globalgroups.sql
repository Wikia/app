-- This patch allows storing global groups in the database.
-- Andrew Garrett (Werdna), April 2008.

-- Global user groups.
CREATE TABLE global_user_groups (
	gug_user int(11) not null,
	gug_group varchar(255) not null,
	
	PRIMARY KEY (gug_user,gug_group),
	KEY (gug_user),
	key (gug_group)
) /*$wgDBTableOptions*/;

-- Global group permissions.
CREATE TABLE global_group_permissions (
	ggp_group varchar(255) not null,
	ggp_permission varchar(255) not null,
	
	PRIMARY KEY (ggp_group, ggp_permission),
	KEY (ggp_group),
	KEY (ggp_permission)
) /*$wgDBTableOptions*/;

-- Create a starter group, which users can be added to.
INSERT INTO global_group_permissions (ggp_group,ggp_permission) VALUES ('steward','globalgrouppermissions'),('steward','globalgroupmembership');
