<!-- s:<?= __FILE__ ?> -->
<small><a href="<?php print $returnURL; ?>">Return</a></small><BR>
Log of email changes for <?= $rows[0]->user_name; ?><HR>

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
	echo "
		<td> {$row->old_email} </td>
		<td> {$row->new_email} </td>
		<td> {$row->changed_by_name} </td>
		<td> {$row->changed_by_ip} </td>
		<td> {$row->changed_at} </td>
	";
	echo "</tr>";
} ?>
</table>
<!-- e:<?= __FILE__ ?> -->
