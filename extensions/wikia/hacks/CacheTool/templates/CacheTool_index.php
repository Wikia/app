<button id="CacheToolGatherButton"> Gather Data </button>  <button id="CacheToolStopButton"> Stop Gathering </button> <button id="CacheToolClearButton"> Clear Stats </button>
<?php 
	if ($redisError) {
		echo "Error connecting to redis";
	}
	else { ?>
	<table>
		<th> Wiki </th> <th> Keys </th> <th> Details </th>
	<?php
		foreach ($keys as $k => $c ) {
			echo "<tr><td> $k </td> <td> $c </td> <td> <a href=\"?details=$k\"> Get Details </td></tr>";
		}
	} ?>
</table>