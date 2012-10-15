<?php
require_once( 'POM.php' );

# Get document from MediaWiki server
$pom = new POMPage( join( file( 'http://www.mediawiki.org/w/index.php?title=Extension:Page_Object_Model&action=raw' ) ) );

# Check current version
$ver = $pom->templates['Extension'][0]->getParameter( 'version' );
echo "Current version: $ver\n";

# Increase version number by fraction
$pom->templates['Extension'][0]->setParameter( 'version', $ver + 0.1 );

# Do whatever you want with result (we'll just display it)
echo "Document with increased version:\n" . $pom->asString();
