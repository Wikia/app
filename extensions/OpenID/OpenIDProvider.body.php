<?php
if ( !defined( 'MEDIAWIKI' ) )
	exit( 1 );

class OpenIDProvider {
	var $id;
	var $name;
	var $label;
	var $url;

	function OpenIDProvider( $id, $name, $label, $url ) {
		$this->id = $id;
		$this->name = $name;
		$this->label = $label;
		$this->url = $url;
	}

	function getButtonHTML( $isLarge ) {
		global $wgOpenIDShowProviderIcons, $wgOpenIDIconPath;

		if ( $wgOpenIDShowProviderIcons )
		{
			return '<a id="openid_provider_' . $this->id . '_icon" title="' . $this->name . '"' .
			' href="javascript: openid.show(\'' . $this->id . '\');"' .
			' class="openid_' . ( $isLarge ? 'large' : 'small' ) . '_btn' .
			( $this->id == 'openid' ? ' openid_selected' : '' ) . '"></a>';
		}
		else
		{
			return '<a id="openid_provider_' . $this->id . '_link" title="' . $this->name . '"' .
			' href="javascript: openid.show(\'' . $this->id . '\');"' .
			' class="openid_' . ( $isLarge ? 'large' : 'small' ) . '_link' .
			( $this->id == 'openid' ? ' openid_selected' : '' ) . '">' . $this->name . '</a>';
		}
	}
	function getLargeButtonHTML() { return $this->getButtonHTML( true ); }
	function getSmallButtonHTML() { return $this->getButtonHTML( false ); }

	function getLoginFormHTML() {
		global $wgCookiePrefix;

		$html = '<div id="provider_form_' . $this->id . '"' .
			( $this->id == 'openid' ? '' : ' style="display:none"' ) . '>' .
			'<div><label for="openid_url">' . $this->label . '</label></div>';

		if ( $this->id == 'openid' ) {
			$url = isset( $_COOKIE[$wgCookiePrefix.'OpenID'] ) ? htmlspecialchars( $_COOKIE[$wgCookiePrefix.'OpenID'] ) : '';
			$html .= '<input type="text" name="openid_url" id="openid_url" size="45" value="' . $url . '" />';
			$html .= Xml::submitButton( wfMsg( 'login' ) );
		} else {
			$html .= '<input type="hidden" id="openid_provider_url_' . $this->id . '" value="' . $this->url . '" />';
			if ( strpos( $this->url, '{' ) === false ) {
				$html .= '<input type="hidden" id="openid_provider_param_' . $this->id . '" size="25" value="" />';
			} else {
				$html .= '<input type="text" id="openid_provider_param_' . $this->id . '" size="25" value="" />';
			}
			$html .= Xml::submitButton( wfMsg( 'login' ) );
		}
		$html .= '</div>';

		return $html;
	}

	# large ones
	static function getLargeProviders() {
		return  array(
			new self( 'openid', 'OpenID', wfMsg( 'openid-provider-label-openid' ), '{URL}' ),
			new self( 'google', 'Google', wfMsg( 'openid-provider-label-google' ), 'https://www.google.com/accounts/o8/id' ),
			new self( 'yahoo', 'Yahoo', wfMsg( 'openid-provider-label-yahoo' ), 'http://yahoo.com/' ),
			new self( 'aol', 'AOL', wfMsg( 'openid-provider-label-aol' ), 'http://openid.aol.com/{username}' )
		);
	}

	# smaller ones
	static function getSmallProviders() {
		return array(
			new self( 'myopenid', 'MyOpenID', wfMsg( 'openid-provider-label-other-username', 'MyOpenID' ),
						'http://{username}.myopenid.com/' ),
			new self( 'livejournal', 'LiveJournal', wfMsg( 'openid-provider-label-other-username', 'LiveJournal' ),
						'http://{username}.livejournal.com/' ),
			new self( 'vox', 'VOX', wfMsg( 'openid-provider-label-other-username', 'VOX' ),
						'http://{username}.vox.com/' ),
# wordpress.com doesn't work for some reason
#			new self('wordpress', 'Wordpress.com', wfMsg('openid-provider-label-other-username', 'Wordpress.com'),
#						'http://{username}.wordpress.com/'),
			new self( 'blogger', 'Bloggger', wfMsg( 'openid-provider-label-other-username', 'Bloggger' ),
						'http://{username}.blogspot.com/' ),
			new self( 'flickr', 'Flickr', wfMsg( 'openid-provider-label-other-username', 'Flickr' ),
						'http://flickr.com/photos/{username}/' ),
			new self( 'verisign', 'Verisign', wfMsg( 'openid-provider-label-other-username', 'Verisign' ),
						'http://{username}.pip.verisignlabs.com/' ),
			new self( 'vidoop', 'Vidoop', wfMsg( 'openid-provider-label-other-username', 'Vidoop' ),
						'http://{username}.myvidoop.com/' ),
			new self( 'claimid', 'ClaimID', wfMsg( 'openid-provider-label-other-username', 'ClaimID' ),
						'http://claimid.com/{username}' )
		);
	}
}
