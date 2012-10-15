<?php 

	// Register all the timedText modules 
	return array(			
		"mw.TimedText" => array(
			'scripts' => array(
				"resources/mw.TimedText.js",
				"resources/mw.TextSource.js",
			),
			'styles' => "resources/mw.style.TimedText.css",
			'dependencies' => array(
				'mw.EmbedPlayer',
				'mw.Api',
				'mw.Language.names',
				'jquery.ui.dialog',	
			),
			'messageFile' => 'TimedText.i18n.php',
		)
	);	