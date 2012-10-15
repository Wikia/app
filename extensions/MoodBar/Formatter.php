<?php

/**
 * Set of utilities for formatting and processing MoodBar output.
 * @author Andrew Garrett
 */
abstract class MoodBarFormatter {
	/**
	 * Gets the viewer's representation of $field from $data.
	 * @param $data MBFeedbackItem to retrieve the data from.
	 * @param $field String name of the field to fill. Valid values in $this->fields
	 * @return String HTML for putting in the table.
	 */
	public static function getHTMLRepresentation( $data, $field ) {
		switch( $field ) {
			case 'page':
				$title = $data->getProperty('page');

				global $wgUser;
				$linker = $wgUser->getSkin();
				$outData = $linker->link( $title );
				break;
			case 'timestamp':
				global $wgLang;
				$outData = $wgLang->timeanddate( $data->getProperty('timestamp') );
				$outData = htmlspecialchars($outData);
				break;
			case 'type':
				$internal = self::getInternalRepresentation( $data, $field );
				$outData = wfMessage("moodbar-type-$internal")->params( $data->getProperty('user') )->parse();
				break;
			case 'usertype':
				$internal = self::getInternalRepresentation( $data, $field );
				$outData = wfMessage("moodbar-user-$internal")->parse();
				break;
			default:
				$outData = self::getInternalRepresentation($data, $field);
				$outData = htmlspecialchars( $outData );
				break;
		}

		return $outData;
	}

	/**
	 * Gets an internal representation of $field from $data.
	 * @param $data MBFeedbackItem to retrieve the data from.
	 * @param $field String name of the field to fill. Valid values in $this->fields
	 * @return String value appropriate for putting in CSV
	 */
	public static function getInternalRepresentation( $data, $field ) {
		$outData = null;

		switch( $field ) {
			case 'namespace':
				$page = $data->getProperty('page');
				$outData = $page->getNsText();
				break;
			case 'own-talk':
				$page = $data->getProperty('page');
				$user = $data->getProperty('user');
				$userTalk = $user->getUserPage()->getTalkPage();
				$outData = $page->equals( $userTalk );
				break;
			case 'usertype':
				$user = $data->getProperty('user');
				if ( $data->getProperty('anonymize') ) {
					$outData = 'anonymized';
				} elseif ( $user->isAnon() ) {
					$outData = 'ip';
				} else {
					$outData = 'user';
				}
				break;
			case 'user':
				$user = $data->getProperty('user');
				if ( $data->getProperty('anonymize') ) {
					$outData = '';
				} else {
					$outData = $user->getName();
				}
				break;
			case 'page':
				$outData = $data->getProperty('page')->getPrefixedText();
				break;
			default:
				$outData = $data->getProperty($field);
		}

		return $outData;
	}
}
