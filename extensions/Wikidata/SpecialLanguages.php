<?php
if (!defined('MEDIAWIKI')) die();
/**
 * A Special Page extension to add languages, runnable by users with the 'addlanguage' right.
 * @addtogroup Extensions
 *
 * @author Erik Moeller <Eloquence@gmail.com>
 * @license public domain
 */

$wgAvailableRights[] = 'addlanguage';
$wgGroupPermissions['bureaucrat']['addlanguage'] = true;

$wgExtensionFunctions[] = 'wfSpecialManageLanguages';
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Language manager',
	'author' => 'Erik Moeller',
);

require_once( 'SpecialLanguages.i18n.php' );

function wfSpecialManageLanguages() {
	# Add messages
	global $wgMessageCache, $wdMessages, $IP;
	foreach( $wdMessages as $language => $translations ) {
		$wgMessageCache->addMessages( $translations, $language );
	}
	require_once "$IP/includes/SpecialPage.php";

	class SpecialLanguages extends SpecialPage {
		function SpecialLanguages() {
			SpecialPage::SpecialPage( 'Languages' );
		}

		function execute( $par ) {
			global $wgOut, $wgRequest, $wgTitle, $wgUser;
			$wgOut->setPageTitle(wfMsg('langman_title'));
			if(!$wgUser->isAllowed('addlanguage')) {
				$wgOut->addHTML('You do not have permission to change language settings.');
				return false;
			}
			$action=$wgRequest->getText('action');
			if(!$action) {
				$wgOut->addWikiText('Type the language code and the English name below:');
			} else {
				$dbr=&wfGetDB(DB_MASTER);
				$langname=$wgRequest->getText('langname');
				$langiso6393=$wgRequest->getText('langiso6393');
				$langiso6392=$wgRequest->getText('langiso6392');
				$langwmf=$wgRequest->getText('langwmf');
				if(!$langname || !$langiso6393) {
					$wgOut->addHTML('Language name and ISO 639-3 code are required!');
				} else {
					$wgOut->addHTML('Adding language '.$langname.' with key '.$langiso6393.'.');
					$sql='INSERT INTO language(iso639_2,iso639_3,wikimedia_key) values('.$dbr->addQuotes($langiso6392).','.$dbr->addQuotes($langiso6393).','.$dbr->addQuotes($langwmf).')';

					$dbr->query($sql);
					$id=$dbr->insertId();
					$sql='INSERT INTO language_names(language_id,name_language_id,language_name) values ('.$id.',85,'.$dbr->addQuotes($langname).')';
					$dbr->query($sql);

				}

			}

			$this->showForm();


			# $wgRequest->getText( 'page' );
		}
		function showForm() {
			global $wgTitle, $wgOut;
			$action = $wgTitle->escapeLocalURL( 'action=submit' );
			$wgOut->addHTML(
<<<END
<form name="addlanguage" method="post" action="$action">
<table border="0">
<tr>
<td>
Language name
</td>
<td>
<input type="text" size="40" name="langname">
</td>
</tr>
<tr>
<td>
ISO 639-3 code (required)
</td>
<td>
<input type="text" size="8" name="langiso6393">
</td>
</tr>
<tr>
<td>
ISO 639-2 code (optional)
</td>
<td>
<input type="text" size="8" name="langiso6392">
</td>
</tr>
<tr>
<td>
Wikimedia code (optional)
</td>
<td>
<input type="text" size="4" name="langwmf">
</td>
</tr>
<tr><td>
<input type="submit" value="Add language">
</td></tr>
</table>
</form>
END
);
			return true;

		}
	}

	SpecialPage::addPage( new SpecialLanguages );
}
