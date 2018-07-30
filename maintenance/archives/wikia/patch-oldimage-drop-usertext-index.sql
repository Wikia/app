-- cleanup redundant indexes from images tables
ALTER TABLE oldimage DROP INDEX oi_usertext_timestamp;
