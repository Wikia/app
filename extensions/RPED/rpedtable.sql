BEGIN;

CREATE TABLE rped_page(
rped_page_id                     int NOT NULL AUTO_INCREMENT,
rped_page_title                  varchar(256),
PRIMARY KEY (rped_page_id)
)
CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE INDEX rped_page_id ON          rped_page (rped_page_id);
CREATE INDEX rped_page_title ON       rped_page (rped_page_title);

COMMIT;
