==Prerequisites==
You will need to have all classes from the "PHPAzure - Windows Azure SDK for 
PHP" by REALDOLMEN available.

Download it at http://phpazure.codeplex.com/

You can use the WindowsAzureSDK extension for MediaWiki to register the SDK with
your environment.


==Installation==
Copy the WindowsAzureStorage extension to your <mediawiki>/extensions directory
and add the following line to your LocalSettings.php:

include_once( "$IP/../extensions/WindowsAzureStorage/WindowsAzureStorage.php" );


==Configuration==
Add an entry for the Azure File Backend to the $wgFileBackends array in your 
LocalSettings.php. Also configure your repo (i.e. the LocalFileRepo) to use the 
Azure File Backend.

The following configuration is suitable for a development environment running 
Microsoft Windows Azure Service Emulators from the Azure SDK.

$wgFileBackends[] = array(
		'name'        => 'azure-backend',
		'class'       => 'WindowsAzureFileBackend',
		'lockManager' => 'nullLockManager',
		'azureHost'      => 'http://127.0.0.1:10000',
		'azureAccount'   => 'devstoreaccount1',
		'azureKey'       => 'Eby8vdM02xNOcqFlqUwJPLlmEtlCDXJ1OUzFT50uSRZ6IFsuFq2UVErCz4I6tq/K1SZFPTOtr/KBHBeksoGMGw==',

		//IMPORTANT: Mind the container naming conventions! http://msdn.microsoft.com/en-us/library/dd135715.aspx
		'containerPaths' => array(
				'media-public'  => 'media-public',
				'media-thumb'   => 'media-thumb',
				'media-deleted' => 'media-deleted',
				'media-temp'    => 'media-temp',

		)
);

$wgLocalFileRepo = array (
	'class'             => 'LocalRepo',
	'name'              => 'local',
	'scriptDirUrl'      => '/php/mediawiki-filebackend-azure',
	'scriptExtension'   => '.php',
	'url'               => $wgScriptPath.'/img_auth.php', // It is important to set this to img_auth. Basically, there is no alternative.
	'hashLevels'        => 2,
	'thumbScriptUrl'    => false,
	'transformVia404'   => false,
	'deletedHashLevels' => 3,
	'backend'           => 'azure-backend',
	'zones' => 
			array (
					'public' => 
							array (
								'container' => 'local-public',
								'directory' => '',
							),
					'thumb' => 
							array(
								'container' => 'local-public',
								'directory' => 'thumb',
							),
					'deleted' => 
							array (
								'container' => 'local-public',
								'directory' => 'deleted',
							),
					'temp' => 
							array(
								'container' => 'local-public',
								'directory' => 'temp',
							)
		)
);

$wgImgAuthPublicTest = false;