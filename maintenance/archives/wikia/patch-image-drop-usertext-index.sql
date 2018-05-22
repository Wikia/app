-- cleanup redundant indexes from images tables
ALTER TABLE image DROP INDEX img_usertext_timestamp;
