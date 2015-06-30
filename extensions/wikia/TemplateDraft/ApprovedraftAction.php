<?php
/**
 * Move draft page content to parent page
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA
 *
 * @file
 * @ingroup Actions
 * @author Kamil Koterba <kamil@wikia-inc.com>
 */

class ApprovedraftAction extends FormlessAction {

	public function getName() {
		return 'approvedraft';
	}

	protected function getDescription() {
		return '';
	}

	public function onView() {
		global $wgTitle;

		$this->redirectParams = wfArrayToCGI( array_diff_key(
			$this->getRequest()->getQueryValues(),
			[ 'title' => null, 'action' => null ]
		));

		$this->redirectTitle = $wgTitle->getBaseText();
		$this->redirectTitle = Title::newFromText( $this->redirectTitle, $wgTitle->getNamespace() );
		$templateDraftController = new TemplateDraftController();
		$templateDraftController->approveDraft( $wgTitle );

		$this->getOutput()->redirect( $this->redirectTitle->getFullUrl( $this->redirectParams) );
	}

}
