CREATE TABLE math (
  math_inputhash              VARCHAR(16) FOR BIT DATA     NOT NULL  UNIQUE,
  math_outputhash             VARCHAR(16) FOR BIT DATA     NOT NULL,
  math_html_conservativeness  SMALLINT  NOT NULL,
  math_html                   CLOB(64K) INLINE LENGTH 4096,
  math_mathml                 CLOB(64K) INLINE LENGTH 4096
);
