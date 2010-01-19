<?php

// Set up the new special page
$wgAutoloadClasses['FundJS'] = dirname( __FILE__ ) . '/SpecialFundJS.body.php';
$wgSpecialPages['FundJS'] = 'FundJS';
