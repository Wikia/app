<?php
/**
 * Setup for WikiaCollections
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Damian Jóźwiak
 * @author Łukasz Konieczny
 * @author Sebastian Marzjan
 */
$app = F::app();
$dir = dirname(__FILE__) . '/';

/**
 * models
 */
$app->registerClass('WikiaCollectionsModel', $dir . '/models/WikiaCollectionsModel.class.php');