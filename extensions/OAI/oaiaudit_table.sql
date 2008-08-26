DROP TABLE IF EXISTS /*$wgDBprefix*/oaiaudit;

CREATE TABLE /*$wgDBprefix*/oaiaudit (
  oa_client INTEGER,
  oa_timestamp VARCHAR(14),
  oa_dbname VARCHAR(32),

  oa_response_size INTEGER,
  oa_ip VARCHAR(32),
  oa_agent TEXT,

  oa_request TEXT,

  KEY (oa_client,oa_timestamp),
  KEY (oa_timestamp,oa_client)
) ENGINE=InnoDB;
