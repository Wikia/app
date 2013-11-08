<?php

$app = F::app();
$dir = dirname(__FILE__) . '/';

# load 
$wgAutoloadClasses[ 'Wikia\\SolrHelper\\Query'         ] = $dir . "classes/Query.class.php";


