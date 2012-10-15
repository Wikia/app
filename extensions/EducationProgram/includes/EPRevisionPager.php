<?php

/**
 * History pager.
 *
 * @since 0.1
 *
 * @file EPRevisionPager.php
 * @ingroup EducationProgram
 *
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class EPRevisionPager extends ReverseChronologicalPager {

	/**
	 * Context in which this pager is being shown.
	 * @since 0.1
	 * @var IContextSource
	 */
	protected $context;

	/**
	 * Constructor.
	 *
	 * @param IContextSource $context
	 * @param string $className
	 * @param array $conds
	 */
	public function __construct( IContextSource $context, array $conds = array() ) {
		$this->conds = $conds;
		$this->context = $context;

		$this->mDefaultDirection = true;

		if ( method_exists( 'ReverseChronologicalPager', 'getUser' ) ) {
			parent::__construct( $context );
		}
		else {
			parent::__construct();
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
		return $this->context->getOutput();
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
		return $this->context->getLanguage();
	}

	/**
	 * Get the User being used for this instance.
	 * IndexPager extends ContextSource as of 1.19.
	 *
	 * @since 0.1
	 *
	 * @return User
	 */
	public function getUser() {
		return $this->context->getUser();
	}

	/**
	 * Get the WebRequest being used for this instance.
	 * IndexPager extends ContextSource as of 1.19.
	 *
	 * @since 0.1
	 *
	 * @return WebRequest
	 */
	public function getRequest() {
		return $this->context->getRequest();
	}

	/**
	 * Get the Title being used for this instance.
	 * IndexPager extends ContextSource as of 1.19.
	 *
	 * @since 0.1
	 *
	 * @return Title
	 */
	public function getTitle() {
		return $this->context->getTitle();
	}

	/**
	 * @see parent::getStartBody
	 * @since 0.1
	 */
	function getStartBody() {
		return '<ul>';
	}

	/**
	 * Abstract formatting function. This should return an HTML string
	 * representing the result row $row. Rows will be concatenated and
	 * returned by getBody()
	 *
	 * @param $row Object: database row
	 *
	 * @return String
	 */
	function formatRow( $row ) {
		$revision = EPRevision::newFromDBResult( $row );
		$object = $revision->getObject();

		$html = '';

		$html .= $object->getLink(
			'view',
			$this->getLanguage()->timeanddate( $revision->getField( 'time' ) ),
			array(),
			array( 'revid' => $revision->getId() )
		);

		$html .= '&#160;&#160;';

		$html .= Linker::userLink( $revision->getUser()->getId(), $revision->getUser()->getName() )
			. Linker::userToolLinks( $revision->getUser()->getId(), $revision->getUser()->getName() );

		if ( $revision->getField( 'minor_edit' ) ) {
			$html .= '&#160;&#160;';
			$html .= '<b>' . wfMsgHtml( 'minoreditletter' ) . '</b>';
		}

		if ( $revision->getField( 'comment' ) !== '' ) {
			$html .= '&#160;.&#160;.&#160;';

			$html .= Html::rawElement(
				'span',
				array(
					'dir' => 'auto',
					'class' => 'comment',
				),
				'(' . $this->getOutput()->parseInline( $revision->getField( 'comment' ) ) . ')'
			);
		}

		return '<li>' . $html . '</li>';
	}

	/**
	 * @see parent::getEndBody
	 * @since 0.1
	 */
	function getEndBody() {
		return '</ul>';
	}

	/**
	 * This function should be overridden to provide all parameters
	 * needed for the main paged query. It returns an associative
	 * array with the following elements:
	 *	tables => Table(s) for passing to Database::select()
	 *	fields => Field(s) for passing to Database::select(), may be *
	 *	conds => WHERE conditions
	 *	options => option array
	 *	join_conds => JOIN conditions
	 *
	 * @return Array
	 */
	function getQueryInfo() {
		return array(
			'tables' => EPRevision::getDBTable(),
			'fields' => EPRevision::getPrefixedFields( EPRevision::getFieldNames() ),
			'conds' => EPRevision::getPrefixedValues( $this->conds )
		);
	}

	/**
	 * This function should be overridden to return the name of the index fi-
	 * eld.  If the pager supports multiple orders, it may return an array of
	 * 'querykey' => 'indexfield' pairs, so that a request with &count=querykey
	 * will use indexfield to sort.  In this case, the first returned key is
	 * the default.
	 *
	 * Needless to say, it's really not a good idea to use a non-unique index
	 * for this!  That won't page right.
	 *
	 * @return string|Array
	 */
	function getIndexField() {
		return EPRevision::getPrefixedField( 'id' );
	}


}
