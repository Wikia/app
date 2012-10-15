<?php
/*
 * SpecialPage definition for FundraiserLandingPage.  Extending UnlistedSpecialPage
 * since this page does not need to listed in Special:SpecialPages.
 *
 * @author Peter Gehres <pgehres@wikimedia.org>
 */
class FundraiserLandingPage extends UnlistedSpecialPage
{
	function __construct() {
		parent::__construct( 'FundraiserLandingPage' );
	}

	function execute( $par ) {
		global $wgFundraiserLPDefaults, $wgRequest, $wgOut, $wgFundraiserLandingPageMaxAge;

		#Set squid age
		$wgOut->setSquidMaxage( $wgFundraiserLandingPageMaxAge );
		$this->setHeaders();

		# set the page title to something useful
		$wgOut->setPagetitle( wfMsg( 'donate_interface-make-your-donation' ) );

		# clear output variable to be safe
		$output = '';
		
		# begin generating the template call
		$template = $this->makeSafe( $wgRequest->getText( 'template', $wgFundraiserLPDefaults[ 'template' ] ) );
		$output .= "{{ $template\n";
		
		# get the required variables (except template and country) to use for the landing page
		$requiredParams = array(
			'appeal',
			'appeal-template',
			'form-template',
			'form-countryspecific'
		);
		foreach( $requiredParams as $requiredParam ) {
			$param = $this->makeSafe(
				$wgRequest->getText( $requiredParam, $wgFundraiserLPDefaults[$requiredParam] )
			);
			// Add them to the template call
			$output .= "| $requiredParam = $param\n";
		}

		# get the country code
		$country = $wgRequest->getVal( 'country' );
		# If country still isn't set, set it to the default
		if ( !$country ) {
			$country = $wgFundraiserLPDefaults[ 'country' ];
		}
		$country = $this->makeSafe( $country );
		$output .= "| country = $country\n";

		$excludeKeys = $requiredParams + array( 'template', 'country', 'title' );
		
		# add any other parameters passed in the querystring
		foreach ( $wgRequest->getValues() as $k_unsafe => $v_unsafe ) {
			# skip the required variables
			if ( in_array( $k_unsafe, $excludeKeys ) ) {
				continue;
			}
			# get the variable's name and value
			$key = $this->makeSafe( $k_unsafe );
			$val = $this->makeSafe( $v_unsafe );
			# print to the template in wiki-syntax
			$output .= "| $key = $val\n";
		}
		# close the template call
		$output .= "}}";

		# print the output to the page
		$wgOut->addWikiText( $output );
	}


	/**
	 * This function limits the possible charactes passed as template keys and
	 * values to letters, numbers, hypens and underscores. The function also
	 * performs standard escaping of the passed values.
	 *
	 * @param $string The unsafe string to escape and check for invalid characters
	 * @return mixed|String A string matching the regex or an empty string
	 */
	function makeSafe( $string ) {
		$num = preg_match( '([a-zA-Z0-9_-]+)', $string, $matches );

		if ( $num == 1 ){
			# theoretically this is overkill, but better safe than sorry
			return wfEscapeWikiText( htmlspecialchars( $matches[0] ) );
		}
		return '';
	}
}

