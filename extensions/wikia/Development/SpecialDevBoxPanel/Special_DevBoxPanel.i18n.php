<?php

$messages = Array();
$messages["en"] = Array(
	"devbox-title"                => "Dev-Box Panel",
	"devbox-panel-not-enabled"    => "The Dev Box Panel is currently <strong>disabled</strong>. It is only available on development environments.<br/><br/>".
	                                 "To enable this panel please add this line to LocalSettings.php:<br/><strong><code>\$wgDevelEnvironment = true;</code></strong>",
	"devbox-intro"                => "This panel is designed to help manage your dev-box (ie: on Wikia servers, <strong>not intended for local installations</strong>).<br/> Since this SpecialPage is only designed for dev-boxes, it is recommended NOT to use this on other types of servers. <br/>",
	
	"devbox-heading-vital"        => "Vital Settings",
	"devbox-setting-name"         => "Setting Name",
	"devbox-setting-value"        => "Current Value",

	"devbox-section-existing"     => "Databases on $1",
	
	"devbox-no-local-copy"        => "<h1>Error</h1>There is no local copy of the $1 database.",
	"devbox-heading-change-wiki"  => "Change Active Wiki",
	"devbox-change-wiki-intro"    => "Allows you to set the active wiki instead of modifying hosts files. <br/> To switch to a new wiki use the URL wikiname.$1 or click on the links below.",
	"devbox-change-wiki-success"  => "This MediaWiki will now run as <strong><code>\$1</code></strong><br/>",

	"devbox-heading-svn-tool"     => "Code Mangement",

	"devbox-footer"               => "Want to change something?<br/>The code for this extension is located in <code>\$1</code>",
);

?>
