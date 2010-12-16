--
-- Schema patch for OptIn
--

ALTER TABLE /*_*/optin_survey modify ois_type varchar(16) NOT NULL;