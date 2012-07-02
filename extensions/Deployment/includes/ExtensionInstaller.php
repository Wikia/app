<?php

/**
 * File holding the ExtensionInstaller class.
 * Based on the WordPress 3.0 class WP_Upgrader.
 *
 * @file ExtensionInstaller.php
 * @ingroup Deployment
 * @ingroup Installer
 *
 * @author Jeroen De Dauw
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

/**
 * Class for Installing or upgrading MediaWiki extensions via the Filesystem Abstraction classes from a Zip file.
 * 
 * @author Jeroen De Dauw
 */
class ExtensionInstaller extends Installer {
	
	/**
	 * Constructor.
	 */
	public function __construct() {
		parent::__construct();
		
		// TODO
	}	
	
	/**
	 * Initiates the installation procedure.
	 */
	public function doInstallation() {
		$this->downloadPackage();
		
		// TODO: only call when needed
		$this->unpackPackage();
		
		$this->installPackage();
	}
	
	/**
	 * Downloads a package needed for the installation.
	 */
	protected function downloadPackage() {
		// TODO: create a PackageRepository instance and download
	}
	
	/**
	 * Unpacks a package needed for the installation.
	 */
	protected function unpackPackage() {
		// TODO
	}
	
	/**
	 * Installs a package.
	 */
	protected function installPackage() {
		$packageParser = new PackageDescriptorParser();
		
		// TODO: do parsing
		$packageDescriptor = new PackageDescriptor();
		
		$packageProcessor = new PackageDescriptorProcessor( $packageDescriptor );
	}

	/**
	 * @param string $msg
	 */
	public function showMessage( $msg ) {
		
	}
	
}