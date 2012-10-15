CREATE TABLE math (
  math_inputhash              BYTEA     NOT NULL  UNIQUE,
  math_outputhash             BYTEA     NOT NULL,
  math_html_conservativeness  SMALLINT  NOT NULL,
  math_html                   TEXT,
  math_mathml                 TEXT
);
