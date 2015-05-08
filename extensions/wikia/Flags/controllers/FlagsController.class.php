<?php

use Flags\Models\Flag;
use Flags\Models\FlagType;

class FlagsController extends WikiaController {

	private
		$action,
		$model,
		$params,
		$status = false;

	public function getFlagsForPage() {
		$this->skipRendering();
		$this->getRequestParams();

		if ( !isset( $this->params['pageId'] ) ) {
			return null;
		}

		$this->model = new Flag();

		return $this->model->getFlagsForPage( $this->params['wikiId'], $this->params['pageId'] );
	}

	public function getFlag() {

	}

	public function flagAction() {
		$this->skipRendering();
		$this->getRequestParams();

		if ( !isset( $this->params['action'] ) ) {
			$this->setVal( 'status', false );
			return false;
		}
		$this->action = $this->params['action'];

		$this->model = new Flag();

		if ( $this->model->verifyParamsForAction( $this->action, $this->params ) ) {
			$this->status = $this->model->performAction( $this->action, $this->params );
		}

		$this->setVal( 'status', $this->status );
		return $this->status;
	}

	public function flagTypeAction() {
		$this->skipRendering();
		$this->getRequestParams();

		if ( !isset( $this->params['action'] ) ) {
			$this->setVal( 'status', false );
			return false;
		}

		$this->action = $this->params['action'];

		$this->model = new FlagType();

		if ( $this->model->verifyParamsForAction( $this->action, $this->params ) ) {
			$this->status = $this->model->performAction( $this->action, $this->params );
		}

		$this->setVal( 'status', $this->status );
		return $this->status;
	}

	private function getRequestParams() {
		$request = $this->getRequest();
		$this->params = $request->getParams();
		if ( !isset( $this->params['wikiId'] ) ) {
			$this->params['wikiId'] = $this->wg->CityId;
		}
	}
}