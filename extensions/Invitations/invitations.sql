CREATE TABLE /*$wgDBprefix*/invitation (
	inv_id BIGINT NOT NULL auto_increment,
	inv_inviter BIGINT NOT NULL,
	inv_invitee BIGINT NOT NULL,
	inv_type varchar(255) NOT NULL,
	inv_timestamp timestamp not null default current_timestamp,
	PRIMARY KEY (inv_id),
	KEY (inv_invitee,inv_type),
	KEY (inv_inviter),
	KEY (inv_type)
) /*$wgDBTableOptions*/;

CREATE TABLE /*$wgDBprefix*/invite_count (
	ic_user BIGINT NOT NULL,
	ic_type varchar(255) NOT NULL,
	ic_count BIGINT NOT NULL DEFAULT 0,
	PRIMARY KEY (ic_user,ic_type),
	KEY (ic_user,ic_type,ic_count)
) /*$wgDBTableOptions*/;
