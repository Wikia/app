<?php
class UserProfilePageHelper {

	/**
	 * SkinTemplateOutputPageBeforeExec hook
	 */
	static public function onSkinTemplateOutputPageBeforeExec( $skin, $template ) {
		global $wgRequest;
		wfProfileIn(__METHOD__);

		//wfLoadExtensionMessages('MyHome');

		// Return without any changes if this isn't in the user namespace OR
		// if the user is doing something besides viewing or purging this page
		$action = $wgRequest->getVal('action', 'view');
		if ($skin->mTitle->getNamespace() != NS_USER || ($action != 'view' && $action != 'purge')) {
			return true;
		}

		$user = User::newFromName( $skin->mTitle->getDBKey() );

		// sanity check
		if ( !is_object( $user ) ) {
			return true;
		}
		$user->load();

		$profilePage = new UserProfilePage( $user );
		$template->data['bodytext'] = $profilePage->get( $template->data['bodytext'] );

		wfProfileOut(__METHOD__);
		return true;
	}

	public static function doAction() {
		global $wgUser, $wgRequest;

		$result = array(
			'result' => true
		);

		$name = $wgRequest->getVal( 'name' );
		$type = $wgRequest->getVal( 'type' );
		$value = $wgRequest->getVal( 'value' );

		if( is_object( $wgUser ) && $wgUser->getId() && !empty( $name ) && !empty( $type ) && !empty( $value ) ) {
			$profilePage = new UserProfilePage( $wgUser );
			$result['type'] = $type;
			$result['html'] = $profilePage->doAction( $name, $type, $value );
		}

		$json = Wikia::json_encode( $result );
		$response = new AjaxResponse( $json );
		$response->setContentType( 'application/json; charset=utf-8' );

		return $response;
	}
}