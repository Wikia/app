BEGIN;

ALTER TABLE flaggedimages
    CHANGE fi_img_timestamp fi_img_timestamp TIMESTAMPTZ NULL;

COMMIT;
