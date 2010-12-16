-- Table for the Vote extension; holds individual votes
CREATE TABLE /*wgDBprefix*/vote (
  vote_id int(11) NOT NULL auto_increment,
  vote_user int(11) NOT NULL,
  vote_choice varchar(255) NOT NULL,
  PRIMARY KEY  (vote_id),
  KEY vote_choice (vote_choice)
);
