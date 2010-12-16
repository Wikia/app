<?php
/*
 * Updates the cache of Project Honeypot IPs
 */

require_once ( getenv('MW_INSTALL_PATH') !== false
	? getenv('MW_INSTALL_PATH')."/maintenance/commandLine.inc"
	: dirname( __FILE__ ) . '/../../maintenance/commandLine.inc' );

HoneypotIntegration::loadHoneypotData();
HoneypotIntegration::loadHoneypotURLs();
