# Support for one notice to supercede all others. This allows one notice to cancel out all the templates that a non preffered notice might have if they overlap.
# Use case is to be able to use one all language and projects notice and have it superceded by a specific one for en wikipedia  

ALTER TABLE cn_notices ADD COLUMN not_preferred bool NOT NULL default '0'; 
