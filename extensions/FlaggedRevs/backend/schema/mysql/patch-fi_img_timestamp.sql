-- Fix bad fi_img_timestamp definition
ALTER TABLE /*$wgDBprefix*/flaggedimages
    CHANGE fi_img_timestamp fi_img_timestamp varbinary(14) NULL;
-- Move bad values over to NULL
UPDATE /*$wgDBprefix*/flaggedimages
    SET fi_img_timestamp = NULL WHERE LOCATE( '\0', fi_img_timestamp );
