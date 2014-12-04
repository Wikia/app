CREATE DATABASE nss_auth;

USE nss_auth;

CREATE TABLE passwd (
	pwd_uid int not null,
	pwd_name varchar(255),
	pwd_password varbinary(255),
	pwd_password_lastchange int not null,
	pwd_gid int not null,
	pwd_home varchar(255) default null,
	pwd_shell varchar(255) default '/bin/sh',
	pwd_active varchar(15) default 1,
	pwd_email varchar(255) not null,

	PRIMARY KEY (pwd_uid),
	UNIQUE INDEX (pwd_name)
) character set ascii collate ascii_general_ci;

CREATE TABLE groups (
	grp_gid int not null,
	grp_name varchar(255),
	grp_password varchar(255) not null,

	PRIMARY KEY(grp_gid),
	INDEX (grp_name)
) character set ascii collate ascii_general_ci;

CREATE TABLE group_membership (
	gm_user int not null,
	gm_group varchar(255),

	PRIMARY KEY (gm_user, gm_group),
	KEY (gm_group)
) character set ascii collate ascii_general_ci;

CREATE TABLE permission (
	perm_user int not null,
	perm_action varbinary(255),
	perm_permission varbinary(255)
) character set ascii collate ascii_general_ci;

CREATE TABLE user_props (
	up_user varchar(255),
	up_timestamp binary(14),
	up_name varchar(255),
	up_value blob,

	INDEX(up_name),
	INDEX(up_user, up_timestamp)
) character set ascii collate ascii_general_ci;

GRANT USAGE ON nss_auth.* TO `nss-root`@`localhost` IDENTIFIED BY 'secretpassword';
GRANT USAGE ON nss_auth.* TO `nss-user`@`localhost` IDENTIFIED BY 'publiclyviewablepassword';

GRANT SELECT ON nss_auth.* TO `nss-root`@`localhost`;
GRANT SELECT (pwd_uid, pwd_name, pwd_gid, pwd_home, pwd_shell, pwd_active) ON nss_auth.passwd TO `nss-user`@`localhost`;
GRANT SELECT ON nss_auth.groups TO `nss-user`@`localhost`;
GRANT SELECT ON nss_auth.group_membership TO `nss-user`@`localhost`;
