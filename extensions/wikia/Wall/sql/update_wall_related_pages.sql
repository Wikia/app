alter table wall_related_pages add last_update timestamp;

alter table wall_related_pages drop key page_id_idx;

alter table wall_related_pages add key page_id_idx (`page_id`, `last_update`);

alter table wall_related_pages add unique key unique_key (`comment_id`, `page_id`);