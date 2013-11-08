<?php

$app = F::app();
$dir = dirname(__FILE__) . '/';

# load 
$wgAutoloadClasses[ 'Wikia\\SolrHelper\\SolrHelper'] = $dir . "classes/SolrHelper.class.php";


