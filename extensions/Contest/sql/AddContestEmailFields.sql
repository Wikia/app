ALTER TABLE /*_*/contests 
	ADD COLUMN contest_signup_email VARCHAR(255) NOT NULL,
	ADD COLUMN contest_reminder_email VARCHAR(255) NOT NULL;
	
UPDATE /*_*/contests SET 
	contest_signup_email = 'MediaWiki:',
	contest_reminder_email = 'MediaWiki:';