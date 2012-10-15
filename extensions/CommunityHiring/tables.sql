-- Adds tables for CommunityHiring
CREATE TABLE /*_*/community_hiring_application (
	ch_id int unsigned auto_increment,
	ch_data LONGBLOB,
	ch_timestamp varbinary(14),
	ch_ip varbinary(64),
	primary key (ch_id)
);
