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
		return $user->isLoggedIn()
		&& $title->inNamespace( NS_TEMPLATE )
		&& $title->userCan( 'edit', $user );
	}
}
