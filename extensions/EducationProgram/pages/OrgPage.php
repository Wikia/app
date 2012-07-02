<?php

/**
 * Page for interacting with an org.
 *
 * @since 0.1
 *
 * @file OrgPage.php
 * @ingroup EducationProgram
 * @ingroup Page
 *
 * @licence GNU GPL v3+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class OrgPage extends EPPage {
	
	protected function getActions() {
		return array(
			'view' => 'ViewOrgAction',
			'edit' => 'EditOrgAction',
			'history' => 'OrgHistoryAction',
		);
	}
	
}