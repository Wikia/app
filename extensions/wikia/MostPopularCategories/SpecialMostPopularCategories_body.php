<?php

class MostpopularcategoriesSpecialPage extends SpecialPage {
    private $mpc = null;

	function __construct() {
		self::load_messages();
		parent::__construct( 'Mostpopularcategories' );
	}

	function load_messages() {
		require_once( dirname(__FILE__).'/SpecialMostPopularCategories.i18n.php' );
		global $wgMessageCache, $wgMostPopularCategoriesMessages;

		foreach( $wgMostPopularCategoriesMessages as $lang => $messages ) {
			$wgMessageCache->addMessages( $messages, $lang );
		}
		return true;
    }

	function execute($limit = "", $offset = "", $show = true) {
		if (empty($limit) && empty($offset)) {
			list( $limit, $offset ) = wfCheckLimits();
		}
		$this->mpc = new MostpopularcategoriesPage($show);
		if (!empty($show)) {
			$this->setHeaders();
		} else {
			// return data as array - not like <LI> list
			$this->mpc->setListoutput(TRUE);
		}
		$this->mpc->doQuery( $offset, $limit, $show );
    }

    function getResult() {
		return $this->mpc->getResult();
    }
}

class MostpopularcategoriesPage extends QueryPage {

	var $data = array();
    var $show = false;

    function __construct($show = false) { $this->show = $show; }

	function getName() { return 'Mostpopularcategories'; }
	function isExpensive() { return true; }
	function isSyndicated() { return false; }

	function getSQL() {
		$dbr = wfGetDB( DB_SLAVE );
		list( $categorylinks ) = $dbr->tableNamesN( 'categorylinks' );

		$filterWords = array('Image', 'images', 'Stub', 'stubs', 'Screenshot', 'screenshots', 'Screencap','screencaps', 'Article', 'articles', 'Copy_edit', 'Fair_use', 'File', 'files', 'Panel', 'panels', 'Redirect', 'redirects', 'Template', 'templates', 'Delete', 'deletion', 'TagSynced');
		$filterWordsA = array();
		foreach($filterWords as $word) {
			$filterWordsA[] = '(cl_to not like "%'.$word.'%")';
        }
		$where = count($filterWordsA) > 0 ? "WHERE (".implode(' AND ', $filterWordsA).")" : "";

		$sql = "SELECT 'Mostpopularcategories' as type, 0 as namespace, cl_to as title, COUNT(*) as value FROM $categorylinks USE KEY (`cl_sortkey`) $where GROUP BY 3";

		return $sql;
	}

	function sortDescending() {
		return true;
    }

	function formatResult( $skin, $result ) {
		if (empty($this->show)) {
			$this->data[$result->title] = $result->value;
			return false;
	        } else {
        	        $title = Title::makeTitle( NS_CATEGORY, $result->title );
	                $titleText = $skin->makeLinkObj( $title, htmlspecialchars( $title->getText() ) );

			return wfSpecialList( $titleText, $result->value );
		}
	}

	public function getResult() {
		return $this->data;
    }
}
