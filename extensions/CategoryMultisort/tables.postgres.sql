CREATE TABLE categorylinks_multisort (
  clms_from         INTEGER      NOT NULL  REFERENCES page(page_id) ON DELETE CASCADE DEFERRABLE INITIALLY DEFERRED,
  clms_to           TEXT         NOT NULL,
  clms_sortkey_name TEXT         NOT NULL,
  clms_sortkey      TEXT
);
CREATE UNIQUE INDEX clms_from ON categorylinks_multisort (clms_from, clms_to, clms_sortkey_name);
CREATE INDEX clms_sortkey     ON categorylinks_multisort (clms_to, clms_sortkey, clms_sortkey_name, clms_from);
