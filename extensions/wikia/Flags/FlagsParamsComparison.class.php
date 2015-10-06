<?php
namespace Flags;

class FlagsParamsComparison {

	/**
	 * Compare old and new template text to compare if its variables were changed
	 *
	 * @param $title
	 * @param $oldText
	 * @param $newText
	 * @param $flagVariables
	 * @return bool|mixed|null
	 */
	public function compareTemplateVariables( $title, $oldText, $newText, $flagVariables = [] ) {
		$oldText = str_replace( "\r\n", "\n", $oldText );
		$newText = str_replace( "\r\n", "\n", $newText );

		$newVariables = ( new \TemplateDataExtractor( $title ) )->getTemplateVariables( $newText );

		$removedVariables = array_diff_key( $flagVariables, $newVariables );
		$changedVariables = array_diff_key( $newVariables, $flagVariables );

		if ( empty( $removedVariables ) && empty( $changedVariables ) ) {
			// nothing changed
			return null;
		}

		$variablesDiff = self::compareVariables( $flagVariables, $removedVariables, $changedVariables );

		if ( $variablesDiff === false ) {
			$variablesDiff = self::compareVariableFromDiff( $oldText, $newText, $flagVariables, $removedVariables, $changedVariables );
		}

		return $variablesDiff;
	}

	/**
	 * Basic template variables comparison.
	 * Checks if just new variables were added or removed.
	 * If variables names were updated need to make more advanced compariosn
	 *
	 * @param $flagVariables
	 * @param $removedVariables
	 * @param $changedVariables
	 * @return bool
	 */
	private static function compareVariables( $flagVariables, $removedVariables, $changedVariables ) {
		if ( empty( $removedVariables ) && !empty( $changedVariables ) ) {
			// variables added
			foreach ( $changedVariables as $name => $variable ) {
				$flagVariables[$name] = '';
				$variablesDiff['added'][] = $name;
			}

			$variablesDiff['params'] = $flagVariables;

			return $variablesDiff;

		} elseif ( !empty( $removedVariables ) && empty( $changedVariables ) ) {
			// variables removed
			foreach ( $removedVariables as $name => $variable ) {
				if ( isset( $flagVariables[$name] ) ) {
					$variablesDiff['removed'][] = $name;
					unset( $flagVariables[$name]);
				}
			}

			$variablesDiff['params'] = $flagVariables;

			return $variablesDiff;

		} else {
			// variables updated - needs more advanced comparison
			return false;
		}
	}

	/**
	 * Compare old and new template text and get data about updated variables.
	 * Uses data about removed and added variables from previous calculations.
	 *
	 * @param $oldText
	 * @param $newText
	 * @param $flagVariables
	 * @param $removedVariables
	 * @param $changedVariables
	 * @return mixed
	 */
	private static function compareVariableFromDiff( $oldText, $newText, $flagVariables, $removedVariables, $changedVariables ) {
		global $wgContLang;

		$ota = explode( "\n", $wgContLang->segmentForDiff( $oldText ) );
		$nta = explode( "\n", $wgContLang->segmentForDiff( $newText ) );

		$diffs = new \WordLevelDiff( $ota, $nta );

		$changed = [];

		foreach ( $diffs->edits as $diff ) {
			if ( $diff->type === 'change' ) {
				$changed[] = $diff;
			}
		}

		$changed = array_unique( $changed, SORT_REGULAR );

		foreach( $changed as $change ) {
			$flagParam = $change->orig[0];
			$newParam = $change->closing[0];

			if ( isset( $removedVariables[$flagParam] ) && isset( $changedVariables[$newParam] ) ) {

				$flagVariables[$newParam] = $flagVariables[$flagParam];

				$variablesDiff['changed'][$newParam] = [ 'old' => $flagParam, 'new' => $newParam ];

				unset($flagVariables[$flagParam]);
				unset($removedVariables[$flagParam]);
				unset($changedVariables[$newParam]);
			}
		}

		foreach ( $removedVariables as $name => $variable ) {
			if ( isset( $flagVariables[$name] ) ) {
				$variablesDiff['removed'][] = $name;
				unset( $flagVariables[$name]);
			}
		}

		foreach ( $changedVariables as $name => $variable ) {
			$flagVariables[$name] = '';
			$variablesDiff['added'][] = $name;
		}

		$variablesDiff['params'] = $flagVariables;

		return $variablesDiff;
	}
}
