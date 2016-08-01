<?php

class CategoryPaginationPage extends CategoryPage {
	public function closeShowCategory() {
		$request = $this->getContext()->getRequest();
		$page = $request->getInt( 'page', 0 );
		$page = max( 1, $page );
		$viewer = new CategoryPaginationViewer(
			$this->getContext()->getTitle(),
			$this->getContext(),
			$page
		);
		$this->getContext()->getOutput()->addHTML( $viewer->getHTML() );
	}
}
