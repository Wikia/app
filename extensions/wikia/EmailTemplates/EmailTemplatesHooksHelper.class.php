<?php
/*
 * @author Kamil Koterba
 * Helper functions for extension hook
 */

class EmailTemplatesHooksHelper {

	public function onComposeCommonBodyMail($title, &$keys, &$body, $editor, &$bodyHTML, &$postTransformKeys ) {
		global $wgLanguageCode;
		$app = F::app();
var_dump('onComposeCommonBodyMail');
		if ( array_key_exists( '$ACTION', $keys) ) {
			$action = $keys['$ACTION'];

			/* modify bodyHTML for blogpost action */
			if ( $action == 'blogpost' ) {

				var_dump('onComposeCommonBodyMail blogpost');
				$msgContentHTML = wfMsgHTMLwithLanguageAndAlternative(
					'enotif_body' . ( $action == '' ? '' : ( '_' . $action ) ),
					'enotif_body',
					$wgLanguageCode
				);
				var_dump('msgContentHTML');
				var_dump($msgContentHTML);
				$params = array(
					'language' => $wgLanguageCode,
					'greeting' => 'Hi, $WATCHINGUSERNAME',
					'content' => $msgContentHTML[1],
					'link' => $title->getFullURL(),
					'link_txt' => 'Read the new post'//create new message for that
				);

				$bodyHTML = $app->renderView( "EmailTemplates", "NewBlogPostMail", $params );
				$bodyHTML .= 'FRAnk test';

			}
		}
		return true;
	}

}