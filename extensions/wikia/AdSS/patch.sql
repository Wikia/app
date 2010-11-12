update ads set ad_price=ad_price*ad_weight;
alter table ads add ad_type char(1) NOT NULL;
alter table ads add ad_banner_path text NOT NULL;
alter table ads change ad_url ad_url text NULL DEFAULT NULL;
alter table ads change ad_text ad_text text NULL DEFAULT NULL;
alter table ads change ad_desc ad_desc text NULL DEFAULT NULL;
alter table ads change ad_banner_path ad_banner_path text NULL DEFAULT NULL;
