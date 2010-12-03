<?php
/* This dynamically generates a list of test cases to run through */
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta content="text/html; charset=UTF-8" http-equiv="content-type" />
  <title>Athena Test Suite</title>
</head>
<body>
<table id="suiteTable" cellpadding="1" cellspacing="1" border="1" class="selenium"><tbody>
<tr><td><b>New Wiki Builder Test Suite</b></td></tr>
<?php
$generics = glob('./test*');

foreach ($generics as $generic ){
	$g = basename($generic);

	echo '<tr><td><a href="' . basename($g) . '">' . basename($g) . '</a></td></tr>' . "\n";
}
?>
</tbody></table>
</body>
</html>

