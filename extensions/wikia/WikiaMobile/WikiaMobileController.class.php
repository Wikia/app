<?php
/**
 * WikiaMobile public API
 *
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
class WikiaMobileController extends WikiaController{
	/**
	 * Fetches the requested batch for a specific index
	 * section in a category page
	 *
	 * @requestParam string $category The name of the category
	 * @requestParam string $index The index representing a section in the category's page
	 * @requestParam int $batch The number of the batch of items to load
	 *
	 * @responseParam array $batch
	 */
	public function getCategoryIndexBatch(){
		//see Category::newFromName for valid format
		$categoryName = $this->request->getVal( 'category' );
		$index = $this->request->getVal( 'index' );
		$batch = $this->request->getInt( 'batch' );
		$err = false;

		if ( !empty( $category ) && !empty( $index ) && !empty( $batch ) ){
			$category = Category::newFromName( $categoryName );

			if ( $category instanceof Category ) {
				$data = F::build( 'WikiaMobileCategoryModel' )->getItemsCollection( $category );

				if ( !empty( $data[$index] ) && $batch <= $data[$index]['batches'] && $batch > 0 ) {
					$this->response->setVal( 'batch', $data[$index]->getItems( $batch ) );
				} else {
					$err = true;
				}
			} else {
				$err = true;
			}
		} else {
			$err = true;
		}

		//TODO: error handling
		if ( $err ) {
			throw new WikiaException( "Error loading batch {$batch} for index {$index} in Category {$categoryName}" );
		}
	}
}