<?php

class MostpopulararticlesSpecialPage extends SpecialPage {
	private $mpa = null;

	function __construct() {
		self::load_messages();
		parent::__construct( 'Mostpopulararticles' );
	}

	function load_messages() {
		require_once( dirname(__FILE__).'/SpecialMostPopularArticles.i18n.php' );
		global $wgMessageCache, $wgMostPopularArticlesMessages;

		foreach( $wgMostPopularArticlesMessages as $lang => $messages ) {
			$wgMessageCache->addMessages( $messages, $lang );
		}
		return true;
    }

	function execute($limit = "", $offset = "", $show = true) {
		if (empty($limit) && empty($offset)) {
			list( $limit, $offset ) = wfCheckLimits();
		}
		$this->mpa = new MostpopulararticlesPage($show);

		if (!empty($show)) {
			$this->setHeaders();
		} else {
			// return data as array - not like <LI> list
			$this->mpa->setListoutput(TRUE);
		}
		$this->mpa->doQuery( $offset, $limit, $show );
	}

    function getResult() {
		return $this->mpa->getResult();
    }
}

class MostpopulararticlesPage extends QueryPage {
	var $data = array();
	var $show = false;

	function __construct($show = false) { $this->show = $show; }

	function getName() { return 'Mostpopulararticles'; }
	function isExpensive() { return true; }
	function isSyndicated() { return false; }

	function getSQL() {
		global $wgContentNamespaces;

		$dbr = wfGetDB( DB_SLAVE );
		list( $page, $revision ) = $dbr->tableNamesN( 'page', 'revision' );

		# Get all content (aka article) pages
		$where = " where page_namespace in (" . implode( ",", $wgContentNamespaces ) . ") ";

		$sql = "SELECT 'Mostpopulararticles' as type,page_namespace as namespace,page_title as title,
		(select count(*) from $revision where rev_page = page_id) as value FROM $page $where";

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
			$title = Title::makeTitle( $result->namespace, $result->title );
			$titleText = $skin->makeLinkObj( $title, htmlspecialchars( $title->getPrefixedtext() ) ); 

			return wfSpecialList( $titleText, $result->value );
		}
	}

	public function getResult() {
		return $this->data;
    }
}
