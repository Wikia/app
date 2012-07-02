--
-- Used by the math module to keep track
-- of previously-rendered items.
--
CREATE TABLE /*_*/math (
  -- Binary MD5 hash of the latex fragment, used as an identifier key.
  math_inputhash varbinary(16) NOT NULL,

  -- Not sure what this is, exactly...
  math_outputhash varbinary(16) NOT NULL,

  -- texvc reports how well it thinks the HTML conversion worked;
  -- if it's a low level the PNG rendering may be preferred.
  math_html_conservativeness tinyint NOT NULL,

  -- HTML output from texvc, if any
  math_html text,

  -- MathML output from texvc, if any
  math_mathml text
) /*$wgDBTableOptions*/;

CREATE UNIQUE INDEX /*i*/math_inputhash ON /*_*/math (math_inputhash);
