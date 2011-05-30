<?php
/**
 * Support for Voctrain vocabulary trainer.
 * http://www.omegawiki.org/extensions/Wikidata/util/voctrain/trainer.php
 *
 * @file
 * @copyright Copyright © 2009-2010, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Old-style message group for Vocabulary trainer.
 */
class VoctrainMessageGroup extends ExtensionMessageGroup {

	public function getChecker() {
		$checker = new VoctrainMessageChecker( $this );
		$checker->setChecks( array(
			array( $checker, 'VoctrainVariablesCheck' ),
			array( $checker, 'braceBalanceCheck' ),
		) );
		return $checker;
	}

}

/**
 * %Message checker for Vocabulary trainer.
 */
class VoctrainMessageChecker extends MessageChecker {
	/**
	 * Checks for missing and unknown parameters
	 * @param $messages Iterable list of TMessage objects.
	 * @param $code Language code of the translations.
	 * @param $warnings Array where warnings are appended to.
	 */
	protected function VoctrainVariablesCheck( $messages, $code, &$warnings ) {
		foreach ( $messages as $message ) {
			$key = $message->key();
			$definition = $message->definition();
			$translation = $message->translation();

			$varPattern = '%[^% ]+';
			preg_match_all( "/$varPattern/U", $definition, $defVars );
			preg_match_all( "/$varPattern/U", $translation, $transVars );

			# Check for missing variables in the translation
			$subcheck = 'missing';
			$params = self::compareArrays( $defVars[0], $transVars[0] );
			if ( count( $params ) ) {
				$warnings[$key][] = array(
					array( 'variable', $subcheck, $key, $code ),
					'translate-checks-parameters',
					array( 'PARAMS', $params ),
					array( 'COUNT', count( $params ) ),
				);
			}

			# Check for unknown variables in the translation
			$subcheck = 'unknown';
			$params = self::compareArrays( $transVars[0], $defVars[0] );
			if ( count( $params ) ) {
				$warnings[$key][] = array(
					array( 'variable', $subcheck, $key, $code ),
					'translate-checks-parameters-unknown',
					array( 'PARAMS', $params ),
					array( 'COUNT', count( $params ) ),
				);
			}
		}
	}
}
