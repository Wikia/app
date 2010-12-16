http://pear.php.net

Uses the following PEAR classes:

PEAR-1.8.1.tgz
OLE-1.0.0RC1.tgz
Spreadsheet_Excel_Writer-0.9.1.tgz

Nested filename paths are replaced to longer filenames with underscores, because I find deep nesting unhandy.
require_once() and include_once() calls are made relative from qp_Setup::$ExtDir extension's property.

Spreadsheet_Excel_Writer-0.9.1 has a bug related to UTF16-LE string cell data encoding.
This bug can cause corruption of exported XLS files when non-ASCII set of codes
(such as Cyrillic or Chinesse) are used in polls.

The following path has been applied to 'Excel_Workbook.php' to fix this problem:
http://blog.teatime.com.tw/post/1/111

The patch still hasn't been merged into PEAR SVN (2009, april 27th ).
Watch these bugreports for further information:
http://pear.php.net/bugs/bug.php?id=1572
http://pear.php.net/bugs/bug.php?id=2159

18.09.2009: patch to Excel_Workbook.php
Removed "& new" (create object by reference) because it is incompatible with future versions of PHP
