<section id="QuickStatsWidget">
	<h1> Statistics </h1>
	<table>
		<tr><th>Date</th><th>Page Views</th><th>Edits</th><th>Photos</th><th>Likes</th></tr>
		<?php foreach ($stats as $date => $row) {
			echo "<tr><td>$date</td>";
			foreach ($row as $stat) {
				echo "<td>$stat</td>";
			}
			echo "</tr>";
		} ?>
	</table>
</section>