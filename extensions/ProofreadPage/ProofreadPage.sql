-- Table for the ProofreadPage extension. 
-- Holds a count of the number of pages at each quality level
CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/pr_index (
  -- Foreign key to page.page_id
  pr_page_id integer NOT NULL,
  -- number of pages in index
  pr_count integer NOT NULL default '0',
  -- number of pages in each quality level
  pr_q0 integer NOT NULL default '0',
  pr_q1 integer NOT NULL default '0',
  pr_q2 integer NOT NULL default '0',
  pr_q3 integer NOT NULL default '0',
  pr_q4 integer NOT NULL default '0',
  PRIMARY KEY (pr_page_id)
)  /*$wgDBTableOptions*/;
