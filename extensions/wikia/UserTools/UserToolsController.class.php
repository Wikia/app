<?php

class UserToolsController extends WikiaController {

	static protected $toolbarService = null;

	public function Toolbar() {
		$service = $this->getToolbarService();
		$toolbar = $service->listToInstance( $service->getVisibleList() );
		$this->response->setVal( 'toolbar', $service->instanceToRenderData( $toolbar ) );
	}

	public function executeToolbarSave( $params ) {
		$status = false;
		if ( $this->request->wasPosted()
			&& $this->wg->User->matchEditToken( $this->request->getVal( 'token' ) )
		) {
			$service = $this->getToolbarService();
			if ( isset( $params['toolbar'] ) && is_array( $params['toolbar'] ) ) {
				$data = $service->jsonToList( $params['toolbar'] );
				if ( !empty( $data ) ) {
					$status = $service->save( $data );
				}
			}
		}
		$this->response->setVal( 'status', $status );
		$this->response->setVal( 'toolbar', F::app()->renderView( 'UserTools', 'Toolbar', array( 'format' => 'html' ) ) );
	}

	public function executeMenu( $params ) {
		$items = (array)$params['items'];
		$type = isset( $params['type'] ) ? $params['type'] : 'main';
		wfRunHooks( 'BeforeToolbarMenu', [ &$items, $type ] );
		$this->response->setVal( 'items', $items );
	}

	/**
	 * @return sharedToolbarService
	 */
	protected function getToolbarService() {
		if ( empty( self::$toolbarService ) ) {
			self::$toolbarService = new SharedToolbarService();
		}
		return self::$toolbarService;
	}

	public function ToolbarConfiguration() {
		$this->response->setVal(
			'configurationHtml',
			F::app()->renderView( 'UserTools', 'ToolbarConfigurationPopup', array( 'format' => 'html' ) )
		);
		$this->response->setVal(
			'renameItemHtml',
			F::app()->renderView( 'UserTools', 'ToolbarConfigurationRenameItemPopup', array( 'format' => 'html' ) )
		);

		$service = $this->getToolbarService();
		$this->response->setVal( 'defaultOptions', $service->listToJson( $service->getDefaultList() ) );
		$this->response->setVal( 'options', $service->listToJson( $service->getCurrentList() ) );
		$this->response->setVal( 'allOptions', $service->sortJsonByCaption( $service->listToJson( $service->getAllList() ) ) );
		$this->response->setVal( 'popularOptions', $service->sortJsonByCaption( $service->listToJson( $service->getPopularList() ) ) );
		$this->response->setVal( 'messages', [
			'user-tools-edit-title' => wfMessage( 'user-tools-edit-title' )->text(),
			'user-tools-edit-rename-item' => wfMessage( 'user-tools-edit-rename-item' )->text(),
			'user-tools-edit-save' => wfMessage( 'user-tools-edit-save' )->text(),
			'user-tools-edit-cancel' => wfMessage( 'user-tools-edit-cancel' )->text(),
		] );
	}

	//Method used in SpecialPageUserCommand class
	public function executeToolbarGetList() {
		$service = $this->getToolbarService();
		$this->allOptions = $service->listToJson($service->getAllList());
	}

	public function ToolbarConfigurationPopup() {
		// Method stub
	}

	public function ToolbarConfigurationRenameItemPopup() {
		// Method stub
	}

}
