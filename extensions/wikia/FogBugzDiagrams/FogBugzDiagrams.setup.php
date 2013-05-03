<?php
/**
 * FogBugzDiagrams - setup file
 * @author Paweł Rychły
 * @author Piotr Pawłowski ( Pepe )
 */

$app = F::app();
$dir = dirname( __FILE__ ) . '/';

$wgAutoloadClasses[ 'FogBugzDiagramsSpecialController'] =  $dir . 'FogBugzDiagramsSpecialController.class.php' ;
$wgAutoloadClasses[ 'FogBugzReport'] =  $dir . 'FogBugzReport.class.php' ;
$wgSpecialPages[ 'FogBugzDiagrams'  ] =  'FogBugzDiagramsSpecialController';
$app->registerExtensionMessageFile( 'FogBugzDiagrams', $dir . 'FogBugzDiagrams.i18n.php' );
