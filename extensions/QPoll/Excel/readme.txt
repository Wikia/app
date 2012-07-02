http://pear.php.net

Uses the following PEAR classes:

PEAR-1.9.1.tgz
Console_Getopt-1.3.0.tgz
OLE-1.0.0RC1.tgz
Spreadsheet_Excel_Writer-0.9.2.tgz

Nested filename paths are replaced to longer filenames with underscores, because I find deep nesting unhandy.
require_once() and include_once() calls are made relative from qp_Setup::$ExtDir extension's property.

2009-09-18: patch to Excel_Workbook.php
Removed "& new" (create object by reference) because it is incompatible with future versions of PHP

2010-12-19: tweaked for PHP 5.3 in E_STRICT mode

2011-02-02: get rid of additional PHP 5.3 deprecations; upgrade classes to latest PEAR version
