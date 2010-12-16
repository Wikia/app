<?php

/*
 * Created on Sep 19, 2009
 *
 * API module for MediaWiki's FlaggedRevs extension
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 * http://www.gnu.org/copyleft/gpl.html
 */

/**
 * API module to stabilize pages
 *
 * @ingroup FlaggedRevs
 */
class ApiStabilize extends ApiBase {
	public function execute() {
		global $wgUser, $wgContLang;
		$params = $this->extractRequestParams();

		if( !isset($params['title']) )
			$this->dieUsageMsg( array('missingparam', 'title') );
		if( !isset($params['token']) )
			$this->dieUsageMsg( array('missingparam', 'token') );

		$title = Title::newFromText( $params['title'] );
		if( $title == null ) {
			$this->dieUsage( "Invalid title given.", "invalidtitle" );
		}
		if( !FlaggedRevs::inReviewNamespace($title) ) {
			$this->dieUsage( "Title given does not correspond to a reviewable page.", "invalidtitle" );
		}
		$errors = $title->getUserPermissionsErrors('stablesettings', $wgUser);
		if( $errors ) {
			// We don't care about multiple errors, just report one of them
			$this->dieUsageMsg(reset($errors));
		}
		
		$article = new Article( $title );
		if( !$article->exists() ) {
			$this->dieUsage( "Target page does not exist.", "invalidtitle" );
		}

		$form = new Stabilization();
		$form->target = $title; # Our target page
		$form->watchThis = $params['watch']; # Watch this page
		$form->reviewThis = $params['review']; # Auto-review option
		$form->reason = $params['reason']; # Reason
		$form->reasonSelection = 'other'; # Reason dropdown
		$form->expiry = $params['expiry']; # Expiry
		$form->expirySelection = 'other'; # Expiry dropdown
		
		$levels = FlaggedRevs::getProtectionLevels();
		// Check if protection levels are enabled
		if( !empty($levels) ) {
			# Fill in config from the protection level...
			$selected = $params['protectlevel'];
			if( $selected == "none" ) {
				$form->select = FlaggedRevs::getPrecedence(); // default
				$form->override = (int)FlaggedRevs::isStableShownByDefault(); // default
				$form->autoreview = ''; // default
			} else if( isset($levels[$selected]) ) {
				$form->select = $levels[$selected]['select'];
				$form->override = $levels[$selected]['override'];
				$form->autoreview = $levels[$selected]['autoreview'];
			} else {
				$this->dieUsage( "Invalid protection level given.", 'badprotectlevel' );
			}
		} else {
			// Fill in config fields from URL params
			$form->select = $this->precendenceFromKey( $params['precedence'] );
			if( $params['default'] === null ) {
				$this->dieUsageMsg( array('missingparam', 'default') );
			} else {
				$form->override = $this->defaultFromKey( $params['default'] );
			}
			if( $params['autoreview'] != 'none' ) {
				$form->autoreview = $params['autoreview'];
			} else {
				$form->autoreview = ''; // 'none' -> ''
			}
		}
		$form->wasPosted = true; // already validated
		if( $form->handleParams() ) {
			$status = $form->submit(); // true/error message key
			if( $status !== true ) {
				$this->dieUsage( wfMsg($status) );
			}
		} else {
			$this->dieUsage( "Invalid config parameters given. The precendence level may beyond your rights.", 'invalidconfig' );
		}
		# Output success line with the title and config parameters
		$res = array();
		$res['title'] = $title->getPrefixedText();
		if( FlaggedRevs::getProtectionLevels() ) {
			$res['protectlevel'] = $params['protectlevel'];
		} else {
			$res['default'] = $params['default'];
			$res['precedence'] = $params['precedence'];
			$res['autoreview'] = $params['autoreview'];
		}
		$res['expiry'] = $form->expiry;
		$this->getResult()->addValue(null, $this->getModuleName(), $res);
	}
	
	protected function defaultFromKey( $key ) {
		if( $key == 'stable' ) {
			return 1;
		} else if( $key == 'latest' ) {
			return 0;
		}
		// bad key?
		return null;
	}
	
	protected function precendenceFromKey( $key ) {
		if( $key == 'pristine' ) {
			return FLAGGED_VIS_PRISTINE;
		} else if( $key == 'quality' ) {
			return FLAGGED_VIS_QUALITY;
		} else if( $key == 'latest' ) {
			return FLAGGED_VIS_LATEST;
		}
		// bad key?
		return null;
	}
	
	protected function keyFromPrecendence( $precedence ) {
		if( $precedence == FLAGGED_VIS_PRISTINE ) {
			return 'pristine';
		} else if( $precedence == FLAGGED_VIS_QUALITY ) {
			return 'quality';
		} else if( $precedence == FLAGGED_VIS_LATEST ) {
			return 'lastest';
		}
		// bad key?
		return null;
	}

	public function mustBePosted() {
		return true;
	}
	
	public function isWriteMode() { 
 		return true;
 	}

	public function getAllowedParams() {
		if( FlaggedRevs::useProtectionLevels() ) {
			$validLevels = array_keys( FlaggedRevs::getProtectionLevels() );
			$validLevels[] = 'none';
			$pars = array(
				'protectlevel' => array(
					ApiBase :: PARAM_TYPE => $validLevels,
					ApiBase :: PARAM_DFLT => 'none',
				)
			);
		} else {
			// Replace '' with more readable 'none' in autoreview restiction levels
			$autoreviewLevels = array_filter( FlaggedRevs::getRestrictionLevels() );
			$autoreviewLevels[] = 'none';
			$pars = array(
				'default'     => array(
					ApiBase :: PARAM_TYPE => array( 'latest', 'stable' ),
					ApiBase :: PARAM_DFLT => null,
				),
				'precedence'  => array(
					ApiBase :: PARAM_TYPE => array( 'pristine', 'quality', 'latest' ),
					ApiBase :: PARAM_DFLT => $this->keyFromPrecendence( FlaggedRevs::getPrecedence() )
				),
				'autoreview' => array(
					ApiBase :: PARAM_TYPE => $autoreviewLevels,
					ApiBase :: PARAM_DFLT => 'none',
				),
			);
		}
		$pars += array(
			'expiry' => 'infinite',
			'reason' => '',
			'review' => false,
			'watch'  => null,
			'token'  => null,
			'title'  => null,
		);
		return $pars;
	}

	public function getParamDescription() {
		if( FlaggedRevs::useProtectionLevels() ) {
			$desc = array(
				'protectlevel' => 'The review protection level',
			);
		} else {
			$desc = array(
				'default' 		=> 'Default revision to show',
				'precedence'	=> 'What stable revision should be shown',
				'autoreview' 	=> 'Auto-review restriction',
			);
		}
		$desc += array(
			'expiry' 		=> 'Stabilization expiry',
			'title' 		=> 'Title of page to be stabilized',
			'reason' 		=> 'Reason',
			'review'        => 'Review this page',
			'watch'         => 'Watch this page',
			'token' 		=> 'An edit token retrieved through prop=info',
		);
		return $desc;
	}

	public function getDescription() {
		return 'Change page stabilization settings.';
	}
	
	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
			array('missingparam', 'title'),
			array('missingparam', 'token'),
			array('missingparam', 'default'),
			array( 'code' => 'invalidtitle', 'info' => 'Invalid title given.' ),
			array( 'code' => 'invalidtitle', 'info' => 'Target page does not exist.' ),
			array( 'code' => 'invalidtitle', 'info' => 'Title given does not correspond to a reviewable page.' ),
			array( 'code' => 'badprotectlevel', 'info' => 'Invalid protection level given.' ),
			array( 'code' => 'invalidconfig', 'info' => 'Invalid config parameters given. The precendence level may beyond your rights.' ),
		) );
	}
	
	public function getTokenSalt() {
		return '';
	}

	protected function getExamples() {
		if( FlaggedRevs::useProtectionLevels() )
			return 'api.php?action=stabilize&title=Test&protectlevel=none&reason=Test&token=123ABC';
		else
			return 'api.php?action=stabilize&title=Test&default=stable&reason=Test&token=123ABC';
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiStabilize.php 62624 2010-02-17 00:05:38Z reedy $';
	}
}
