<?php
namespace Wikia\ExactTarget;

class ExactTargetUserUpdateDriver {

	/**
	 * Allow to create when new email exists and is different than old one
	 * @param string $oldEmail Current email from ExactTarget database
	 * @param string $newEmail New email from Wikia to be updated
	 * @return bool
	 */
	public static function shouldCreateAsEmailChanged( $oldEmail, $newEmail ) {
		return !empty( $newEmail ) && $oldEmail !== $newEmail;
	}

	/**
	 * Allow to remove when old email exists and is different than new one
	 * @param string $oldEmail Current email from ExactTarget database
	 * @param string $newEmail New email from Wikia to be updated
	 * @return bool
	 */
	public static function shouldDeleteAsEmailChanged( $oldEmail, $newEmail ) {
		return !empty( $oldEmail ) && $oldEmail !== $newEmail;
	}

	/**
	 * Used to determine whether email is used by any other user than provided one.
	 * We don't want to allow changing email when it's used by other users.
	 * @param int $userId User being updated
	 * @param int[] $usedBy Array of user IDs that are using an email
	 * @return bool
	 */
	public static function isUsed( $userId, array $usedBy ) {
		return !empty( $usedBy ) && ( count( $usedBy ) > 1 || $usedBy[ 0 ] !== $userId );
	}

	/**
	 * Sums up edits arrays
	 * @param array $first
	 * @param array $second
	 * @return array first and second sum of edits
	 */
	public static function sumUpEdits( $first, $second ) {
		$result = [ ];
		$ids = array_unique( array_merge( (array)array_keys( $first ), (array)array_keys( $second ) ) );

		foreach ( $ids as $userId ) {
			$first[ $userId ] = isset( $first[ $userId ] ) && is_array( $first[ $userId ] ) ? $first[ $userId ] : [ ];
			$second[ $userId ] = isset( $second[ $userId ] ) && is_array( $second[ $userId ] ) ? $second[ $userId ] : [ ];
			$wikis = array_unique(
				array_merge( (array)array_keys( $first[ $userId ] ), (array)array_keys( $second[ $userId ] ) ) );
			foreach ( $wikis as $wikiId ) {
				$one = isset( $second[ $userId ][ $wikiId ] ) ? $second[ $userId ][ $wikiId ] : 0;
				$two = isset( $first[ $userId ][ $wikiId ] ) ? $first[ $userId ][ $wikiId ] : 0;
				$result[ $userId ][ $wikiId ] = $one + $two;
			}
		}

		return $result;
	}
}
