<?php

/**
 * ScavengerHunt
 *
 * A ScavengerHunt extension for MediaWiki
 * Alows to create a scavenger hunt game on a wiki
 *
 * @author Jakub Kurcek <jakub at wikia-inc.com>
 * @date 2012-05-26
 * @copyright Copyright (C) 2010 Jakub Kurcek, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     include("$IP/extensions/wikia/ScavengerHunt/ScavengerHunt_setup.php");
 */

class ScavengerHuntFormController extends WikiaController {

	public function index() {

	}

	public function getSpriteElement() {

		$aParams = $this->getRequest()->getParams();
		$this->setVal( 'sprites', isset( $aParams['sprites']) ? $aParams['sprites'] : array() );
		$this->setVal( 'article', isset( $aParams['article']) ? $aParams['article'] : array() );
		$this->setVal( 'sufix', isset( $aParams['sufix'] ) ? $aParams['sufix'] : '' );
		$this->setVal( 'number', isset( $aParams['number'] ) ? $aParams['number'] : '' );
		$this->setVal( 'highlight', isset( $aParams['highlight'] ) ? $aParams['highlight'] : array() );
	}
}