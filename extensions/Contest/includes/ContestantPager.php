<?php

/**
 * Contestant pager, for on Special:Contest
 *
 * @since 0.1
 *
 * @file ContestantPager.php
 * @ingroup Contest
 *
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ContestantPager extends TablePager {

	/**
	 * Query conditions, full field names (ie inc prefix).
	 * @var array
	 */
	protected $conds;

	/**
	 * Special page on which the pager is displayed.
	 * @var SpecialContestPage
	 */
	protected $page;

	/**
	 * Cache for challenge titles.
	 * challenge id => challenge title
	 * @var array
	 */
	protected $challengeTitles = array();

	/**
	 * Constructor.
	 *
	 * @param SpecialContestPage $page
	 * @param array $conds
	 */
	public function __construct( SpecialContestPage $page, array $conds ) {
		$this->page = $page;
		$this->conds = $conds;
		$this->mDefaultDirection = true;

		$this->queryChallengeTitles( $conds );

		// when MW 1.19 becomes min, we want to pass an IContextSource $context here.
		parent::__construct();
	}

	/**
	 * Query all challenge names we might need,
	 * based on the queries conditions, and set them
	 * to the challengeTitles field.
	 *
	 * @since 0.1
	 *
	 * @param array $allConds
	 */
	protected function queryChallengeTitles( array $allConds ) {
		$conds = array();

		if ( array_key_exists( 'contestant_contest_id', $allConds ) ) {
			$conds['contest_id'] = $allConds['contestant_contest_id'];
		}

		if ( array_key_exists( 'contestant_challenge_id', $allConds ) ) {
			$conds['id'] = $allConds['contestant_challenge_id'];
		}

		foreach ( ContestChallenge::s()->select( array( 'id', 'title' ), $conds ) as /* ContestChallenge */ $challenge ) {
			$this->challengeTitles[$challenge->getId()] = $challenge->getField( 'title' );
		}
	}

	/**
	 * Gets the title of a challenge given it's id.
	 *
	 * @since 0.1
	 *
	 * @param integer $challengeId
	 * @throws MWException
	 */
	protected function getChallengeTitle( $challengeId ) {
		if ( array_key_exists( $challengeId, $this->challengeTitles ) ) {
			return $this->challengeTitles[$challengeId];
		}
		else {
			throw new MWException( 'Attempt to get non-set challenge title' );
		}
	}

	/**
	 * Get the OutputPage being used for this instance.
	 * IndexPager extends ContextSource as of 1.19.
	 *
	 * @since 0.1
	 *
	 * @return OutputPage
	 */
	public function getOutput() {
		return version_compare( $GLOBALS['wgVersion'], '1.18', '>' ) ? parent::getOutput() : $GLOBALS['wgOut'];
	}

	/**
	 * Get the Language being used for this instance.
	 * IndexPager extends ContextSource as of 1.19.
	 *
	 * @since 0.1
	 *
	 * @return Language
	 */
	public function getLanguage() {
		return version_compare( $GLOBALS['wgVersion'], '1.18', '>' ) ? parent::getLanguage() : $GLOBALS['wgLang'];
	}

	/**
	 * @return array
	 */
	public function getFieldNames() {
		static $headers = null;

		if ( is_null( $headers ) ) {
			$headers = array(
				'contestant_id' => 'contest-contestant-id',
				'contestant_challenge_id' => 'contest-contestant-challenge-name',
				'contestant_volunteer' => 'contest-contestant-volunteer',
				'contestant_wmf' => 'contest-contestant-wmf',
				'contestant_comments' => 'contest-contestant-commentcount',
				'contestant_rating' => 'contest-contestant-overallrating',
				'contestant_submission' => 'contest-contestant-submission',
			);

			$headers = array_map( 'wfMsg', $headers );
		}

		return $headers;
	}

	/**
	 * @param $row
	 * @return string
	 */
	function formatRow( $row ) {
		$this->mCurrentRow = $row;  	# In case formatValue etc need to know
		$s = Xml::openElement( 'tr', $this->getRowAttrs($row) );

		foreach ( $this->getFieldNames() as $field => $name ) {
			$value = isset( $row->$field ) ? $row->$field : null;
			$formatted = strval( $this->formatValue( $field, $value ) );

			if ( $formatted == '' ) {
				$formatted = '&#160;';
			}
			$s .= Xml::tags( 'td', $this->getCellAttrs( $field, $value ), $formatted );
		}
		$s .= "</tr>\n";

		return $s;
	}

	/**
	 * @param $row
	 * @return array
	 */
	function getRowAttrs( $row ) {
		return array_merge(
			parent::getRowAttrs( $row ),
			array( 'data-contestant-target' => SpecialPage::getTitleFor( 'Contestant', $row->contestant_id )->getLocalURL() )
		);
	}

	/**
	 * @param $row
	 * @return string
	 */
	function getRowClass( $row ) {
		return 'contestant-row';
	}

	/**
	 * @param $name
	 * @param $value
	 * @return string
	 */
	public function formatValue( $name, $value ) {
		switch ( $name ) {
			case 'contestant_id':
				$value = Html::element(
					'a',
					array(
						'href' => SpecialPage::getTitleFor( 'Contestant', $value )->getLocalURL()
					),
					$value
				);
				break;
			case 'contestant_challenge_id':
				$value = /*Html::element(
					'a',
					array(
						'href' =>
							SpecialPage::getTitleFor(
								'Contest',
								$this->page->subPage . '/' . $this->getChallengeTitle( $value )
							)->getLocalURL()
					),
					*/$this->getChallengeTitle( $value );
				//);
				break;
			case 'contestant_volunteer': case 'contestant_wmf':
				// contest-contestant-yes, contest-contestant-no
				$value = htmlspecialchars( wfMsg( 'contest-contestant-' . ( $value === '1' ? 'yes' : 'no' ) ) );
				break;
			case 'contestant_comments':
				$value = htmlspecialchars( $this->getLanguage()->formatNum( $value ) );
				break;
			case 'contestant_rating':
				$value = '<div style="white-space:nowrap;">' . htmlspecialchars( wfMsgExt(
					'contest-contestant-rating',
					'parsemag',
					$this->getLanguage()->formatNum( $value / 100 ),
					$this->getLanguage()->formatNum( $this->mCurrentRow->contestant_rating_count )
				) ) . '</div>';
				break;
			case 'contestant_submission':
				$value = Html::element(
					'a',
					array(
						'href' => $value
					),
					$value
				);
				break;
		}

		return $value;
	}

	function getQueryInfo() {
		$info = array(
			'tables' => array( 'contest_contestants' ),
			'fields' => array(
				'contestant_id',
				'contestant_challenge_id',
				'contestant_volunteer',
				'contestant_wmf',
				'contestant_comments',
				'contestant_rating',
				'contestant_rating_count',
				'contestant_submission',
			),
			'conds' => $this->conds,
		);

		return $info;
	}

	public function getTableClass(){
		return 'TablePager contest-contestants';
	}

	function getDefaultSort() {
		return 'contestant_id';
	}

	function isFieldSortable( $name ) {
		return in_array(
			$name,
			array(
				'contestant_id',
				'contestant_challenge_id',
				'contestant_volunteer',
				'contestant_wmf',
				'contestant_comments',
				'contestant_rating',
			)
		);
	}

	/**
	 * @return Title
	 */
	function getTitle() {
		return $this->page->getFullTitle();
	}

}
