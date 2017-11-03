ALTER TABLE /*$wgDBprefix*/wall_related_pages DROP KEY page_id_idx;
ALTER TABLE /*$wgDBprefix*/wall_related_pages DROP KEY page_id_idx_2, ADD KEY page_id_idx(`page_id`,`last_update`);
OPTIMIZE TABLE /*$wgDBprefix*/wall_related_pages;