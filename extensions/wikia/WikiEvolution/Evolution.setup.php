<?php


/**
 * @var WikiaApp
 */
$app = F::app();
$dir = dirname(__FILE__) . '/';


/**
 * classes
 */
$app->registerClass('EvolutionAbstractLogRenderer', $dir . 'EvolutionAbstractLogRenderer.class.php');
$app->registerClass('EvolutionGourceLogRenderer', $dir . 'EvolutionGourceLogRenderer.class.php');
$app->registerClass('EvolutionLogstalgiaLogRenderer', $dir . 'EvolutionLogstalgiaLogRenderer.class.php');
$app->registerClass('EvolutionModel', $dir . 'EvolutionModel.class.php');

