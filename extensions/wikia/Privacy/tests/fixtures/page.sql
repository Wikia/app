CREATE TABLE /*$wgDBprefix*/page (
   page_id        INT          NOT NULL  PRIMARY KEY,
   page_namespace INT          NOT NULL,
   page_title     NVARCHAR(255)  NOT NULL
);
