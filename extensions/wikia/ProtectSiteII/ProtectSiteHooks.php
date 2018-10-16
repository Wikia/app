<?php

class ProtectSiteHooks {

	/** @var ProtectSiteModel $model */
	private static $model;

	public static function onGetUserPermissionsErrorsExpensive( Title $title, User $user, string $action, &$result ): bool {

		if ( !isset( ProtectSiteModel::PROTECT_ACTIONS[$action] ) ) {
			return true;
		}

		$settings = self::getModel()->getProtectionSettings();

		if ( ProtectSiteModel::isActionFlagSet( $settings, $action ) && !$user->isAllowed( 'protectsite-exempt' ) ) {
			$result = false;
			return false;
		}

		return true;
	}

	private static function getModel(): ProtectSiteModel {
		if ( !self::$model ) {
			self::$model = new ProtectSiteModel();
		}

		return self::$model;
	}
}
