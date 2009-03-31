<?php

class SpecialConfigure extends SpecialPage {
	function __construct() {
		wfLoadExtensionMessages( 'ConfigureWMF' );
		parent::__construct( 'Configure', 'configure' );
	}

	function getDescription() {
		return wfMsg( 'configurewmf-page' );
	}

	function execute( $subpage ) {
		global $wgRequest, $wgUser;
		$this->setHeaders();

		if( !( $wiki = $wgRequest->getVal( 'wiki' ) ) || !ConfigureWMF::isValidTarget( $wiki ) ) {
			$this->showSiteSelectForm( $wiki );
			return;
		}
		if( $wiki == 'wikipedia' ) $wiki = 'wiki';
		if( !( $setting = $wgRequest->getVal( 'config' ) ) || !isset( ConfigureWMF::$settings[$setting] ) ) {
			$this->showSettingsChoiceForm( $wiki );
			return;
		}
		if( !( $et = $wgRequest->getVal( 'edittoken' ) ) || !$wgUser->matchEditToken( $et ) ) {
			$this->handleChangeSettingsForm( $wiki, $setting );
			return;
		}
		list( $values, $logs, $error ) = $this->formatValues( $wiki, $setting );
		if( $error ) {
			$this->handleChangeSettingsForm( $wiki, $setting );
			return;
		}

		$dbw = ConfigureWMF::getMasterDB();
		$dbw->delete( 'config_overrides',
			array(
				'cfg_target' => $wiki,
				'cfg_name' => $setting,
			),
			__METHOD__
		);
		$dbw->insert( 'config_overrides',
			array(
				'cfg_target' => $wiki,
				'cfg_name' => $setting,
				'cfg_value' => serialize( $values ),
				'cfg_user_text' => $wgUser->getName(),
				'cfg_timestamp' => $dbw->timestamp(),
			),
			__METHOD__
		);
		$this->logAction( $setting, $wgRequest->getVal( 'wpReason' ), $wiki, $logs );
		$this->showSettingsChoiceForm( $wiki, true );
	}

	function showSiteSelectForm( $invalid = false ) {
		global $wgOut, $wgScript, $wgTitle;
		$legend = wfMsgHtml( 'configurewmf-selectsite' );
		$wgOut->addHTML( "<fieldset><legend>{$legend}</legend>" );
		if( $invalid ) {
			$wgOut->addHTML( '<p><strong class="error">' . htmlspecialchars( wfMsg( 'configurewmf-invalidwiki', $invalid ) ) . '</strong></p>' );
		}
		$wgOut->addHTML( '<strong id="cfgwmf-attention" style="color: red; font-size: 12pt">' . wfMsgHTML( 'configurewmf-attentionnotice' ) . '</strong>' );
		$wgOut->addWikiMsg( 'configurewmf-selectsite-help' );
		$wgOut->addHTML( "<form action='{$wgScript}' method='get'>" );
		$wgOut->addHTML( '<p>' . Xml::hidden( 'title', $wgTitle->getFullText() ) . '</p><table><tr>' );
		$wgOut->addHTML( '<td class="mw-label">' . Xml::label( wfMsg( 'configurewmf-site' ), 'cfg-site' ) . '</td>' );
		$wgOut->addHTML( '<td class="mw-input">' . Xml::input( 'wiki', false, false, array( 'id' => 'cfg-site' ) ) . '</td>' );
		$wgOut->addHTML( '</tr><tr><td></td><td class="mw-input">' . Xml::submitButton( wfMsg( 'configurewmf-select' ) ) . '</td>' );
		$wgOut->addHTML( "</tr></table></form></fieldset>" );
	}

	function showSettingsChoiceForm( $wiki, $success = false ) {
		global $wgOut, $wgTitle;
		$this->addNav( 1, $wiki );
		$legend = wfMsgHtml( 'configurewmf-chooseconfig' );
		$wgOut->addHTML( "<fieldset><legend>{$legend}</legend>" );
		if( $success ) {
			$wgOut->addHTML( '<p><strong class="success">' . wfMsgHtml( 'configurewmf-success' ) . '</strong></p>' );
		}
		$wgOut->addWikiMsg( 'configurewmf-chooseconfig-intro' );
		$wgOut->addHTML( '<ul>' );
		foreach( ConfigureWMF::$settings as $name => $value ) {
			$descr = wfMsgHtml( "configurewmf-cfgname-{$name}" );
			$url = htmlspecialchars( $wgTitle->getLocalURL( "wiki={$wiki}&config={$name}" ) );
			$wgOut->addHTML( "<li><a href='{$url}'>{$descr}</a></li>" );
		}
		$wgOut->addHTML( '</ul></fieldset>' );
	}

	function handleChangeSettingsForm( $wiki, $config ) {
		global $wgRequest;
		if( ( $config == 'groupperms' || $config == 'chgrpperms' ) && !$wgRequest->getVal( 'group' ) ) {
			$this->showGroupsList( $wiki, $config );
		} else {
			$this->showChangeSettingsForm( $wiki, $config );
		}
	}

	function showGroupsList( $wiki, $config ) {
		global $wgOut, $wgConfigure, $wgRequest, $wgScript;
		
		$this->addNav( 2, $wiki, $config );
		$changeExisting = wfMsgHtml( 'configurewmf-changexistinggroups' );
		$wgOut->addHTML( "<fieldset><legend>{$changeExisting}</legend>" );
		$wgOut->addWikiMsg( 'configurewmf-grouptochange' );
		$wgOut->addHTML( "<ul>\n" );
		$groups = $wgConfigure->getGroupPermissions( $wiki );
		foreach( array_keys( $groups ) as $group ) {
			$url = htmlspecialchars( $wgRequest->appendQueryValue( 'group', $group ) );
			$wgOut->addHTML( "<li><a href=\"{$url}\">{$group}</a></li>\n" );
		}
		$wgOut->addHTML( "</ul></fieldset>\n" );

		$newLegend = wfMsgHtml( 'configurewmf-createnewgroup' );
		$wgOut->addHTML( "<fieldset><legend>{$newLegend}</legend><form method='get' action='{$wgScript}'>" );
		foreach( $_GET as $var => $val ) $wgOut->addHTML( Xml::hidden( $var, $val ) );
		$wgOut->addHTML( Xml::buildForm( array( 'configurewmf-groupname' => Xml::input( 'group' ) ), 'configurewmf-creategroup' ) );
		$wgOut->addHTML( "</form></fieldset>\n" );
	}

	function showChangeSettingsForm( $wiki, $config ) {
		global $wgOut, $wgTitle, $wgScript, $wgUser, $wgRequest;
		$legend = wfMsgHtml( 'configurewmf-change' );
		$submit = wfMsg( 'configurewmf-submit' );
		$reason = wfMsg( 'configurewmf-reason' );
		$reasonlabel = Xml::label( $reason, 'cfg-reason' );
		$reasoninput = Xml::input( 'wpReason', false, false, array( 'id' => 'cfg-reason' ) );

		$vars = array();
		foreach( array_keys( ConfigureWMF::$settings[$config] ) as $var )
			if( substr( $var, 0, 2 ) == 'wg' )
				$vars[] = "<a href='http://mediawiki.org/wiki/Manual:\${$var}'>\${$var}</a>";
		$vars = implode( ', ', $vars );

		if( in_array( $config, array( 'groupperms', 'chgrpperms' ) ) )
			$this->addNav( 3, $wiki, $config, $wgRequest->getVal( 'group' ) );
		else
			$this->addNav( 2, $wiki, $config );
		$wgOut->addHTML( "<fieldset><legend>{$legend}</legend>" );
		$wgOut->addWikiMsg( "configurewmf-help-{$config}" );
		$wgOut->addHTML( wfMsgWikiHtml( 'configurewmf-seealso', $vars ) );
		$wgOut->addHTML( "<hr/>" );
		$wgOut->addHTML( "<form action='{$wgScript}' method='post'><p>" );
		$wgOut->addHTML( Xml::hidden( 'title', $wgTitle->getFullText() ) );
		$wgOut->addHTML( Xml::hidden( 'wiki', $wiki ) );
		$wgOut->addHTML( Xml::hidden( 'config', $config ) );
		$wgOut->addHTML( Xml::hidden( 'edittoken', $wgUser->editToken() ) );
		$wgOut->addHTML( "</p><table><tbody>" );
		foreach( ConfigureWMF::$settings[$config] as $key => $value ) {
			if( substr( $key, 0, 2 ) == '__' )
				continue;
			$wgOut->addHTML( $this->formatConfigInput( $key, $value, $wiki ) );
		}
		$wgOut->addHTML( "<tr><td class='mw-label'>{$reasonlabel}</td><td class='mw-input'>{$reasoninput}</td></tr>" );
		$wgOut->addHTML( '<tr><td></td><td class="mw-input">' .
			Xml::submitButton( $submit ) . '</td></tr>' );
		$wgOut->addHTML( "</tbody></table></form></fieldset>" );
	}

	function formatConfigInput( $var, $type, $wiki = '' ) {
		global $wgConfigure, $wgRequest;
		$val = $wgConfigure->getSetting( $wiki, $var );
		$descr = wfMsg( 'configurewmf-var-' . strtolower( $var ) );
		$descrlabel = Xml::label( $descr, $var );
		$r = "<tr><td class='mw-label'>{$descrlabel}:</td>\n\n<td class='mw-input'>";
		switch( $type ) {
			case 'string':
				$r .= Xml::input( $var, false, $val );
				break;
			case 'bool':
				$r .= Xml::check( $var, $val );
				break;
			case 'stringarray':
				$val = $val ? implode( "\n", $val ) : '';
				$r .= Xml::textarea( $var, $val );
				break;
			case 'logo':
				global $wgConfigureStdlogo;
				$isstd = $val == $wgConfigureStdlogo;
				$r .= '<div>' . Xml::radioLabel( wfMsgHtml( 'configurewmf-stdlogo' ),
					$var, 'stdlogo', 'wgLogoStdlogo', $isstd ) . '</div>';
				$r .= '<div>' . Xml::radioLabel( wfMsgHtml( 'configurewmf-otherlogo' ),
					$var, 'other', 'wgLogoOther', !$isstd ) . '&nbsp;' .
					Xml::input( "{$var}Other", false, $isstd ? '' : $val ) . '</div>';
				break;
			case 'groupperms':
				$groups = $wgConfigure->getGroupPermissions( $wiki );
				$group = $wgRequest->getVal( 'group' );
				$perms = isset( $groups[$group] ) ? $groups[$group] : array();
				
				$rights = User::getAllRights();

				sort( $rights );

				$checkboxes = array();

				foreach( $rights as $right ) {
					$label = wfMsgExt( 'configurewmf-permission', array( 'parseinline' ),
						User::getRightDescription( $right ), $right );
					$checkboxes[] = Xml::checkLabel(
						$label,	"{$var}-{$right}", "{$var}-{$right}", @$perms[$right]
					);
				}

				$firstCol = round( count( $checkboxes ) / 2 );

				$checkboxes1 = array_slice( $checkboxes, 0, $firstCol );
				$checkboxes2 = array_slice( $checkboxes, $firstCol );

				$r .= '<table><tbody><tr><td><ul><li>' . implode( '</li><li>', $checkboxes1 ) .
					'</li></ul></td><td><ul><li>' . implode( '</li><li>', $checkboxes2 ) .
					'</li></ul></td></tr></tbody></table>';
				$r .= Xml::hidden( 'group', $group );
				break;
			case 'grouplist':
				$targetgroup = $wgRequest->getVal( 'group' );
				$r .= '<ul>';
				foreach( array_keys( $wgConfigure->getGroupPermissions( $wiki ) ) as $group ) {
					if( in_array( $group, $wgConfigure->getSetting( $wiki, 'wgImplicitGroups' ) ) )
						continue;
					$checked = isset( $val[$targetgroup] ) ? in_array( $group, $val[$targetgroup] ) : false;
					$checkbox = Xml::checkLabel( User::getGroupName( $group ),
						"{$var}-{$group}", "{$var}-{$group}", $checked );
					$r .= "<li>{$checkbox}</li>\n";
				}
				$r .= '</ul>';
				break;
		}
		return $r . '</td></tr>';
	}

	function formatValues( $wiki, $config ) {
		global $wgRequest, $wgConfigure;
		$values = array();
		$logs = array();
		$error = false;
		foreach( ConfigureWMF::$settings[$config] as $name => $value ) {
			switch( $value ) {
				case 'string':
					$values[$name] = $wgRequest->getVal( $name );
					$logs[] = $wgRequest->getVal( $name );
					break;
				case 'bool':
					$values[$name] = $wgRequest->getCheck( $name );
					$logs[] = wfMsgForContent( 'configurewmf-log-' . ( $values[$name] ? 'true' : 'false' ) );
					break;
				case 'stringarray':
					$values[$name] = array_unique( preg_split( '/\n/', $wgRequest->getVal( $name ), -1, PREG_SPLIT_NO_EMPTY ) );
					$logs[] = $values[$name] ? implode( ', ', $values[$name] ) : wfMsgForContent( 'rightsnone' );
					break;
				case 'logo':
					global $wgConfigureStdlogo;
					$input = $wgRequest->getVal( $name );
					$values[$name] = ( $input == 'stdlogo' ? $wgConfigureStdlogo : $wgRequest->getVal( "{$name}Other" ) );
					$logs[] = ( $input == 'stdlogo' ? wfMsgForContent( 'configurewmf-log-stdlogo' ) : $wgRequest->getVal( "{$name}Other" ) );
					break;
				case 'groupperms':
					$groupperms = $wgConfigure->getGroupPermissions( $wiki );
					$group = $wgRequest->getVal( 'group' );
					$perms = isset( $groupperms[$group] ) ? $groupperms[$group] : array();
					$rights = User::getAllRights();
					$changes = array();
					foreach( $rights as $right ) {
							if( ( (bool)@$perms[$right] ) != $wgRequest->getCheck( "{$name}-{$right}" ) ) {
								$changes[$right] = $wgRequest->getCheck( "{$name}-{$right}" );
							}
					}

					if( $changes ) {
						$override = $wgConfigure->getOverride( $config, $wiki );
						$override = $override && isset( $override->cfg_value['wgGroupPermissions'] ) ? $override->cfg_value['wgGroupPermissions'] : array();
						if( !isset( $override[$group] ) )
							$override[$group] = array();
						$override[$group] = $changes + $override[$group];
						$values[$name] = $override;
					}

					$added = $removed = array();
					foreach( $changes as $perm => $value ) {
						if( $value )
							$added[] = $perm;
						else
							$removed[] = $perm;
					}
					$logs[] = $group;
					$logs[] = $added ? implode( ', ', $added ) : wfMsgForContent( 'rightsnone' );
					$logs[] = $removed ? implode( ', ', $removed ) : wfMsgForContent( 'rightsnone' );
					break;
				case 'grouplist':
					$targetgroup = $wgRequest->getVal( 'group' );
					$oldval = $wgConfigure->getSetting( $wiki, $name );
					$old = isset( $oldval[$targetgroup] ) ? $oldval[$targetgroup] : array();
					$override = $wgConfigure->getOverride( $config, $wiki );
					$override = $override && isset( $override->cfg_value[$name] ) ? $override->cfg_value[$name] : array();
					$new = array();
					foreach( array_keys( $wgConfigure->getGroupPermissions( $wiki ) ) as $group ) {
						if( $wgRequest->getCheck( "{$name}-{$group}" ) )
							$new[] = $group;
					}
					var_dump( $old, $new, $override );
					if( array_diff( $old, $new ) ) {
						$override[$targetgroup] = $new;
						$values[$name] = $new;
					}
					$logs[] = $new ? implode( ', ', $new ) : wfMsgForContent( 'rightsnone' );
					break;
			}
		}
		return array( $values, $logs, $error );
	}

	function addNav( $levels = 0, $wiki = '', $config = '', $group = '' ) {
		global $wgUser, $wgTitle, $wgOut;
		$skin = $wgUser->getSkin();
		$bits = array();
		$bits[] = array( '', wfMsg( 'configurewmf-nav-rootpage' ) );
		if( $levels >= 1 ) {
			$bits[] = array( "wiki={$wiki}", $wiki );
		}
		if( $levels >= 2 ) {
			$bits[] = array( "wiki={$wiki}&config={$config}", wfMsg( "configurewmf-cfgname-{$config}" ) );
		}
		if( $levels >= 3 ) {
			$bits[] = array( "wiki={$wiki}&config={$config}&group={$group}", $group );
		}
		if( $bits ) {
			for( $i = 0; $i < count( $bits ); $i++ )
				if( $i == count( $bits ) - 1 )
					$bits[$i] = $bits[$i][1];
				else
					$bits[$i] = $skin->makeLinkObj( $wgTitle, $bits[$i][1], $bits[$i][0] );
			$wgOut->setSubtitle( '<div id="contentSub"><span class="subpages">&lt; ' .
				implode( '&nbsp;|&nbsp;', $bits ) . '</span></div>' );
		}
	}

	function logAction( $action, $reason, $wiki, $params ) {
		$log = new LogPage( 'config' );
		$log->addEntry( $action, $this->getTitle(), $reason, array_merge( array( $wiki ), $params ) );
	}
}
