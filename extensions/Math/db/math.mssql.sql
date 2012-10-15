--
-- Used by the math module to keep track
-- of previously-rendered items.
--
CREATE TABLE /*$wgDBprefix*/math (
   math_inputhash varbinary(16) NOT NULL PRIMARY KEY,
   math_outputhash varbinary(16) NOT NULL,
   math_html_conservativeness tinyint NOT NULL,
   math_html NVARCHAR(MAX),
   math_mathml NVARCHAR(MAX),
);
