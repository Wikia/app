-- transcodeTable.sql
-- 2011-04-05  <mdale@wikimedia.org>
--
CREATE TABLE /*$wgDBprefix*/transcode (
	transcode_id INT NOT NULL AUTO_INCREMENT, 
	transcode_image_name VARCHAR(255) NOT NULL, 
	transcode_key VARCHAR(48) NOT NULL, 
	transcode_error longtext NOT NULL, 
	transcode_time_addjob DATETIME NULL, 
	transcode_time_startwork DATETIME NULL, 
	transcode_time_success DATETIME NULL, 
	transcode_time_error DATETIME NULL, 
	transcode_final_bitrate INT NOT NULL,
	PRIMARY KEY (`transcode_id`)
);
CREATE INDEX /*$wgDBprefix*/transcode_name_inx ON /*$wgDBprefix*/transcode( transcode_image_name, transcode_key );
CREATE INDEX /*$wgDBprefix*/transcode_time_inx ON /*$wgDBprefix*/transcode( transcode_time_addjob ,transcode_time_startwork , transcode_time_success, transcode_time_error );
