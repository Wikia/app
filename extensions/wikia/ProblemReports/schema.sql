CREATE TABLE /*$wgDBprefix*/problem_reports (
	pr_id int not null auto_increment primary key,
	pr_cat varchar(32) not null,
	pr_summary varchar(512),
	pr_ns int not null,
	pr_title varchar(255) not null,
	pr_city_id int,
	pr_server varchar(128),
	pr_anon_reporter int(1),
	pr_reporter varchar(128),
	pr_ip int(32) unsigned not null,
	pr_email varchar(128),
	pr_browser varhar(256),
	pr_date datetime not null,
	pr_status int(8)
);
