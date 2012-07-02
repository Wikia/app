<?php
/**
 * FogBugzDiagrams - setup file
 * @author Paweł Rychły
 * @author Piotr Pawłowski ( Pepe )
 */

$app = F::app();
$dir = dirname( __FILE__ ) . '/';

$app->registerClass( 'FogBugzDiagramsSpecialController', $dir . 'FogBugzDiagramsSpecialController.class.php' );
$app->registerClass( 'FogBugzReport', $dir . 'FogBugzReport.class.php' );
$app->registerSpecialPage( 'FogBugzDiagrams', 'FogBugzDiagramsSpecialController'  );
$app->registerExtensionMessageFile( 'FogBugzDiagrams', $dir . 'FogBugzDiagrams.i18n.php' );
