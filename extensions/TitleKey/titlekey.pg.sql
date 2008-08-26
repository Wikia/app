
-- Postgres version of schema for the TitleKey extension

CREATE TABLE titlekey (
  tk_page       INTEGER   NOT NULL PRIMARY KEY,
  tk_namespace  SMALLINT  NOT NULL,
  tk_key        TEXT      NOT NULL
);

CREATE INDEX titlekey_name_key ON titlekey(tk_namespace, tk_key);
