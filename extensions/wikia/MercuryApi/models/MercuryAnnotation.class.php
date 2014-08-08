<?php
/**
 * Created by PhpStorm.
 * User: Sutterfield
 * Date: 8/7/14
 * Time: 4:08 PM
 */

class MercuryAnnotation {
	const DATABASE = "mercury_hackathon";
	const COLLECTION = "annotateTest";

	/** @var MongoCollection  */
	private $collection;

	public function __construct() {
		$connection = new MongoClient();
		$this->collection = $connection->{self::DATABASE}->{self::COLLECTION};
	}

	public function getAnnotations( $articleId, $annotationId ) {
		global $wgDBname;

		$query = [
			"wiki" => $wgDBname,
			"articleId" => (int) $articleId,
			"annotationId" => (int) $annotationId
		];

		$cursor = $this->collection->find( $query );
		$cursor->sort( [ 'timestamp' => 1 ] );

		$annotations = [];
		foreach( $cursor as $document ) {
			$annotations[] = $document;
		}

		return [
			"annotations" => $annotations,
		];
	}

	public function setAnnotation( $articleId, $annotationId, $comment ) {
		global $wgDBname;

		$annotation = [
			"articleId" => (int) $articleId,
			"annotationId" => (int) $annotationId,
			"comment" => $comment,
			"wiki" => $wgDBname,
			"timestamp" => time()
		];

		// w option returns array with details about insert operation
		$result = $this->collection->insert( $annotation, ["w" => 1] );

		return [
			"success" => $result['ok'] ? "success" : "error",
			"message" => $result['ok'] ? "Annotation successfully saved" : $result['errmsg']
		];
	}
}