CREATE TABLE /*_*/openstack_puppet_groups (
	-- ID for groups. Puppet variables and classes
	-- may be grouped, and can share the same group.
	group_id int not null primary key auto_increment,

	-- User-presentable name of the group
	group_name varchar(255) binary not null,

	-- Position of group when displayed
	group_position int not null

	-- OpenStack project to which this group belongs, if any
	group_project varchar(255) binary,

) /*$wgDBTableOptions*/;

CREATE INDEX /*i*/group_name on /*_*/openstack_puppet_groups (group_name);

CREATE TABLE /*_*/openstack_puppet_vars (
	-- ID for puppet variable
	var_id int not null primary key auto_increment,

	-- User-presentable name of puppet variable
	var_name varchar(255) binary not null,

	-- Group to which this variable belongs
	var_group_id int not null,

	-- Position of variable inside its group
	var_position int not null

) /*$wgDBTableOptions*/;

CREATE TABLE /*_*/openstack_puppet_classes (
	-- IF for puppet class
	class_id int not null primary key auto_increment,

	-- User-presentable name of puppet class
	class_name varchar(255) binary not null,

	-- Group to which this class belongs
	class_group_id int not null,

	-- Position of class inside its group
	class_position int not null

) /*$wgDBTableOptions*/;
