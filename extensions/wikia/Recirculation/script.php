<?php
	exec('node parseRecommendations.js');
	$file = json_decode(file_get_contents('./recommendations.json', true),true);
	file_put_contents('rec.txt', var_export( $file, true ));
	$script = 'sed -i "s/array (/[/g" rec.txt && sed -i "s/)/]/g" rec.txt && sed -i "s/[0-9][0-9]* => //g" rec.txt && sed -i "/^\s*$/d" rec.txt';
	shell_exec($script);
