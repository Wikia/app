BEGIN;

CREATE TABLE flaggedrevs_tracking (
  ftr_from       INTEGER   NOT NULL DEFAULT 0,
  ftr_namespace  SMALLINT  NOT NULL DEFAULT 0,
  ftr_title      TEXT       NOT NULL DEFAULT '',
  PRIMARY KEY (ftr_from,ftr_namespace,ftr_title)
);
CREATE INDEX namespace_title_from ON flaggedrevs_tracking (ftr_namespace,ftr_title,ftr_from)

COMMIT;
