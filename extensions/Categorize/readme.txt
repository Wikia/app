// include these lines in LocalSettings.php :

$wgCategorizeLabels = array(
	'categorize1' => array('Label1','Label2','Label3'),
	'categorize2' => array('Label4','Label5','Label6'),
	'separator1' => array(),
	'categorize3' => array('Label7','Label8','Label9')
);

require_once("$IP/extensions/Categorize/Categorize.php");
