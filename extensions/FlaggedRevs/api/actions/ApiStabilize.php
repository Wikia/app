<?php
/**
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
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 */

/**
 * API module to stabilize pages
 *
 * @ingroup FlaggedRevs
 */
abstract class ApiStabilize extends ApiBase {
	// Title param
	protected $title;

	public function execute() {
		global $wgUser;
		$params = $this->extractRequestParams();

		if ( !isset( $params['title'] ) ) {
			$this->dieUsageMsg( array( 'missingparam', 'title' ) );
		} elseif ( !isset( $params['token'] ) ) {
			$this->dieUsageMsg( array( 'missingparam', 'token' ) );
		}

		$this->title = Title::newFromText( $params['title'] );
		if ( $this->title == null ) {
			$this->dieUsage( "Invalid title given.", "invalidtitle" );
		}

		$errors = $this->title->getUserPermissionsErrors( 'stablesettings', $wgUser );
		if ( $errors ) {
			// We don't care about multiple errors, just report one of them
			$this->dieUsageMsg( reset( $errors ) );
		}

		$this->doExecute(); // child class
	}

	public abstract function doExecute();

	public function mustBePosted() {
		return true;
	}

	public function isWriteMode() {
 		return true;
 	}

	public function needsToken() {
		return true;
	}

	public function getTokenSalt() {
		return '';
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiStabilize.php 107476 2011-12-28 10:16:34Z siebrand $';
	}
}

// Assumes $wgFlaggedRevsProtection is off
class ApiStabilizeGeneral extends ApiStabilize {
	public function doExecute() {
		global $wgUser;

		$params = $this->extractRequestParams();

		$form = new PageStabilityGeneralForm( $wgUser );
		$form->setPage( $this->title ); # Our target page
		$form->setWatchThis( $params['watch'] ); # Watch this page
		$form->setReason( $params['reason'] ); # Reason
		$form->setReasonSelection( 'other' ); # Reason dropdown
		$form->setExpiry( $params['expiry'] ); # Expiry
		$form->setExpirySelection( 'other' ); # Expiry dropdown
		$restriction = $params['autoreview'];

		// Fill in config fields from URL params
		if ( $params['default'] === null ) {
			// Default version setting not optional
			$this->dieUsageMsg( array( 'missingparam', 'default' ) );
		} else {
			$form->setOverride( $this->defaultFromKey( $params['default'] ) );
		}

		$form->setReviewThis( $params['review'] ); # Auto-review option

		if ( $restriction == 'none' ) {
			$restriction = ''; // 'none' => ''
		}

		$form->setAutoreview( $restriction ); # Autoreview restriction
		$form->ready();

		$status = $form->submit(); // true/error message key
		if ( $status !== true ) {
			$this->dieUsageMsg( wfMsg( $status ) );
		}

		# Output success line with the title and config parameters
		$res = array();
		$res['title'] = $this->title->getPrefixedText();
		$res['default'] = $params['default'];
		$res['autoreview'] = $params['autoreview'];
		$res['expiry'] = $form->getExpiry();
		$this->getResult()->addValue( null, $this->getModuleName(), $res );
	}

	protected function defaultFromKey( $key ) {
		if ( $key == 'stable' ) {
			return 1;
		} elseif ( $key == 'latest' ) {
			return 0;
		}

		return null; // bad key?
	}

	public function getAllowedParams() {
		// Replace '' with more readable 'none' in autoreview restiction levels
		$autoreviewLevels = FlaggedRevs::getRestrictionLevels();
		$autoreviewLevels[] = 'none';
		$pars = array(
			'default'     => array(
				ApiBase :: PARAM_TYPE => array( 'latest', 'stable' ),
				ApiBase :: PARAM_DFLT => null,
			),
			'autoreview'  => array(
				ApiBase :: PARAM_TYPE => $autoreviewLevels,
				ApiBase :: PARAM_DFLT => 'none',
			),
			'expiry'      => 'infinite',
			'reason'      => '',
			'review'      => false,
			'watch'       => null,
			'token'       => null,
			'title'       => null,
		);
		return $pars;
	}

	public function getParamDescription() {
		return array(
			'default'       => 'Default revision to show',
			'autoreview'    => 'Auto-review restriction',
			'expiry'        => 'Expiry for these settings',
			'title'         => 'Title of page to be stabilized',
			'reason'        => 'Reason',
			'review'        => 'Review this page',
			'watch'         => 'Watch this page',
			'token'         => 'An edit token retrieved through prop=info'
		);
	}

	public function getDescription() {
		return 'Change page stability settings';
	}

	// @TODO: fill in stabilize_* values from PageStabilityGeneralForm
	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
			array( 'missingparam', 'title' ),
			array( 'missingparam', 'token' ),
			array( 'missingparam', 'default' ),
			array( 'code' => 'invalidtitle', 'info' => 'Invalid title given.' ),
			array( 'code' => 'invalidtitle', 'info' => 'Target page does not exist.' ),
			array( 'code' => 'invalidtitle', 'info' => 'Title given does not correspond to a reviewable page.' ),
		) );
	}

	public function getExamples() {
		return 'api.php?action=stabilize&title=Test&default=stable&reason=Test&token=123ABC';
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiStabilize.php 107476 2011-12-28 10:16:34Z siebrand $';
 	}
}

// Assumes $wgFlaggedRevsProtection is on
class ApiStabilizeProtect extends ApiStabilize {
	public function doExecute() {
		global $wgUser;
		$params = $this->extractRequestParams();

		$form = new PageStabilityProtectForm( $wgUser );
		$form->setPage( $this->title ); # Our target page
		$form->setWatchThis( $params['watch'] ); # Watch this page
		$form->setReason( $params['reason'] ); # Reason
		$form->setReasonSelection( 'other' ); # Reason dropdown
		$form->setExpiry( $params['expiry'] ); # Expiry
		$form->setExpirySelection( 'other' ); # Expiry dropdown

		$restriction = $params['protectlevel'];
		if ( $restriction == 'none' ) {
			$restriction = ''; // 'none' => ''
		}

		$form->setAutoreview( $restriction ); # Autoreview restriction
		$form->ready();

		$status = $form->submit(); // true/error message key
		if ( $status !== true ) {
			$this->dieUsageMsg( wfMsg( $status ) );
		}

		# Output success line with the title and config parameters
		$res = array();
		$res['title'] = $this->title->getPrefixedText();
		$res['protectlevel'] = $params['protectlevel'];
		$res['expiry'] = $form->getExpiry();
		$this->getResult()->addValue( null, $this->getModuleName(), $res );
	}

	public function getAllowedParams() {
		// Replace '' with more readable 'none' in autoreview restiction levels
		$autoreviewLevels = FlaggedRevs::getRestrictionLevels();
		$autoreviewLevels[] = 'none';
		return array(
			'protectlevel' => array(
				ApiBase :: PARAM_TYPE => $autoreviewLevels,
				ApiBase :: PARAM_DFLT => 'none',
			),
			'expiry'    => 'infinite',
			'reason'    => '',
			'watch'     => null,
			'token'     => null,
			'title'     => null,
		);
	}

	public function getParamDescription() {
		return array(
			'protectlevel'  => 'The review-protection level',
			'expiry'        => 'Review-protection expiry',
			'title'         => 'Title of page to be review-protected',
			'reason'        => 'Reason',
			'watch'         => 'Watch this page',
			'token'         => 'An edit token retrieved through prop=info',
		);
	}

	public function getDescription() {
		return 'Configure review-protection settings for a page';
	}

	// @TODO: fill in stabilize_* values from PageStabilityProtectForm
	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
			array( 'missingparam', 'title' ),
			array( 'missingparam', 'token' ),
			array( 'missingparam', 'default' ),
			array( 'code' => 'invalidtitle', 'info' => 'Invalid title given.' ),
			array( 'code' => 'invalidtitle', 'info' => 'Target page does not exist.' ),
			array( 'code' => 'invalidtitle', 'info' => 'Title given does not correspond to a reviewable page.' ),
		) );
	}

	public function getExamples() {
		return 'api.php?action=stabilize&title=Test&protectlevel=none&reason=Test&token=123ABC';
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiStabilize.php 107476 2011-12-28 10:16:34Z siebrand $';
 	}
}
