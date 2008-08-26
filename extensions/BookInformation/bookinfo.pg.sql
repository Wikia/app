-- BookInformation cache table
-- Postgres version
--
-- This will speed up multiple requests for the same item, and
-- reduce hits on the provider -- set $wgBookInformationCache = true;
-- to use

CREATE TABLE bookinfo (

  -- ISBN, 10 or 13 characters
  bi_isbn varchar(13) NOT NULL,
  
  -- Result; a serialised BookInformationDriver
  bi_result bytea NOT NULL,
  
  PRIMARY KEY (bi_isbn)
);
