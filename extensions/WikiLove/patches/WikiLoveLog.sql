--
-- WikiLove logging schema
-- Logs all actions of giving WikiLove.
-- Not final, please apply this patch manually for now!
--

CREATE TABLE IF NOT EXISTS /*_*/wikilove_log (
	wll_id int NOT NULL PRIMARY KEY auto_increment,		-- unique id
	wll_timestamp binary(14) NOT NULL,              	-- timestamp
	wll_sender int(11) NOT NULL,                    	-- user id of the sender
	wll_sender_registration binary(14) default NULL,	-- registration date of the sender
	wll_sender_editcount int(11) default NULL,			-- total number of edits for the sender
	wll_receiver int(11) NOT NULL,                  	-- user id of the receiver
	wll_receiver_registration binary(14) default NULL,	-- registration date of the receiver
	wll_receiver_editcount int(11) default NULL,		-- total number of edits for the receiver
	wll_type varchar(64) NOT NULL,                  	-- type (and subtype) of message
	wll_subject varchar(255) NOT NULL,              	-- subject line
	wll_message blob NOT NULL,                      	-- actual message
	wll_email bool NOT NULL default '0'             	-- whether or not a notification mail has been sent
) /*$wgDBTableOptions*/;

CREATE INDEX /*i*/wll_timestamp ON /*_*/wikilove_log (wll_timestamp);
CREATE INDEX /*i*/wll_type_time ON /*_*/wikilove_log (wll_type, wll_timestamp);
CREATE INDEX /*i*/wll_sender_time ON /*_*/wikilove_log (wll_sender, wll_timestamp);
CREATE INDEX /*i*/wll_receiver_time ON /*_*/wikilove_log (wll_receiver, wll_timestamp);
-- ASSUMPTION: once narrowed down to a single user (sender/receiver), we can afford a filesort
-- as a single users will have only limited WikiLove messages from or to him/her. It's not worth
-- the memory of extra indexes to cover all the combinations (sender/receiver/type => 8 indexes)
