--
-- Schema update for OptIn
--

ALTER TABLE /*_*/prefswitch_survey ADD COLUMN pss_user_text varchar(255) binary NOT NULL AFTER pss_user;