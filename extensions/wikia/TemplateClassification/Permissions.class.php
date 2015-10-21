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
	 * Checks the necessary conditions for setting up an entry point
	 * for TemplateClassification edit on article edit page.
	 * @param \User $user
	 * @param \Title $title
	 * @return bool
	 */
	public function shouldDisplayEntryPointInEdit( \User $user, \Title $title ) {
		return $this->shouldDisplayEntryPoint( $user, $title )
		       && \RequestContext::getMain()->getRequest()->getVal( 'action' ) === 'edit';
	}

	/**
	 * Checks the necessary conditions for setting up an entry point
	 * for TemplateClassification edit on view page.
	 * @param \User $user
	 * @param \Title $title
	 * @return bool
	 */
	public function shouldDisplayEntryPointOnView( \User $user, \Title $title ) {
		return $this->shouldDisplayEntryPoint( $user, $title )
		       && $title->exists();
	}

	/**
	 * Checks the necessary conditions for showing type label (type name) for page
	 * @param \User $user
	 * @param \Title $title
	 * @return bool
	 */
	public function shouldDisplayTypeLabel( \Title $title ) {
		return $title->inNamespace( NS_TEMPLATE )
		       && $title->exists();
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
