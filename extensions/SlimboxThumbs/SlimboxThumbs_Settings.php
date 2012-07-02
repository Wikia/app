<?php

/**
 * Settings file for the SlimboxThumbs extension.
 * For more info see http://www.mediawiki.org/wiki/Extension:SlimboxThumbs
 *
 *                          NOTICE:
 * Changing one of these settings can be done by copieng or cutting it,
 * and placing it in LocalSettings.php, AFTER the inclusion of SlimboxThumbs.
 *
 * @file SlimboxThumbs_Settings.php
 *
 * @author Jeroen De Dauw
 */

# Path of the Slimbox directory (string).
$useExtensionPath = version_compare( $wgVersion, '1.16', '>=' ) && isset( $wgExtensionAssetsPath ) && $wgExtensionAssetsPath;
$slimboxThumbsFilesDir = ( $useExtensionPath ? $wgExtensionAssetsPath : $wgScriptPath . '/extensions' ) . '/SlimboxThumbs';
unset( $useExtensionPath );

$slimboxThumbsFilesDir .= '/slimbox';
