<?php
if ( !defined( 'MEDIAWIKI' ) ) die();

/**
 * Special page allows authorised users to see wiki's configuration
 * This should also be available if efConfigureSetup() hasn't been called
 *
 * @ingroup Extensions
 */
class SpecialViewConfig extends ConfigurationPage {
	protected $mCanEdit = false;

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'ViewConfig', 'viewconfig' );
	}

	protected function getSettingMask() {
		return CONF_SETTINGS_BOTH;
	}

	protected function showOldVersionMessage( $version ) {
		global $wgConf;

		$this->version = $version;

		$diff = $this->getRequest()->getVal( 'diff' );
		if ( $diff ) {
			if ( !$wgConf->versionExists( $diff ) ) {
				$this->getOutput()->wrapWikiMsg( '<div class="errorbox">$1</div>',
					array( 'configure-old-not-available', $diff ) );
				return false;
			}
			$this->diff = $diff;
		}
		return true;
	}

	/**
	 * Just in case, security
	 */
	protected function doSubmit() { }

	/**
	 * Show diff
	 */
	protected function showDiff() {
		$wikis = $this->isUserAllowedAll() ? true : array( $this->mWiki );
		$diffEngine = new HistoryConfigurationDiff( $this->getContext(), $this->diff, $this->version, $wikis );
		$diffEngine->setViewCallback( array( $this, 'userCanRead' ) );
		$this->getOutput()->addHTML( $diffEngine->getHTML() );
	}

	/**
	 * Show the main form
	 */
	protected function showForm() {
		if ( !empty( $this->conf ) || isset( $this->diff ) ) {
			if ( isset( $this->diff ) ) {
				$this->showDiff();
			} else {
				$this->getOutput()->addHTML(
					$this->buildSearchForm() . "\n" .
					Xml::openElement( 'div', array( 'id' => 'configure-form' ) ) . "\n" .
					Xml::openElement( 'div', array( 'id' => 'configure' ) ) . "\n" .

					$this->buildAllSettings() . "\n" .

					Xml::closeElement( 'div' ) . "\n" .
					Xml::closeElement( 'div' ) . "\n"
				);
			}
		} else {
			$this->getOutput()->addHTML( $this->buildOldVersionSelect() );
		}
		$this->injectScriptsAndStyles();
	}

	/**
	 * Build links to old version of the configuration
	 */
	protected function buildOldVersionSelect() {
		global $wgConf, $wgScript;

		$self = $this->getTitle();
		$pager = $wgConf->getPager();
		$pager->setFormatCallback( array( $this, 'formatVersionRow' ) );

		$wiki = $this->isUserAllowedInterwiki() && $this->getRequest()->getVal( 'view', 'all' ) == 'all' ? false : $this->mWiki;
		$pager->setWiki( $wiki );

		$showDiff = $pager->getNumRows() > 1;

		$user = $this->getUser();
		$formatConf = array(
			'showDiff' => $showDiff,
			'allowedConfig' => $user->isAllowed( 'configure' ),
			'allowedExtensions' => $user->isAllowed( 'extensions' ),
			'allowedAll' => $this->isUserAllowedInterwiki(),
			'allowedConfigAll' => $user->isAllowed( 'configure-interwiki' ),
			'allowedExtensionsAll' => $user->isAllowed( 'extensions-interwiki' ),
			'self' => $self,
			'editMsg' => $this->msg( 'edit' )->text() . $this->msg( 'colon-separator' )->text(),
		);

		if ( $formatConf['allowedConfig'] )
			$formatConf['configTitle'] = SpecialPage::getTitleFor( 'Configure' );

		if ( $formatConf['allowedExtensions'] )
			$formatConf['extTitle'] = SpecialPage::getTitleFor( 'Extensions' );

		$this->formatConf = $formatConf;

		$text = $this->msg( 'configure-old-versions' )->parseAsBlock();
		if( $this->isUserAllowedInterwiki() )
			$text .= $this->getWikiSelectForm();
		$text .= $pager->getNavigationBar();
		if ( $showDiff ) {
			$text .= Xml::openElement( 'form', array( 'action' => $wgScript ) ) . "\n" .
			Html::Hidden( 'title', $self->getPrefixedDBKey() ) . "\n" .
			$this->getButton() . "<br />\n";
		}
		$text .= $pager->getBody();
		if ( $showDiff ) {
			$text .= $this->getButton() . "</form>";
		}
		$text .= $pager->getNavigationBar();
		return $text;
	}

	public function formatVersionRow( $arr ) {
		$ts = $arr['timestamp'];
		$wikis = $arr['wikis'];
		$c = $arr['count'];
		$hasSelf = in_array( $this->mWiki, $wikis );

		extract( $this->formatConf );

		$lang = $this->getLang();
		$datime = $lang->timeanddate( $ts );
		$date = $lang->date( $ts );
		$time = $lang->time( $ts );

		## Make user link...
		$userLink = '';
		if (!$arr['user_wiki'] && !$arr['user_name'] ) {
			$userLink = ''; # Nothing...
			$username = '';
		} elseif ( $arr['user_wiki'] == wfWikiId() ) {
			$userLink = Linker::link( Title::makeTitle( NS_USER, $arr['user_name'] ), htmlspecialchars( $arr['user_name'] ) );
			$username = $arr['user_name'];
		} elseif ( $wiki = WikiMap::getWiki( $arr['user_wiki'] ) ) {
			$userLink = Linker::makeExternalLink( $wiki->getUrl( 'User:'.$arr['user_name'] ), htmlspecialchars( $arr['user_name'].'@'.$arr['user_wiki'] ) );
			$username = '';
		} else {
			## Last-ditch
			$userLink = htmlspecialchars( $arr['user_name'].'@'.$arr['user_wiki'] );
			$username = '';
		}

		$actions = array();
		$view = '';
		if ( $hasSelf )
			$view .= Linker::linkKnown( $self, $this->msg( 'configure-view' )->escaped(), array(), array( 'version' => $ts ) );
		elseif( $allowedAll )
			$view .= $this->msg( 'configure-view' )->escaped();

		if ( $allowedAll ) {
			$viewWikis = array();
			foreach ( $wikis as $wiki ) {
				$viewWikis[] = Linker::linkKnown( $self, htmlspecialchars( $wiki ), array(), array( 'version' => $ts, 'wiki' => $wiki ) );
			}
			$view .= ' (' . $lang->commaList( $viewWikis ) . ')';
		}

		if( $view )
			$actions[] = $view;

		$editDone = false;
		if ( $allowedConfig ) {
			if ( $hasSelf )
				$editCore = $editMsg . Linker::linkKnown( $configTitle, $this->msg( 'configure-edit-core' )->escaped(), array(), array( 'version' => $ts ) );
			elseif( $allowedConfigAll )
				$editCore = $editMsg . $this->msg( 'configure-edit-core' )->escaped();
			else
				$editCore = $editMsg;

			if ( $allowedConfigAll ) {
				$viewWikis = array();
				foreach ( $wikis as $wiki ) {
					$viewWikis[] = Linker::linkKnown( $configTitle, htmlspecialchars( $wiki ), array(), array( 'version' => $ts, 'wiki' => $wiki ) );
				}
				$editCore .= ' (' . $lang->commaList( $viewWikis ) . ')';
			}
			$actions[] = $editCore;
		}
		if ( $allowedExtensions ) {
			$editExt = '';
			if ( !$allowedConfig )
				$editExt .= $editMsg;
			if ( $hasSelf )
				$editExt .= Linker::linkKnown( $extTitle, $this->msg( 'configure-edit-ext' )->escaped(), array(), array( 'version' => $ts ) );
			elseif( $allowedExtensionsAll )
				$editExt .= $this->msg( 'configure-edit-ext' )->escaped();

			if ( $allowedExtensionsAll ) {
				$viewWikis = array();
				foreach ( $wikis as $wiki ) {
					$viewWikis[] = Linker::linkKnown( $extTitle, htmlspecialchars( $wiki ), array(), array( 'version' => $ts, 'wiki' => $wiki ) );
				}
				$editExt .= ' (' . $lang->commaList( $viewWikis ) . ')';
			}
			$actions[] = $editExt;
		}
		if ( $showDiff ) {
			$diffCheck = $c == 2 ? array( 'checked' => 'checked' ) : array();
			$versionCheck = $c == 1 ? array( 'checked' => 'checked' ) : array();
			$buttons =
				Xml::element( 'input', array_merge(
					array( 'type' => 'radio', 'name' => 'diff', 'value' => $ts ),
					$diffCheck ) ) .
				Xml::element( 'input', array_merge(
					array( 'type' => 'radio', 'name' => 'version', 'value' => $ts ),
					$versionCheck ) );

			$actions[] = Linker::link( $this->getTitle(), $this->msg( 'configure-viewconfig-default-diff' )->escaped(),
				array(), array( 'version' => $ts, 'diff' => 'default' ) );
		} else {
			$buttons = '';
		}

		$comment = $arr['reason'] ? Linker::commentBlock( $arr['reason'] ) : '';

		$action = $lang->commaList( $actions );

		$msg = $this->msg( 'configure-viewconfig-line' )->rawParams( $buttons )->params(
			$datime )->rawParams( $userLink, $action, $comment )->params( $date, $time, $username )->parse();
		return Xml::tags( 'li', null, $msg )."\n";
	}

	/**
	 * Get a form to select the wiki to configure
	 */
	protected function getWikiSelectForm() {
		global $wgConfigureWikis, $wgScript;
		if ( $wgConfigureWikis === false || !$this->isUserAllowedInterwiki() )
			return '';
		$form = '<fieldset><legend>' . $this->msg( 'configure-select-wiki' )->escaped() . '</legend>';
		$form .= $this->msg( 'configure-select-wiki-view-desc' )->parseAsBlock();
		$form .= Xml::openElement( 'form', array( 'method' => 'get', 'action' => $wgScript ) );
		$form .= Html::Hidden( 'title', $this->getTitle()->getPrefixedDBkey() );
		$all = ( $this->getRequest()->getVal( 'view', 'all' ) == 'all' );
		$form .= Xml::radioLabel( $this->msg( 'configure-select-wiki-view-all' )->text(), 'view', 'all', 'wiki-all', $all );
		$form .= "<br />\n";
		$form .= Xml::radioLabel( $this->msg( 'configure-select-wiki-view-specific' )->text(), 'view', 'specific', 'wiki-specific', !$all ) . ' ';

		if ( is_array( $wgConfigureWikis ) ) {
			$selector = new XmlSelect( 'wiki', 'wiki', $this->mWiki );
			foreach( $wgConfigureWikis as $wiki ) {
				$selector->addOption( $wiki );
			}
			$form .= $selector->getHTML() . "<br />";
		} else {
			$form .= Xml::input( 'wiki', false, $this->mWiki )."<br />";
		}

		$form .= Xml::submitButton( $this->msg( 'configure-select-wiki-submit' )->text() );
		$form .= '</form></fieldset>';
		return $form;
	}

	/**
	 * Taken from PageHistory.php
	 */
	protected function getButton() {
		return Xml::submitButton( $this->msg( 'compareselectedversions' )->text(),
				array(
					'class'     => 'historysubmit',
					'accesskey' => $this->msg( 'accesskey-compareselectedversions' )->text(),
					'title'     => $this->msg( 'tooltip-compareselectedversions' )->text(),
					)
				);
	}

	/**
	 * Build the content of the form
	 *
	 * @return xhtml
	 */
	protected function buildAllSettings() {
		$opt = array(
			'restrict' => false,
			'showlink' => array( '_default' => true, 'mw-extensions' => false ),
		);
		return $this->buildSettings( $this->getSettings(), $opt );
	}
}
