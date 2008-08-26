CREATE TABLE dympage (
  dp_pageid INTEGER NOT NULL,
  dp_normid INTEGER NOT NULL,
  PRIMARY KEY (dp_pageid)
);

CREATE SEQUENCE dymnorm_dn_normid_seq;
CREATE TABLE dymnorm (
  dn_normid    INTEGER NOT NULL DEFAULT nextval('dymnorm_dn_normid_seq'),
  dn_normtitle TEXT    NOT NULL,
  PRIMARY KEY (dn_normid)
);
CREATE INDEX dymnorm_title ON dymnorm(dn_normtitle);
