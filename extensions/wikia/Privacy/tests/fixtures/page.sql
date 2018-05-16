CREATE TABLE /*$wgDBprefix*/page (
   page_id        INT          NOT NULL  PRIMARY KEY,
   page_namespace INT          NOT NULL,
   page_title     NVARCHAR(255)  NOT NULL,
   page_is_redirect SMALLINT NOT NULL DEFAULT 0,
   page_len INT NOT NULL,
   page_latest INT NOT NULL
);
