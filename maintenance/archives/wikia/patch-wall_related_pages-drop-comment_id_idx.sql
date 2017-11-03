ALTER TABLE /*$wgDBprefix*/wall_related_pages DROP KEY comment_id_idx;
OPTIMIZE TABLE /*$wgDBprefix*/wall_related_pages;