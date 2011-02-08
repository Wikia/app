CREATE TABLE users (
  user_id int unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  user_registered timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  user_email varchar(255) NOT NULL,
  user_password varchar(255) NOT NULL,
  user_newpassword varchar(255) DEFAULT NULL,
  user_pp_payerid char(13) NULL DEFAULT NULL,
  user_pp_baid char(19) NULL DEFAULT NULL
) ENGINE=InnoDB;
CREATE UNIQUE INDEX user_email ON users (user_email);

CREATE TABLE billing (
  billing_id int unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  billing_user_id int unsigned NOT NULL,
  billing_timestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  billing_amount decimal(5,2) NOT NULL,
  billing_ad_id int NOT NULL,
  billing_ppp_id int NOT NULL
) ENGINE=InnoDB;

CREATE TABLE ads (
  ad_id int unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  ad_user_id int unsigned NOT NULL,
  ad_type char(1) NOT NULL,
  ad_hub_id int unsigned NOT NULL,
  ad_wiki_id int unsigned NOT NULL,
  ad_page_id int unsigned NOT NULL,
  ad_url text NULL DEFAULT NULL,
  ad_text text NULL DEFAULT NULL,
  ad_desc text NULL DEFAULT NULL,
  ad_status tinyint unsigned NOT NULL,
  ad_created timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  ad_closed timestamp NULL DEFAULT NULL,
  ad_expires timestamp NULL DEFAULT NULL,
  ad_weight tinyint unsigned NOT NULL,
  ad_price decimal(5,2) NOT NULL,
  ad_price_period char(1) NOT NULL,
  ad_pp_token char(20) NULL DEFAULT NULL
) ENGINE=InnoDB;

