<?php


/**
 * @var WikiaApp
 */
$app = F::app();
$dir = dirname(__FILE__) . '/';


/**
 * classes
 */
$wgAutoloadClasses['EvolutionAbstractLogRenderer'] =  $dir . 'EvolutionAbstractLogRenderer.class.php';
$wgAutoloadClasses['EvolutionGourceLogRenderer'] =  $dir . 'EvolutionGourceLogRenderer.class.php';
$wgAutoloadClasses['EvolutionLogstalgiaLogRenderer'] =  $dir . 'EvolutionLogstalgiaLogRenderer.class.php';
$wgAutoloadClasses['EvolutionModel'] =  $dir . 'EvolutionModel.class.php';

