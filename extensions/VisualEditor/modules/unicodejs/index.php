<!--
/**
 * UnicodeJS tests
 *
 * @file
 * @copyright 2013 UnicodeJS team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */
-->
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>UnicodeJS Tests</title>

		<!-- Test framework -->
		<link rel="stylesheet" href="../qunit/qunit.css">
		<script src="../qunit/qunit.js"></script>

		<!-- Code Dependencies -->
		<script src="../jquery/jquery.js"></script>

		<!-- Code -->
		<script src="unicodejs.js"></script>
		<script src="unicodejs.textstring.js"></script>
		<script src="unicodejs.graphemebreakproperties.js"></script>
		<script src="unicodejs.graphemebreak.js"></script>
		<script src="unicodejs.wordbreakproperties.js"></script>
		<script src="unicodejs.wordbreak.js"></script>

		<!-- Code Tests (also update VisualEditorHooks::onResourceLoaderTestModules) -->
		<script src="test/unicodejs.test.js"></script>
		<script src="test/unicodejs.graphemebreak.test.js"></script>
		<script src="test/unicodejs.wordbreak.test.js"></script>
	</head>
	<body>
		<div id="qunit"></div>
	</body>
</html>
