<?php
/*
 * @author Kamil Koterba
 * Helper functions for extension hook
 */

class EmailTemplatesHooksHelper {

	public function onComposeCommonBodyMail($title, &$keys, &$body, $editor, &$bodyHTML, &$postTransformKeys ) {
		$app = F::app();
		if ( array_key_exists( '$ACTION', $keys) ) {
			$action = $keys['$ACTION'];

			/* modify bodyHTML for blogpost action */
			if ( $action == 'blogpost' ) {

				$msgContentHTML = wfMsgHTMLwithLanguageAndAlternative(
					'enotif_body' . ( $action == '' ? '' : ( '_' . $action ) ),
					'enotif_body',
					$app->wg->LanguageCode
				);

				$msgSubject = wfMsgForContent(
					'enotif_subject_blogpost'
				);

				$params = array(
					'language' => $app->wg->LanguageCode,
					'greeting' => 'Hi, $WATCHINGUSERNAME',
					'content' => $msgContentHTML[1],
					'link' => $title->getFullURL(),
					'link_txt' => 'Read the new post'//create new message for that
				);
				$bodyHTML = $app->renderView( "EmailTemplates", "NewBlogPostMail", $params );
				return true;

			}

		}

		/* Default template may be put here */


		return true;
	}

}