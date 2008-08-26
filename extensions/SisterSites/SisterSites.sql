CREATE TABLE /*$wgDBprefix*/sistersites_site (
  -- Internal ID number, keys to sistersites_page.ssp_site
  sss_id INT AUTO_INCREMENT,
  
  -- Symbolic or descriptive name of the site
  sss_name TEXT,
  
  -- Interwiki prefix of the site
  sss_interwiki TEXT,
  
  -- URL to the page list (possibly gzipped)
  -- Should be in WSR-1 format
  -- http://www.eekim.com/cgi-bin/wiki.pl?SisterSites
  sss_listurl TEXT,
  
  PRIMARY KEY (sss_id)
) TYPE=InnoDB;

CREATE TABLE /*$wgDBprefix*/sistersites_page (
  ssp_id INT AUTO_INCREMENT,
  
  -- Key to sistersites_site.sss_id
  -- Indicates which site this thingy came from
  ssp_site INT,
  
  -- Normalized version of the title for matching
  -- * lowercase
  -- * whitespace, underscores, and punctuation removed
  ssp_normalized_title VARCHAR(255),
  
  -- Display title of the foreign page, as provided by the list
  ssp_title VARCHAR(255),
  
  -- URL to the foreign page, as provided by the list
  ssp_url VARCHAR(255),
  
  
  PRIMARY KEY (ssp_id),
  
  -- Index for title matching on page display
  KEY (ssp_normalized_title, ssp_site),
  
  -- Index for updating sites
  KEY (ssp_site, ssp_url)
) TYPE=InnoDB;
