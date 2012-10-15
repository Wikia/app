<?php
require_once( dirname(__FILE__).'/WikimediaCommandLine.inc' );

foreach ($wgLocalDatabases as $db) {
print "$db\n";
}
