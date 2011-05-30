<?php
/**
 * Script to generate YAML configuration for StatusNet plugins.
 * @see StatusNet-plugins.yaml
 *
 * @todo Use Maitenance class and add target option for writing output file.
 * @file
 * @author Siebrand Mazeland
 * @copyright Copyright © 2010 Siebrand Mazeland
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

// Array of found plugins.
$plugins = array();

/**
 * Helper method to traverse a path and find plugins.
 *
 * @param $path string Starting path on file system.
 * @param $pattern string Regular expression for files to find in $path.
 * @return array Array of plugins found.
 */
function getPotFiles( $path, $pattern ) {
	global $plugins;

	$path = rtrim( str_replace( "\\", "/", $path ), '/' ) . '/';
	$entries = array();
	$dir = dir( $path );
	while ( false !== ( $entry = $dir->read() ) ) {
		$entries[] = $entry;
	}
	$dir->close();
	foreach ( $entries as $entry ) {
		$fullname = $path . $entry;
		if ( $entry != '.' && $entry != '..' && is_dir( $fullname ) ) {
			$subFolderResults = getPotFiles( $fullname, $pattern );
		} else if ( is_file( $fullname ) && preg_match( $pattern, $entry ) ) {
			$pathParts = explode( '/', $fullname );
			$plugins[] = substr( array_pop( $pathParts ), 0, -4 );
		}
	}
}

// translatewiki.net specific base folder.
$baseFolder = '/home/betawiki/projects/statusnet/plugins/';
// File pattern for gettext template files.
$filePattern = '/[.]pot$/';

getPotFiles( $baseFolder, $filePattern );

// Template header for YAML config file.
$header = <<<PHP
TEMPLATE:
  BASIC:
    description: "{{int:translate-group-desc-statusnet-plugin}}"
    namespace: NS_STATUSNET
    display: out/statusnet/
    class: FileBasedMessageGroup

  FILES:
    class: GettextFFS
    codeMap:
      en-gb:   en_GB
      en-us:   en_US
      no:      nb
      pt-br:   pt_BR
      zh-hans: zh_CN
      zh-hant: zh_TW

    header: |
      # This file is distributed under the same license as the StatusNet package.
      #

  MANGLER:
    class: StringMatcher
    patterns:
      - "*"

  CHECKER:
    class: MessageChecker
    checks:
      - printfCheck
---
PHP;

echo $header . "\n";

$basePluginFolder = "statusnet/plugins/";
$localeFolder = "/locale/%CODE%/LC_MESSAGES/";

asort( $plugins );
$numberPlugins = count( $plugins );
$count = 0;

// Add config for each plugin.
foreach ( $plugins as $plugin ) {
	$pluginL = strtolower( $plugin );

	echo "BASIC:\n";
	echo "  id: out-statusnet-plugin-" . $pluginL . "\n";
	echo "  label: StatusNet - " . $plugin . "\n";
	echo "  display: out/statusnet/plugin/" . $pluginL . "\n";
	echo "  codeBrowser: http://gitorious.org/statusnet/mainline/blobs/1.0.x/plugins/" . $plugin . "/%FILE%#line%LINE%\n\n";
	echo "FILES:\n";
	echo "  sourcePattern: %GROUPROOT%/" . $basePluginFolder . $plugin . $localeFolder . $plugin . ".po\n";
	echo "  definitionFile: %GROUPROOT%/" . $basePluginFolder . $plugin . "/locale/" . $plugin . ".pot\n";
	echo "  targetPattern: " . $basePluginFolder . $plugin . $localeFolder . $plugin . ".po\n\n";
	echo "MANGLER:\n";
	echo "  prefix: " . $pluginL . "-\n";

	$count++;

	if ( $count < $numberPlugins ) {
		echo "---\n";
	}
}
