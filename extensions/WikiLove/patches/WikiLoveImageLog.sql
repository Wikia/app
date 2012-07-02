--
-- WikiLove image logging schema
-- Logs every time someone attempts to preview an award with a user-entered image title.
-- This is mainly to see if people understand the idea of using images from Commons.
--

CREATE TABLE IF NOT EXISTS /*_*/wikilove_image_log (
	wlil_id int(11) NOT NULL PRIMARY KEY auto_increment,
	wlil_timestamp binary(14) NOT NULL,
	wlil_user_id int(11) NOT NULL,
	wlil_image varchar(128) NOT NULL,
	wlil_success bool NOT NULL
) /*$wgDBTableOptions*/;

CREATE INDEX /*i*/wlil_timestamp ON /*_*/wikilove_image_log (wlil_timestamp);
CREATE INDEX /*i*/wlil_user_time ON /*_*/wikilove_image_log (wlil_user_id, wlil_timestamp);
