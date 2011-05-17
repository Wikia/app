<?php

abstract class WikiaLabsHelper {

	public static function getProjectModal() {
		$request = WF::build( 'App' )->getGlobal( 'wgRequest' );

		$id = $request->getVal('id');
		$wikiaLabs = WF::build( 'WikiaLabs' );
		$response =  WF::build( 'AjaxResponse' );
		$result = $wikiaLabs->getProjectModal( (int) $request->getVal('id', 0) );
		$response->addText( $result );

		return $response;
	}

	public static function saveProject() {
		$request = WF::build( 'App' )->getGlobal( 'wgRequest' );
		$response = new AjaxResponse();

		$wikiaLabs = WF::build( 'WikiaLabs' );
		$out = $wikiaLabs->saveProject( $request->getArray( 'project' ) );
		$response->addText( json_encode( $out ) );

		return $response;
	}

	public static function getImageUrlForEdit() {
		$request = WF::build( 'App' )->getGlobal( 'wgRequest' );
		$name = $request->getVal( 'name', '' );

		$wikiaLabs = WF::build( 'WikiaLabs' );
		$response = new AjaxResponse();
		$response->addText( json_encode( $wikiaLabs->getImageUrlForEdit( $name ) ) );

		return $response;
	}

	public static function switchProject() {
		$app = WF::build( 'App' );
		$request = $app->getGlobal( 'wgRequest' );

		$wikiaLabs = WF::build( 'WikiaLabs');
		$result = $wikiaLabs->switchProject( $app->getGlobal( 'wgCityId' ), $request->getVal( 'id' ), $request->getVal( 'onoff' ) ) ? "ok" : "error";
		$response = new AjaxResponse();
		$response->addText( json_encode( array( 'status' => $result ) ) );

		return $response;
	}

	public static function saveFeedback() {
		$app = WF::build( 'App' );
		$request = $app->getGlobal( 'wgRequest' );
		$user = $app->getGlobal( 'wgUser' );
		$wikiaLabs = WF::build( 'WikiaLabs' );
		
		$response = new AjaxResponse();
		$result =  $wikiaLabs->saveFeedback( $request->getVal('projectId', 0), $user, $request->getVal('rating', 0), $request->getVal('feedbacktext') );
		$response->addText( json_encode( $result ) );

		return $response;
	}
}