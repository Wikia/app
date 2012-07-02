<?php

class ApiGetMarkAsHelpfulItem extends ApiBase {

	public function execute() {
		global $wgUser;

		$params = $this->extractRequestParams();

		$page = Title::newFromText( $params['page'] );

		if ( !$page ) {
			throw new MWApiGetMarkAsHelpfulItemInvalidPageException( 'Invalid page!' );
		}

		// check if current user has permission to mark the item,
		$isAbleToMark = false; 
		// check if the page has permission to request the item
		$isAbleToShow = false;

		wfRunHooks( 'onMarkItemAsHelpful', array( $params['type'], $params['item'], $wgUser, &$isAbleToMark, $page, &$isAbleToShow ) );

		if ( $isAbleToShow ) {
			$HelpfulUserList = MarkAsHelpfulItem::getMarkAsHelpfulList( $params['type'], $params['item'] );

			if ( $params['prop'] == 'metadata') {
				$data = $HelpfulUserList;
				$format = 'metadata';
			} else {
				$data = MarkAsHelpfulUtil::getMarkAsHelpfulTemplate(
					$wgUser, $isAbleToMark, $HelpfulUserList, $params['type'],
					$params['item']
				);
				$format = 'formatted';
			}
		}
		else {
			$data = '';

			if ( $params['prop'] == 'metadata') {
				$format = 'metadata';
			} else {
				$format = 'formatted';
			}	
		}

		$result = array( 'result' => 'success', $format => $data );
		$this->getResult()->addValue( null, $this->getModuleName(), $result );
	}

	public function getAllowedParams() {
		global $wgMarkAsHelpfulType;

		return array(
			'type' => array(
				ApiBase::PARAM_REQUIRED => true,
				ApiBase::PARAM_TYPE => $wgMarkAsHelpfulType,
			),
			'item' => array(
				ApiBase::PARAM_REQUIRED => true,
				ApiBase::PARAM_TYPE => 'integer'
			),
			'prop' => array(
				ApiBase::PARAM_TYPE => array( 'metadata', 'formatted' ),
			),
			'page' => array(
				ApiBase::PARAM_REQUIRED => true,
			),
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiGetMarkAsHelpfulItem.php 107587 2011-12-29 19:08:57Z bsitu $';
	}

	public function getParamDescription() {
		return array(
			'type' => 'The object type that is being marked as helpful',
			'item' => 'The object item that is being marked as helpful',
			'prop' => 'Which property to get',
			'page' => 'The page which is requesting the item',
		);
	}

	public function getDescription() {
		return 'Get a list of all helpful status for an object item';
	}

}

class MWApiGetMarkAsHelpfulItemInvalidPageException extends MWException {}