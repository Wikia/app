<?php
/**
 * A simple class of methods responsible for checking permissions and contexts for
 * performing actions related to Template Classifications.
 */

namespace Wikia\TemplateClassification;

class Permissions {

	/**
	 * Checks the necessary conditions for setting up an entry point for TemplateClassification edit.
	 * @param \User $user
	 * @param \Title $title
	 * @return bool
	 */
	public function shouldDisplayEntryPoint( \User $user, \Title $title ) {
		return $this->userCanChangeType( $user, $title )
		       && $title->inNamespace( NS_TEMPLATE );
	}

	/**
	 * Checks if entry point for bulk template classification should be shown.
	 *
	 * @param \User $user
	 * @param \Title $title
	 * @return bool
	 */
	public function shouldDisplayBulkActions( \User $user, \Title $title ) {
		return $title->inNamespace( NS_CATEGORY )
			&& $user->isAllowed( 'template-bulk-classification' )
			&& ( new Helper() )->countTemplatesInCategory( $title->getDBkey() );
	}

	/**
	 * Checks if user is allowed to change
	 * @param \User $user
	 * @param \Title $title
	 * @return bool
	 */
	public function userCanChangeType( \User $user, \Title $title ) {
		return $user->isLoggedIn()
		       && $title->userCan( 'edit', $user );
	}
}
