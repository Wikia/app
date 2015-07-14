<?php
namespace Flags;

class FlagsParamsComparison {

	public function compareTemplateVariables( $title, $oldText, $newText, $flagType) {
		$oldText = str_replace( "\r\n", "\n", $oldText );
		$newText = str_replace( "\r\n", "\n", $newText );

		$newVariables = (new \TemplateDataExtractor( $title ) )->getTemplateVariables( $newText );
		$flagVariables = json_decode( $flagType['flag_params_names'], true );

		$removedVariables = array_diff_key( $flagVariables, $newVariables );
		$changedVariables = array_diff_key( $newVariables, $flagVariables );

		if ( empty( $removedVariables ) && empty( $changedVariables ) ) {
			// nothing changed
			return null;
		}

		$flagParamsNames = self::compareVariables( $flagVariables, $removedVariables, $changedVariables );

		if ( $flagParamsNames === false ) {
			$flagParamsNames = self::compareVariableFromDiff( $oldText, $newText, $flagVariables, $removedVariables, $changedVariables );
		}

		return $flagParamsNames;
	}

	private static function compareVariables( $flagVariables, $removedVariables, $changedVariables ) {
		if ( empty( $removedVariables ) && empty( $changedVariables ) ) {
			// nothing changed
			return [];

		} elseif ( empty( $removedVariables ) && !empty( $changedVariables ) ) {
			// variables added
			foreach ( $changedVariables as $name => $variable ) {
				$flagVariables[$name] = $name;
			}

			return $flagVariables;

		} elseif ( !empty( $removedVariables ) && empty( $changedVariables ) ) {
			// variables removed
			foreach ( $removedVariables as $name => $variable ) {
				if ( isset( $flagVariables[$name] ) ) {
					unset( $flagVariables[$name]);
				}
			}

			return $flagVariables;

		} else {
			return false;
		}
	}

	private static function compareVariableFromDiff( $oldText, $newText, $flagVariables, $removedVariables, $changedVariables ) {
		global $wgContLang;

		$ota = explode( "\n", $wgContLang->segmentForDiff( $oldText ) );
		$nta = explode( "\n", $wgContLang->segmentForDiff( $newText ) );

		$diffs = new \WordLevelDiff( $ota, $nta );

		$deleted = [];
		$changed = [];

		foreach ( $diffs->edits as $diff ) {
			switch ( $diff->type ) {
				case 'change': $changed[] = $diff; break;
				case 'delete': $deleted[] = $diff; break;
			}
		}

		$changed = array_unique( $changed, SORT_REGULAR );

		foreach( $changed as $change ) {
			$flagParam = $change->orig[0];
			$newParam = $change->closing[0];

			if ( isset( $flagVariables[$flagParam] ) && isset( $variables[$newParam] ) ) {

				$flagVariables[$newParam] = $flagVariables[$flagParam];

				unset($flagVariables[$flagParam]);
				unset($removedVariables[$flagParam]);
				unset($changedVariables[$newParam]);
			}
		}

		foreach ( $removedVariables as $name => $variable ) {
			if ( isset( $flagVariables[$name] ) ) {
				unset( $flagVariables[$name]);
			}
		}

		foreach ( $changedVariables as $name => $variable ) {
			$flagVariables[$name] = $name;
		}

		return $flagVariables;
	}
}
