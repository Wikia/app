<?php

	// Register all the AddMedia resources 
	return array(
		'AddMedia' => array(
			'styles' => "resources/css/addMedia.css",
			'messageFile' => 'AddMedia.i18n.php',
			'dependencies' => array(
				'mw.RemoteSearchDriver',
				'mediawiki.Uri',
				'mw.Api'
			),
		),
		'mw.RemoteSearchDriver' => array(
			'scripts' => 'resources/mw.RemoteSearchDriver.js'
		),
		
		'baseRemoteSearch' => array(
			'scripts' => 'resources/searchLibs/baseRemoteSearch.js'
		),
		
		'archiveOrgSearch' => array(
			'scripts' => 'resources/searchLibs/archiveOrgSearch.js',
			'dependencies' => array( 'baseRemoteSearch' )
		),
		'flickrSearch' => array(
			'scripts' => 'resources/searchLibs/flickrSearch.js',
			'dependencies' => array( 'baseRemoteSearch' )
		),
		'kalturaSearch' => array(
			'scripts' => 'resources/searchLibs/kalturaSearch.js',
			'dependencies' => array( 'baseRemoteSearch' )
		),
		'mediaWikiSearch' => array(
			'scripts' => 'resources/searchLibs/mediaWikiSearch.js',
			'dependencies' => array( 'baseRemoteSearch' )
		),
		'metavidSearch' => array(
			'scripts' => 'resources/searchLibs/mediaWikiSearch.js',
			'dependencies' => array( 'baseRemoteSearch' )
		),
	);