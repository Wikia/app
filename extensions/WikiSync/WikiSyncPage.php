<?php
/**
 * ***** BEGIN LICENSE BLOCK *****
 * This file is part of WikiSync.
 *
 * WikiSync is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * WikiSync is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with WikiSync; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * ***** END LICENSE BLOCK *****
 *
 * WikiSync allows an AJAX-based synchronization of revisions and files between
 * global wiki site and it's local mirror.
 *
 * To activate this extension :
 * * Create a new directory named WikiSync into the directory "extensions" of MediaWiki.
 * * Place the files from the extension archive there.
 * * Add this line at the end of your LocalSettings.php file :
 * require_once "$IP/extensions/WikiSync/WikiSync.php";
 *
 * @version 0.3.2
 * @link http://www.mediawiki.org/wiki/Extension:WikiSync
 * @author Dmitriy Sintsov <questpc@rambler.ru>
 * @addtogroup Extensions
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This file is a part of MediaWiki extension.\n" );
}

class WikiSyncPage extends SpecialPage {

	var $page_tpl;

	var $initUser;

	function initRemoteLoginFormTpl() {
		$remote_wiki_root = _QXML::specialchars( WikiSyncSetup::$remote_wiki_root );
		$remote_wiki_user = _QXML::specialchars( WikiSyncSetup::$remote_wiki_user );
		$js_remote_change = 'return WikiSync.remoteRootChange(this)';
		$js_blur = 'return WikiSync.blurElement(this);';
		return
			array( '__tag'=>'table', 'style'=>'width:100%; ',
				array( '__tag'=>'form', 'id'=>'remote_login_form', 'onsubmit'=>'return WikiSync.submitRemoteLogin(this);',
					array( '__tag'=>'tr',
						array( '__tag'=>'th', 'colspan'=>'2', 'style'=>'text-align:center; ', wfMsgHtml( 'wikisync_login_to_remote_wiki' ) )
					),
					array( '__tag'=>'tr', 'title'=>wfMsgHtml( 'wikisync_remote_wiki_example' ),
						array( '__tag'=>'td', wfMsgHtml( 'wikisync_remote_wiki_root' ) ),
						array( '__tag'=>'td', array( '__tag'=>'input', 'type'=>'text', 'name'=>'remote_wiki_root' , 'value'=>$remote_wiki_root, 'onkeyup'=>$js_remote_change, 'onchange'=>$js_remote_change ) )
					),
					array( '__tag'=>'tr',
						array( '__tag'=>'td', wfMsgHtml( 'wikisync_remote_wiki_user' ) ),
						array( '__tag'=>'td', array( '__tag'=>'input', 'type'=>'text', 'name'=>'remote_wiki_user', 'value'=>$remote_wiki_user, 'disabled'=>'' ) )
					),
					array( '__tag'=>'tr',
						array( '__tag'=>'td', wfMsgHtml( 'wikisync_remote_wiki_pass' ) ),
						array( '__tag'=>'td', array( '__tag'=>'input', 'type'=>'password', 'name'=>'remote_wiki_pass' ) )
					),
					array( '__tag'=>'tr',
						array( '__tag'=>'td', 'colspan'=>'2',
							wfMsgHtml( 'wikisync_sync_files' ),
							array( '__tag'=>'input', 'type'=>'checkbox', 'id'=>'ws_sync_files', 'name'=>'ws_sync_files', 'onchange'=>$js_blur, 'onmouseup'=>$js_blur, 'checked'=>'' ),
							array( '__tag'=>'br', 'clear'=>'all', '' ),
							array( '__tag'=>'span', 'title'=>wfMsgHtml( 'wikisync_storing_password_warning' ),
								wfMsgHtml( 'wikisync_store_password' ),
								array( '__tag'=>'input', 'type'=>'checkbox', 'id'=>'ws_store_password', 'name'=>'ws_store_password', 'onchange'=>$js_blur, 'onmouseup'=>$js_blur )
							)
						)
					),
					array( '__tag'=>'tr',
						array( '__tag'=>'td', array( '__tag'=>'input', 'id'=>'wikisync_synchronization_button', 'type'=>'button', 'value'=>wfMsgHtml( 'wikisync_synchronization_button' ), 'disabled'=>'', 'onclick'=>'return WikiSync.process(\'init\')' ) ),
						array( '__tag'=>'td', 'style'=>'text-align:right; ', array( '__tag'=>'input', 'id'=>'wikisync_submit_button', 'type'=>'submit', 'value'=>wfMsgHtml( 'wikisync_remote_login_button' ) ) )
					)
				)
			);
	}

	function initSchedulerTpl() {
		$js_blur = 'return WikiSync.blurElement(this);';
		return
			array( '__tag'=>'table', 'style'=>'width:100%; ',
				array( '__tag'=>'form', 'id'=>'scheduler_form', 'onsubmit'=>'return WikiSyncScheduler.setup(this);',
					array( '__tag'=>'tr',
						array( '__tag'=>'th', 'colspan'=>'2', 'style'=>'text-align:center; ', wfMsgHtml( 'wikisync_scheduler_setup' ) )
					),
					array( '__tag'=>'tr',
						array( '__tag'=>'td', 'colspan'=>'2',
							wfMsgHtml( 'wikisync_scheduler_turn_on' ),
							array( '__tag'=>'input', 'type'=>'checkbox', 'name'=>'ws_auto_sync', 'onchange'=>$js_blur, 'onmouseup'=>$js_blur ),
							array( '__tag'=>'br', 'clear'=>'all', '' ),
							wfMsgHtml( 'wikisync_scheduler_switch_direction' ),
							array( '__tag'=>'input', 'type'=>'checkbox', 'name'=>'ws_auto_switch_direction', 'onchange'=>$js_blur, 'onmouseup'=>$js_blur ),
							array( '__tag'=>'br', 'clear'=>'all', '' ),
							wfMsgHtml( 'wikisync_scheduler_time_interval' ),
							array( '__tag'=>'input', 'type'=>'text', 'style'=>'margin-left:3px; width:3em; ', 'name'=>'ws_auto_sync_time_interval' )
						)
					),
					array( '__tag'=>'tr',
						array( '__tag'=>'td', 'id'=>'ws_scheduler_countdown', '' ), // a placeholder for scheduled time countdown in javascript
						array( '__tag'=>'td', 'style'=>'text-align:right; ', array( '__tag'=>'input', 'id'=>'wikisync_scheduler_apply_button', 'type'=>'submit', 'value'=>wfMsgHtml( 'wikisync_apply_button' ) ) )
					)
				)
			);
	}

	function initLogTpl( $log_id ) {
		return
			array( '__tag'=>'table', 'style'=>'width:100%; ',
				array( '__tag'=>'tr',
					array( '__tag'=>'th', 'style'=>'text-align:center; ', wfMsgHtml( $log_id ) )
				),
				array( '__tag'=>'tr',
					array( '__tag'=>'td',
						array( '__tag'=>'div', 'class'=>'wikisync_log', 'id'=>$log_id )
					)
				),
				array( '__tag'=>'tr',
					array( '__tag'=>'td',
						array( '__tag'=>'input', 'type'=>'button', 'value'=>wfMsgHtml( 'wikisync_clear_log' ), 'onclick'=>'return WikiSync.clearLog(\'' . $log_id . '\')' )
					)
				)
			);
	}

	function initSyncDirectionTpl() {
		global $wgServer, $wgScriptPath;
		return
			array(
				array( '__tag'=>'div', 'style'=>'width:100%; font-weight:bold; text-align:center; ', wfMsgHTML( 'wikisync_direction' ) ),
				array(	'__tag'=>'table', 'style'=>'margin:0 auto 0 auto; ',
					array( '__tag'=>'tr',
						array( '__tag'=>'td', 'style'=>'text-align:right; ', wfMsgHTML( 'wikisync_local_root' ) ),
						array( '__tag'=>'td', 'rowspan'=>'2', 'style'=>'vertical-align:middle; ', array( '__tag'=>'input', 'id'=>'wikisync_direction_button', 'type'=>'button', 'value'=>'&lt;=', 'onclick'=>'return WikiSync.switchDirection(this)' ) ),
						array( '__tag'=>'td', wfMsgHTML( 'wikisync_remote_root' ) )
					),
					array( '__tag'=>'tr',
						array( '__tag'=>'td', 'style'=>'text-align:right; ', $wgServer . $wgScriptPath ),
						array( '__tag'=>'td', 'id'=>'wikisync_remote_root', WikiSyncSetup::$remote_wiki_root )
					)
				)
			);
	}

	function initPercentsIndicatorTpl( $id ) {
		return
			array( '__tag'=>'table', 'id'=>$id, 'class'=>'wikisync_percents_indicator', 'style'=>'display: none;',
				array( '__tag'=>'tr',
					// progress explanation hint
					array( '__tag'=>'td', 'style'=>'font-size:9pt; ', 'colspan'=>'2', '' )
				),
				array( '__tag'=>'tr', 'style'=>'border:1px solid gray; height:12px; ',
					array( '__tag'=>'td', 'style'=>'width:0%; background-color:Gold; display: none; ', '' ),
					array( '__tag'=>'td', 'style'=>'width:100%;', '' )
				)
			);
	}

	function initPageTpl() {
		$tr_style = 'border:2px dashed lightgray; ';
		$this->page_tpl =
			array( '__tag'=>'table', 'class'=>'wikisync_main',
				array( '__tag'=>'tr', 'style'=>$tr_style,
					array( '__tag'=>'td', 'colspan'=>'2', $this->initSyncDirectionTpl() )
				),
				array( '__tag'=>'tr', 'style'=>$tr_style,
					array( '__tag'=>'td', 'style'=>'width:50%; ',
						$this->initLogTpl( 'wikisync_remote_log' ),
					),
					array( '__tag'=>'td', 'style'=>'width:50%; ',
						$this->initRemoteLoginFormTpl(),
					)
				),
				array( '__tag'=>'tr', 'style'=>$tr_style,
					array( '__tag'=>'td', 'style'=>'width:50%; ',
						$this->initLogTpl( 'wikisync_scheduler_log' ),
					),
					array( '__tag'=>'td', 'style'=>'width:50%; ',
						$this->initSchedulerTpl()
					)
				),
				array( '__tag'=>'tr',
					array( '__tag'=>'td', 'colspan'=>'2',
						$this->initPercentsIndicatorTpl( 'wikisync_xml_percents' ),
						$this->initPercentsIndicatorTpl( 'wikisync_files_percents' )
					)
				),
				array( '__tag'=>'tr',
					array( '__tag'=>'td', 'colspan'=>'2', 'id'=>'wikisync_iframe_location' , '' )
				),
				array( '__tag'=>'tr',
					array( '__tag'=>'td', 'colspan'=>'2',
						// Have to explicitly set empty contents for the iframe, or we'll produce
						// <iframe /> which browsers consider an unclosed tag
						array( '__tag'=> 'iframe', 'id'=>'wikisync_iframe', 'style' => 'width:100%; height:200px; display:none; ', '' )
					)
				)
			);
	}

	function __construct() {
		parent::__construct( 'WikiSync', 'edit' );
		$this->initUser = WikiSyncSetup::initUser();
	}

	function execute( $param ) {
		global $wgOut, $wgContLang;
		global $wgUser;
		# commented out, ignored by FF 3+ anyway
#		$wgOut->enableClientCache( false );
		if ( !$wgUser->isAllowed( 'edit' ) ) {
			$wgOut->permissionRequired('edit');
			return;
		}
		if ( is_string( $this->initUser ) ) {
			# not enough priviledges to run this method
			$wgOut->addHTML( $this->initUser );
			return;
		}
		if ( !$wgUser->isAnon() ) {
			WikiSyncSetup::$remote_wiki_user = $wgUser->getName();
		}
		WikiSyncSetup::headScripts( $wgOut, $wgContLang->isRTL() );
		$wgOut->setPagetitle( wfMsgHtml( 'wikisync' ) );
		$this->initPageTpl();
		$wgOut->addHTML( "\n" );
		$wgOut->addHTML( _QXML::toText( $this->page_tpl, 4 ) );
	}

} /* end of WikiSyncPage class */
