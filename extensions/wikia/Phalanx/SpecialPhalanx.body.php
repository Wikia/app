<?php

class SpecialPhalanx extends SpecialPage {

	var $mDefaultExpire;

	function __construct() {
		wfLoadExtensionMessages('Phalanx');
		$this->mDefaultExpire = '1 year';
		parent::__construct('Phalanx', 'phalanx' /* restrictions */, true /* listed */);
	}

	function execute( $par ) {
		wfProfileIn(__METHOD__);
		global $wgOut, $wgRequest, $wgExtensionsPath, $wgStyleVersion, $wgStylePath;
		global $wgPhalanxSupportedLanguages, $wgUser;

		// check restrictions
		if ( !$this->userCanExecute( $wgUser ) ) {
			$this->displayRestrictionError();
			return;
		}

		$this->setHeaders();
		$wgOut->addStyle( "$wgExtensionsPath/wikia/Phalanx/css/Phalanx.css?$wgStyleVersion" );
		$wgOut->addScript("<script type='text/javascript' src='$wgExtensionsPath/wikia/Phalanx/js/Phalanx.js?$wgStyleVersion'></script>\n");
		$wgOut->addExtensionStyle("{$wgStylePath}/common/wikia_ui/tabs.css?{$wgStyleVersion}");

		$template = new EasyTemplate(dirname(__FILE__).'/templates');

		$pager = new PhalanxPager();

                $listing = $pager->getNavigationBar();
                $listing .= $pager->getBody();
                $listing .= $pager->getNavigationBar();

		// todo fill that with meaningful data taken from parameters
		$template->set_vars(array(
			'expiries' => Phalanx::getExpireValues(),
			'default_expire' => $this->mDefaultExpire,
			'languages' => $wgPhalanxSupportedLanguages,
			'listing' => $listing
		));

		$wgOut->addHTML($template->render('phalanx'));

		wfProfileOut(__METHOD__);
	}

}

class PhalanxPager extends ReverseChronologicalPager {
        public function __construct() {
                global $wgExternalSharedDB, $wgRequest;

                parent::__construct();
                $this->mDb = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );

		$this->mSearchText = $wgRequest->getText( 'wpPhalanxCheckBlocker', null );
		$this->mSearchType = $wgRequest->getInt( 'typesearch', null );
	}

        function getQueryInfo() {
                $query['tables'] = 'phalanx';
                $query['fields'] = '*';

		if ( !empty( $this->mSearchText ) ) {
			$query['conds'][] = '(p_text like "%' . $this->mDb->escapeLike( $this->mSearchText ) . '%")';
		}

		if ( !empty( $this->mSearchType ) ) {
			$query['conds'][] = "p_type = {$this->mSearchType}";
		}

                return $query;
        }

        function getIndexField() {
                return 'p_timestamp';
        }

        function getStartBody() {
                return '<ul>';
        }

        function getEndBody() {
                return '</ul>';
        }

        function formatRow( $row ) {
                global $wgLang;

		$author = User::newFromId( $row->p_author_id );
		$authorName = $author->getName();
		$authorUrl = $author->getUserPage()->getFullUrl();

		$phalanxUrl = Title::newFromText( 'Phalanx', NS_SPECIAL )->getFullUrl( array( 'id' => $row->p_id ) );
		$statsUrl = Title::newFromText( 'PhalanxStats', NS_SPECIAL )->getFullUrl() . '/' . $row->p_id;

                $html = '<li id="phalanx-block-' . $row->p_id . '">';

		$html .= '<b>' . htmlspecialchars( $row->p_text ) . '</b> (' ;
		$html .= $row->p_regex ? 'regex' : 'plain text';
		$html .= ') ';

		// control links
                $html .= " &bull; <a class='unblock' href='{$phalanxUrl}'>" . wfMsg('phalanx-link-unblock') . '</a>';
                $html .= " &bull; <a class='modify' href='{$phalanxUrl}'>" . wfMsg('phalanx-link-modify') . '</a>';
                $html .= " &bull; <a href='{$statsUrl}'>" . wfMsg('phalanx-link-stats') . '</a>';

		// types
		$html .= '<br /> blocks: ' . implode( ', ', Phalanx::getTypeNames( $row->p_type ) );

		$html .= ' &bull; created by <a href="' . $authorUrl . '">' . $authorName . '</a>';
		$html .= ' on ' . $wgLang->timeanddate( $row->p_timestamp );

                $html .= '</li>';

                return $html;
        }
}
