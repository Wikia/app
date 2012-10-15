==General==
You can use the WindowsAzureSDK extension for MediaWiki to register the SDK with
your environment. All classes from the "PHPAzure - Windows Azure SDK for 
PHP" by REALDOLMEN are bundled with this extension.

You can find the orginal sources at http://phpazure.codeplex.com/

==Installation==
Copy the WindowsAzureSDK extension to your <mediawiki>/extensions directory
and add the following line to your LocalSettings.php:

include_once( "$IP/../extensions/WindowsAzureSDK/WindowsAzureSDK.php" );