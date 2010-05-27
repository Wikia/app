<?php

$messages = Array();
$messages["en"] = Array(
	"devbox-title"                => "Dev-Box Panel",
	"devbox-panel-not-enabled"    => "The Dev Box Panel is currently <strong>disabled</strong>. It is only available on development environments.<br/><br/>".
	                                 "To enable this panel please add this line to LocalSettings.php:<br/><strong><code>\$wgDevelEnvironment = true;</code></strong>",
	"devbox-intro"                => "This panel is designed to help manage your dev-box (ie: on Wikia servers, <strong>not intended for local installations</strong>). Since this SpecialPage is only designed for dev-boxes, it is recommended NOT to use this on other types of servers.",
	
	"devbox-heading-vital"        => "Vital Settings",
	"devbox-setting-name"         => "Setting Name",
	"devbox-setting-value"        => "Current Value",

	"devbox-heading-pull-dbs"     => "Pull Databases From Prod",
	"devbox-dbs-on-devbox"        => "Databases On Dev Box",
	"devbox-dbs-in-production"    => "Available From Production Slaves",

	"devbox-pull-by-domain"       => "Pull any wiki's database by wiki domain: ",

	//"devbox-section-all"          => "All databases alphabetically (including those from Summary)", // TODO: REMOVE IF WE DECIDE TO CHUCK THIS SECTION
	"devbox-section-existing"     => "Existing Databases",
	"devbox-section-recommended"  => "Commonly Used",
	"devbox-no-dbs-in-list"       => "(None found)",

	"devbox-recommended"          => "(recommended)",
	"devbox-get-db"               => "Get it",
	"devbox-reload-db"            => "Re-pull it",
	
	"devbox-no-local-copy"        => "<h1>Error</h1>There is no local copy of the $1 database.  This is a devbox server so please <a href='$2'>pull a copy</a> from production to the development database and you'll be ready to go.",

	"devbox-heading-change-wiki"  => "Change Active Wiki",
	"devbox-change-wiki-intro"    => "Allows you to set the active wiki instead of modifying hosts files.  To use the hosts-file method, leave this field blank.",
	"devbox-change-wiki-label"    => "Wiki to use (eg: \"lyrics.wikia.com\"): ",
	"devbox-change-wiki-submit"   => "Update",
	"devbox-change-wiki-success"  => "This MediaWiki will now run as <strong><code>\$1</code></strong><br/><em>Note: this change won't be apparent until the next page-load.</em>",
	"devbox-default-wiki"         => "whatever wiki is in the url",
	"devbox-change-wiki-fileerror"=> "There was an error writing to \"<em>\$1</em>\".  Make sure you have appropriate write-permissions.",


	"devbox-footer"               => "<br/><br/><small>Want to change something?<br/>The code for this extension is located in <code>\$1</code></small>",
);

?>
