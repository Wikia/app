<!-- s:<?= __FILE__ ?> -->
<small><a href="<?php print $returnURL; ?>">Return</a></small><BR>
Log of email changes for <?= $userName ?><HR>

<table border=1 cellpadding=5>
<tr>
	<th> Old Email </th>
	<th> New Email </th>
	<th> Changed By </th>
	<th> Changed By IP </th>
	<th> Changed At </th>
</tr>
<?php
    foreach ($rows as $row) {
	echo "<tr>";
	echo "<td> " . htmlentities($row->old_email) . " </td>\n";
	echo "<td> " . htmlentities($row->new_email) . " </td>\n";
	echo "<td> " . htmlentities($row->changed_by_name) . " </td>\n";
	echo "<td> " . htmlentities($row->changed_by_ip) . " </td>\n";
	echo "<td> " . htmlentities($row->changed_at) . " GMT </td>\n";
	echo "</tr>";
} ?>
</table>
<!-- e:<?= __FILE__ ?> -->
