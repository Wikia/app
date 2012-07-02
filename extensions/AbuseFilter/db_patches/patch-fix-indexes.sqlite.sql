-- Fixes abuse_filter_log indices.

--# 	PRIMARY KEY (afl_id),
--# 	KEY (afl_filter,afl_timestamp),
--# 	KEY (afl_user,afl_user_text,afl_timestamp),
--# 	KEY (afl_timestamp),
--# 	KEY (afl_namespace, afl_title, afl_timestamp),
--# 	KEY (afl_ip, afl_timestamp)

CREATE INDEX afl_filter_timestamp ON /*$wgDBprefix*/abuse_filter_log (afl_filter,afl_timestamp);
CREATE INDEX afl_user_timestamp ON /*$wgDBprefix*/abuse_filter_log (afl_user,afl_user_text,afl_timestamp);
CREATE INDEX afl_page_timestamp ON /*$wgDBprefix*/abuse_filter_log (afl_namespace, afl_title, afl_timestamp);
CREATE INDEX afl_ip_timestamp ON /*$wgDBprefix*/abuse_filter_log (afl_ip, afl_timestamp);

ALTER TABLE /*_*/abuse_filter_log DROP KEY afl_filter;
ALTER TABLE /*_*/abuse_filter_log DROP KEY afl_user;
ALTER TABLE /*_*/abuse_filter_log DROP KEY afl_namespace;
ALTER TABLE /*_*/abuse_filter_log DROP KEY afl_ip;
