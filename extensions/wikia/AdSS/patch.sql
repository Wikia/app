update ads set ad_price=ad_price*ad_weight;

alter table ads add ad_type char(1) NOT NULL;
update ads set ad_type='t';

alter table ads change ad_url ad_url text NULL DEFAULT NULL;
alter table ads change ad_text ad_text text NULL DEFAULT NULL;
alter table ads change ad_desc ad_desc text NULL DEFAULT NULL;

alter table ads add ad_user_email text NOT NULL;
update ads,users set ad_user_email=user_email where ad_user_id=user_id;

alter table pp_tokens add ppt_ad_id int unsigned DEFAULT NULL;
