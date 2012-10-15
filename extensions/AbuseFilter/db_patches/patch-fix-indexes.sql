-- Fixes abuse_filter_log indices.

--# 	PRIMARY KEY (afl_id),
--# 	KEY (afl_filter,afl_timestamp),
--# 	KEY (afl_user,afl_user_text,afl_timestamp),
--# 	KEY (afl_timestamp),
--# 	KEY (afl_namespace, afl_title, afl_timestamp),
--# 	KEY (afl_ip, afl_timestamp)

ALTER TABLE /*_*/abuse_filter_log ADD KEY filter_timestamp (afl_filter,afl_timestamp);
ALTER TABLE /*_*/abuse_filter_log ADD KEY user_timestamp (afl_user,afl_user_text,afl_timestamp);
ALTER TABLE /*_*/abuse_filter_log ADD KEY page_timestamp (afl_namespace, afl_title, afl_timestamp);
ALTER TABLE /*_*/abuse_filter_log ADD KEY ip_timestamp (afl_ip, afl_timestamp);

ALTER TABLE /*_*/abuse_filter_log DROP KEY afl_filter;
ALTER TABLE /*_*/abuse_filter_log DROP KEY afl_user;
ALTER TABLE /*_*/abuse_filter_log DROP KEY afl_namespace;
ALTER TABLE /*_*/abuse_filter_log DROP KEY afl_ip;
