<?php
/**
 * Pagination controller
 */
class PaginationController extends WikiaService {
	const MAX_DISPLAYED_PAGES = 6;

	/**
	 * @brief Renders pagination
	 *
	 * @requestParam int $totalItems total number of items in result set
	 * @requestParam int $itemsPerPage number of items to show on each page
	 * @requestParam int $currentPage selected page number
	 * @requestParam String $url string with the url to which method will add "?page=" or "&page=" suffix
	 * @requestParam String $prevMsg (optional) text showed on preview button
	 * @requestParam String $nextMsg (optional) text showed on next button
	 */
	public function index() {
		$this->response->addAsset('includes/wikia/services/css/pagination.scss');
		
		$this->totalItems = $this->getVal('totalItems');
		$this->itemsPerPage = $this->getVal('itemsPerPage');
		$this->currentPage = $this->getVal('currentPage');
		$this->data = $this->getVal('data', array());
		$this->url = $this->getVal('url', '#');
		$this->prevMsg = $this->getVal( 'prevMsg', wfMessage( 'wikia-pagination-prev' )->plain() );
		$this->nextMsg = $this->getVal( 'nextMsg', wfMessage( 'wikia-pagination-next' )->plain() );
		
		if( strpos($this->url, '?') === false ) {
			$this->url .= ($this->url === '#' ? '' : '?page=');
		} else {
			$this->url .= ($this->url === '#' ? '' : '&page=');
		}
		
		$this->pages = null;
		$this->prev = null;
		$this->next = null;
		
		$totalPages = ceil($this->totalItems / $this->itemsPerPage);
		$pagesArray = array(1);
		
		// Don't render anything if $totalPages == 1
		// if ($totalPages == 1) return; ??
		
		// Should "prev" be rendered?
		if ($this->currentPage > 1) {
			$this->prev = true;
		}
		
		// Calculate range of page numbers
		$firstVisiblePage = max(2, min($totalPages - PaginationController::MAX_DISPLAYED_PAGES + 1, $this->currentPage - PaginationController::MAX_DISPLAYED_PAGES + 4));
		$lastVisiblePage = min($totalPages - 1, PaginationController::MAX_DISPLAYED_PAGES + $firstVisiblePage - 2);
		
		// Should there be a spacer between 1 and first visible page?
		if ($firstVisiblePage > 2) {
			$pagesArray[] = '…';
		}
		
		// Push the range of pages into the pages array
		for($i=$firstVisiblePage; $i<=$lastVisiblePage; $i++) {
			$pagesArray[] = $i;
		}
		
		if ($lastVisiblePage < $totalPages) {
			// Should there be a spacer between last visible page and last page?
			if ($lastVisiblePage < $totalPages - 1) {
				$pagesArray[] = '…';
			}
			
			// Include last page if it's not already part of the range
			if ($lastVisiblePage < $totalPages) {
				$pagesArray[] = $totalPages;
			}
		}
		
		// Should "next" be rendered?
		if ($this->currentPage < $totalPages) {
			$this->next = true;
		}
		
		// Set the template variable
		$this->pages = $pagesArray;
	}
}
