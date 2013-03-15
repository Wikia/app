<?php

class UpdateBacklinksJob extends Job
{
	/**
	 * Stores instances of Solarium_Document_AtomicUpdate
	 * @var unknown_type
	 */
	protected $documents = array();
	
	public function __construct( $title, $linksArray, $id = 0 ) {
		parent::__construct( 'updateBackLinks', $title, array( 'links' => $linksArray ) , $id );
	}
	
	public function run() {
		wfProfileIn(__METHOD__);
		foreach ( $this->params['links'] as $targetId => $textToSources ) {
			$document = $this->getDocumentForTarget( $targetId );
			foreach ( $textToSources as $text => $sources ) {
				foreach ( $sources as $sourceId => $count ) {
					$field = "backlink_from_{$sourceId}_txt";
					if (! isset( $document[$field] ) ) {
						$document->addField( $field, array( $text ), null, Solarium_Document_AtomicUpdate::MODIFIER_SET );
					} else {
						$document[$field][] = $text;
					}
				}
			}
		}
		$indexer = new Wikia\Search\Indexer();
		$indexer->updateDocuments( $this->documents );
		wfProfileOut(__METHOD__);
	}
	
	/**
	 * Returns the proper Solarium_Document_AtomicUpdate corresponding to the provided ID, initializing it if required
	 * @param string $targetId the document ID ( e.g. wid_pageid )
	 * @return Solarium_Document_AtomicUpdate
	 */
	protected function getDocumentForTarget( $targetId ) {
		if (! isset( $this->documents[$targetId] ) ) {
			$document = new Solarium_Document_AtomicUpdate();
			$document->setKey( 'id', $targetId );
			$this->documents[$targetId] = $document;
		}
		return $this->documents[$targetId];
	}
	
	
}