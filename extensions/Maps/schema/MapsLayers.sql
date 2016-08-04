CREATE TABLE IF NOT EXISTS /*_*/maps_layers (
	layer_page_id int REFERENCES /*_*/page(page_id) ON DELETE CASCADE,
	layer_name    varchar(64) binary default NULL,
	layer_type    varchar(32) binary NOT NULL,
	layer_data    text NOT NULL
) /*$wgDBTableOptions*/;