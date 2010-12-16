--
-- Schema patch for OptIn
--

ALTER TABLE /*_*/optin_survey add column ois_type varchar(16) NOT NULL;