ALTER TABLE /*_*/code_signoffs
 ADD COLUMN cs_timestamp_struck varbinary(14) not null default 'infinity';
DROP INDEX /*i*/cs_repo_rev_user_flag ON /*_*/code_signoffs;
CREATE UNIQUE INDEX /*i*/cs_repo_rev_user_flag_tstruck ON /*_*/code_signoffs (cs_repo_id, cs_rev_id, cs_user_text, cs_flag, cs_timestamp_struck);
