CREATE TABLE users (
	user_id int unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
	user_registered timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	user_email varchar(255) NOT NULL,
	user_password varchar(255) NOT NULL,
	user_newpassword varchar(255) DEFAULT NULL,
	user_payerid char(13)
) ENGINE=InnoDB;
CREATE INDEX user_email ON users (user_email);

insert into users select null, min(ad_created) as created, ad_user_email, 'createme', null, ppd_payerid from ads, pp_tokens, pp_details where ad_id=ppt_ad_id and ppt_token=ppd_token group by ad_user_email,ppd_payerid order by created;

CREATE TABLE billing (
	billing_id int unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
	billing_user_id int unsigned NOT NULL,
	billing_timestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	billing_amount decimal(5,2) NOT NULL,
	billing_ad_id int NOT NULL,
	billing_ppp_id int NOT NULL
) ENGINE=InnoDB;
CREATE temporary TABLE billing_temp (
	billing_id int unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
	billing_user_id int unsigned NOT NULL,
	billing_timestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	billing_amount decimal(5,2) NOT NULL,
	billing_ad_id int NOT NULL,
	billing_ppp_id int NOT NULL
) ENGINE=InnoDB;
insert into billing_temp select null, user_id, ppp_responded, -ppp_amount, ad_id, 0 from pp_payments,pp_agreements,pp_tokens,pp_details,ads,users where ppp_baid=ppa_baid and ppa_token=ppt_token and ppt_token=ppd_token and ppt_ad_id=ad_id and ad_user_email=user_email and user_payerid=ppd_payerid;
insert into billing_temp select null, user_id, ppp_responded, ppp_amount, 0, ppp_id from pp_payments,pp_agreements,pp_tokens,pp_details,ads,users where ppp_baid=ppa_baid and ppa_token=ppt_token and ppt_token=ppd_token and ppt_ad_id=ad_id and ad_user_email=user_email and user_payerid=ppd_payerid;

insert into billing select null, billing_user_id, billing_timestamp, billing_amount, billing_ad_id, billing_ppp_id from billing_temp order by billing_timestamp, billing_id;
drop table billing_temp;

alter table ads add ad_user_id int unsigned NOT NULL;
alter table pp_tokens add ppt_user_id int unsigned DEFAULT NULL;
update ads,users,pp_tokens,pp_details set ad_user_id=user_id,ppt_user_id=user_id where ad_user_email=user_email and ppt_ad_id=ad_id and ppt_token=ppd_token and ppd_payerid=user_payerid;

alter table pp_agreements add ppa_canceled timestamp NULL DEFAULT NULL;

-- CLEAN UP ITEMS
-- alter table ads drop ad_user_email;
-- alter table pp_tokens drop ppt_ad_id;
-- alter table users drop user_payerid;
-- delete from ads where ad_user_id=0 and ad_expires is null;
