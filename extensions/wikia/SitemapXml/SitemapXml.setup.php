<?php

$wgAutoloadClasses['SitemapXmlModel'] = __DIR__ . '/SitemapXmlModel.class.php';
$wgAutoloadClasses['SpecialSitemapXmlController'] = __DIR__ . '/SpecialSitemapXmlController.class.php';

$wgSpecialPages['SitemapXml'] = 'SpecialSitemapXmlController';
