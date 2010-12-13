alter table users add user_pp_payerid char(13) NULL DEFAULT NULL;
alter table users add user_pp_baid char(19) NULL DEFAULT NULL;
alter table ads add ad_pp_token char(20) NULL DEFAULT NULL;

update users,pp_tokens,pp_details set user_pp_payerid=ppd_payerid where user_id=ppt_user_id and ppt_token=ppd_token;
update users,pp_tokens,pp_agreements set user_pp_baid=ppa_baid where user_id=ppt_user_id and ppt_token=ppa_token;
update ads,pp_tokens set add_pp_token=ppt_token where ppt_ad_id=ad_id;
