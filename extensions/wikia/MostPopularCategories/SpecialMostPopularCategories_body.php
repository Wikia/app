<?php

class MostpopularcategoriesSpecialPage extends SpecialPage {
    private $mpc = null;
	private $showList = true;
	private $page = '';

	function __construct( $page = 'Mostpopularcategories' ) {
		$this->page = $page;
		parent::__construct( $this->page, '' );
	}

	function setList( $showList = false ) { $this->showList = $showList; }

	function execute( $par = '' ) {
		$this->mpc = new MostpopularcategoriesPage( $this->page );
		$this->mpc->setVisible( $this->showList );
		if (!empty($this->showList)) {
			$this->setHeaders();
		} else {
			// return data as array - not like <LI> list
			$this->mpc->setListoutput(TRUE);
		}
		$this->mpc->execute( '' );
    }

    function getResult() {
		return $this->mpc->getResult();
    }
}

class MostpopularcategoriesPage extends QueryPage {

	var $data = array();
    var $show = true;

    function __construct( $name = '' ) {
		parent::__construct( $name, '' );
	}

	function setVisible( $show ) { $this->show = $show; }
	function getName() { return 'Mostpopularcategories'; }
	function isExpensive() { return true; }
	function isSyndicated() { return false; }

	function getQueryInfo() {
		$filterWords = array('Image', 'images', 'Stub', 'stubs', 'Screenshot', 'screenshots', 'Screencap','screencaps', 'Article', 'articles', 'Copy_edit', 'Fair_use', 'File', 'files', 'Panel', 'panels', 'Redirect', 'redirects', 'Template', 'templates', 'Delete', 'deletion', 'TagSynced');
		$filterWordsA = array();
		foreach($filterWords as $word) {
			$filterWordsA[] = '(cl_to not like "%'.$word.'%")';
        }

		return array (
			'tables' => array ( 'categorylinks' ),
			'fields' => array (
				"'Mostpopularcategories' as type",
				'0 as namespace',
				'cl_to as title',
				'COUNT(*) as value'
			),
			'conds' => $filterWordsA,
			'options' => array (
				'GROUP BY' => 'cl_to'
			)
		);
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
			if ($title instanceof Title) {
				$titleText = $skin->makeLinkObj( $title, htmlspecialchars( $title->getText() ) );
				return wfSpecialList( $titleText, $result->value );
			} else {
				return false;
			}
		}
	}

	public function getResult() {
		return $this->data;
    }
}
