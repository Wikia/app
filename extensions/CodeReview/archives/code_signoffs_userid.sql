ALTER TABLE /*_*/code_signoffs
 ADD COLUMN cs_user int not null AFTER cs_rev_id;