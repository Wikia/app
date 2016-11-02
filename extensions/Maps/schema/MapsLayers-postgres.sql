BEGIN;

CREATE TABLE maps_layers (
 layer_page_id INTEGER NOT NULL REFERENCES page(page_id) ON DELETE CASCADE,
 layer_name    VARCHAR(64) DEFAULT NULL,
 layer_type    VARCHAR(32) NOT NULL,
 layer_data    TEXT NOT NULL
) /*$wgDBTableOptions*/;

COMMIT;