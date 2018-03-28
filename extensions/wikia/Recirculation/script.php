<?php
	exec('node parseRecommendations.js "X.xlsx"');
	$file = json_decode(file_get_contents('./recommendations.json', true),true);
	file_put_contents('recommendations.txt', var_export( $file, true ));

	$script = 'sed -i "s/array (/[/g" recommendations.txt && sed -i "s/)/]/g" recommendations.txt && sed -i "s/[0-9][0-9]* => //g" recommendations.txt && sed -i "/^\s*$/d" recommendations.txt';
	shell_exec($script);
	shell_exec("rm recommendations.json");
