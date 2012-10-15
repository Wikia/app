<?php

/**
 * File defining the settings for the Spark extension.
 * More info can be found at http://www.mediawiki.org/wiki/Extension:Spark#Settings
 *
 *                          NOTICE:
 * Changing one of these settings can be done by copying or cutting it,
 * and placing it in LocalSettings.php, AFTER the inclusion of this extension.
 *
 * @file Spark.settings.php
 * @ingroup Spark
 *
 * @licence GNU GPL v3+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

/// Parameters /////
define("egSparkQuery", "data-spark-query");
define("egSparkFormat", "data-spark-format");

/**
 * Example configuration modules

 $wgResourceModules['ext.spark.oatpivot'] = array(
 'localBasePath' => "$IP/extensions/Spark/",
 'remoteBasePath' => $egSparkScriptPath,
 'styles' => array('rdf-spark/lib/oat/styles/pivot.css'),
 'scripts' => array( 'rdf-spark/lib/oat/loader.js', 'rdf-spark/lib/oat/bootstrap.js', 'rdf-spark/lib/oat/animation.js', 'rdf-spark/lib/oat/barchart.js', 'rdf-spark/lib/oat/ghostdrag.js', 'rdf-spark/lib/oat/instant.js', 'rdf-spark/lib/oat/pivot.js', 'rdf-spark/lib/oat/statistics.js' ),
 'dependencies' => array(),
 'messages' => array()
 );

 $wgResourceModules['ext.spark.datechart'] = array(
 'localBasePath' => "$IP/extensions/Spark/",
 'remoteBasePath' => $egSparkScriptPath,
 'styles' => array(),
 'scripts' => array( 'rdf-spark/lib/jquery.jqplot.js', 'rdf-spark/lib/jqplot.dateAxisRenderer.js', 'rdf-spark/lib/jqplot.categoryAxisRenderer.js' ),
 'dependencies' => array(),
 'messages' => array()
 );

 $wgResourceModules['ext.spark.piechart'] = array(
 'localBasePath' => "$IP/extensions/Spark/",
 'remoteBasePath' => $egSparkScriptPath,
 'styles' => array(),
 'scripts' => array( 'rdf-spark/lib/jquery.jqplot.js', 'rdf-spark/lib/jqplot.pieRenderer.js', 'rdf-spark/lib/jqplot.dateAxisRenderer.js', 'rdf-spark/lib/jqplot.categoryAxisRenderer.js' ),
 'dependencies' => array(),
 'messages' => array()
 );
 */
