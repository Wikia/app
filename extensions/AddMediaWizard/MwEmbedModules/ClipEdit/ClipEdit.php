<?php 
	return array(
		'mw.ClipEdit' => array(
			'scripts' => 'resources/mw.ClipEdit.js',
			'dependencies'=> array(
				'jquery.Jcrop'
			),
			'styles'=> 'resources/css/clipEdit.css',
			'messageFile' => 'ClipEdit.i18n.php',
		),
		'jquery.Jcrop' => array(
			'scripts' => 'resources/jquery.jcrop/js/jquery.Jcrop.js',
			'styles' => 'resources/jquery.jcrop/css/jquery.Jcrop.css',
		)
	);