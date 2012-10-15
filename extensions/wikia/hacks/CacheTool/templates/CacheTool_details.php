<a href ="/wiki/Special:CacheTool"> Back To List </a>
<table>
	<th> Key </th> <th> Get# </th> <th> Set# </th> <th> Size </th> <th> Action </th>
<?php
	foreach ($keys as $k => $v ) {
		echo "<tr><td> $k </td> <td> {$v['getcount']} </td> <td> {$v['setcount']} </td> <td> {$v['size']} </td> <td> ";
		echo "<button class=\"CacheToolContentsButton\" data-key=\"{$k}\"> Contents </button>";
		echo "<button class=\"CacheToolDeleteButton\" data-key=\"{$k}\"> Delete </button>";
		echo "</td></tr>";
	}
?>
</table>
