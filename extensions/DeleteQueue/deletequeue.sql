CREATE TABLE /*$wgDBprefix*/delete_queue (
	dq_case bigint NOT NULL AUTO_INCREMENT,
	dq_page bigint NOT NULL,
	dq_queue varchar(255) NOT NULL,
	dq_reason BLOB NULL,
	dq_timestamp char(14) binary NOT NULL,
	dq_expiry char(14) binary NOT NULL,
	dq_discussionpage bigint NOT NULL,
	dq_active tinyint(1) NOT NULL DEFAULT 1,

	PRIMARY KEY (dq_case),
	UNIQUE KEY (dq_page,dq_active),
	KEY (dq_queue),
	KEY (dq_timestamp),
	UNIQUE KEY (dq_discussionpage)
) /*$wgDBTableOptions*/;

CREATE TABLE /*$wgDBprefix*/delete_queue_role (
	dqr_case bigint NOT NULL,
	dqr_user bigint NOT NULL,
	dqr_user_text varbinary(255) NOT NULL,
	dqr_type varchar(255) NOT NULL,

	PRIMARY KEY (dqr_case,dqr_user,dqr_type),
	KEY (dqr_case,dqr_type)
) /*$wgDBTableOptions*/;

CREATE TABLE /*$wgDBprefix*/delete_queue_vote (
	dqv_id bigint NOT NULL auto_increment,
	dqv_case bigint NOT NULL,
	dqv_user bigint NOT NULL,
	dqv_user_text varbinary(255) NOT NULL,
	dqv_endorse tinyint(1) NOT NULL, -- 1 = endorse, 0 = object
	dqv_timestamp char(14) NOT NULL,
	dqv_current tinyint(1) NOT NULL DEFAULT 1,
	dqv_comment TINYBLOB NULL,

	PRIMARY KEY (dqv_id),
	KEY (dqv_case,dqv_current,dqv_endorse),
	KEY (dqv_user_text,dqv_timestamp),
	KEY (dqv_timestamp)
) /*$wgDBTableOptions*/;
