<?php
/*
 * Author: Inez Korczynski (inez@wikia.com)
 */
chdir(dirname(__FILE__).'/../../');
define('MEDIAWIKI', 'true');
require_once('extensions/wikia/MergeFiles/MergeFilesMinimal.php');
require_once('extensions/wikia/MergeFiles/MergeFilesAdditional.php');

$HeadURL = split('/', '$HeadURL$');
$wgReleaseNumber = $HeadURL[5];
$targetPrefix = "/images/common/releases_{$wgReleaseNumber}/skins/";
$java = "/usr/bin/java";
$yuic = "/images/common/yuic.jar";
$headerComment = "/* To download this javascript non-compressed, add allinone=0 to the end of the url. */\n/* Example: http://www.wikia.com/wiki/About_Wikia?allinone=0 */\n\n";

foreach($MF as $group) {
	echo "Target: {$group['target']}\n";
	$out = '';
	foreach($group['source'] as $file) {
		$temp = file_get_contents(dirname(__FILE__).'/../../skins/'.$wgStyleDirectory.'/'.$file) . "\n\n";
		if($file == "common/yui/2.4.0/container/assets/container.css") {
			$temp = str_replace("url(close12", "url(../../common/yui_2.5.2/container/assets/close12", $temp);
			$temp = str_replace("url(\"",  "url(\"../../common/yui_2.5.2/container/assets/", $temp);
		}
		$out .= $temp;
		echo "...processing: {$file}\n";
	}
	file_put_contents($targetPrefix.$group['target'], $out);
	if($group['type'] == 'js') {
		$command = sprintf("%s -jar %s --type js -o %s --nomunge %s", $java, $yuic, $targetPrefix.$group['target'], $targetPrefix.$group['target']);
		echo shell_exec($command);
	}
	if($group['type'] == 'css') {
		$command = sprintf("%s -jar %s --type css -o %s --nomunge %s", $java, $yuic, $targetPrefix.$group['target'], $targetPrefix.$group['target']);
		echo shell_exec($command);
	}
	$target = $targetPrefix.$group['target'];
	$content = $headerComment.file_get_contents($targetPrefix.$group['target']);

	if($group['type'] == 'css') {
		$content = str_replace('(close12_1.gif)', '(../../common/yui_2.5.2/container/assets/close12_1.gif)', $content);
	}

	file_put_contents($target, $content);
	echo "...done!\n\n";
}
