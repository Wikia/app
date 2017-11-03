ALTER TABLE /*$wgDBprefix*/wall_related_pages DROP KEY page_id_idx;
ALTER TABLE /*$wgDBprefix*/wall_related_pages RENAME INDEX page_id_idx_2 TO page_id_idx;
OPTIMIZE TABLE /*$wgDBprefix*/wall_related_pages;