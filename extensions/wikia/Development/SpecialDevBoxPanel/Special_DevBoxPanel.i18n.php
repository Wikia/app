<?php

$messages = Array();
$messages["en"] = Array(
	"devbox-title"                => "Dev-Box Panel",
	"devbox-panel-not-enabled"    => "The Dev Box Panel is currently <strong>disabled</strong>. It is only available on development environments.<br/><br/>".
	                                 "To enable this panel please add this line to LocalSettings.php:<br/><strong><code>\$wgDevelEnvironment = true;</code></strong>",
	"devbox-intro"                => "This panel is designed to help manage your dev-box (ie: on Wikia servers, <strong>not intended for local installations</strong>). Since this SpecialPage is only designed for dev-boxes, it is recommended NOT to use this on other types of servers.",
	
	"devbox-vital-settings"       => "Vital Settings",
	"devbox-setting-name"         => "Setting Name",
	"devbox-setting-value"        => "Current Value",

	"devbox-dbs-on-devbox"        => "Databases On Dev Box",
	"devbox-dbs-in-production"    => "Available From Production Slaves",

	"devbox-section-all"          => "All databases alphabetically (including those from Summary)",
	"devbox-section-existing"     => "Existing Databases",
	"devbox-section-summary"      => "Summary",

	"devbox-recommended"          => "(recommended)",
	"devbox-get-db"               => "Get it",
	"devbox-reload-db"            => "Reload it",
);

?>
