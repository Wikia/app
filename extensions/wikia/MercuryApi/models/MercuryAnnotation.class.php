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
	const AVATAR_SIZE = 44;

	/** @var MongoCollection  */
	private $collection;

	public function __construct() {
		$connection = new MongoClient();
		$this->collection = $connection->{self::DATABASE}->{self::COLLECTION};
	}

	public function getAnnotations( $articleId, $annotationIds ) {

		$annotationIds = explode( ",", $annotationIds );
		$annotations = [];
		foreach( $annotationIds as $annotationId ) {
			$result = $this->getAnnotation( $articleId, $annotationId );
			if ( !empty( $result ) ) {
				$annotations[$result[0]['annotationId']] = $result;
			}
		}

		return [
			"annotations" => $annotations
		];
	}

	public function getAnnotation( $articleId, $annotationId ) {
		global $wgDBname;

		$query = [
			"wiki" => $wgDBname,
			"articleId" => (int) $articleId,
			"annotationId" => (int) $annotationId
		];
		$exclude = [
			'_id' => 0
		];

		$cursor = $this->collection->find( $query, $exclude );
		$cursor->sort( [ 'timestamp' => 1 ] );

		$annotations = [];
		foreach( $cursor as $document ) {
			$document['avatar'] = AvatarService::getAvatarUrl( $document['user'], self::AVATAR_SIZE );
			$annotations[] = $document;
		}

		return $annotations;
	}

	public function setAnnotation( $articleId, $annotationId, $comment, $user ) {
		global $wgDBname;

		$annotation = [
			"articleId" => (int) $articleId,
			"annotationId" => (int) $annotationId,
			"comment" => $comment,
			"user" => $user,
			"wiki" => $wgDBname,
			"timestamp" => time()
		];

		// w option returns array with details about insert operation
		$result = $this->collection->insert( $annotation, ["w" => 1] );

		return [
			"success" => $result['ok'] ? "success" : "error",
			"message" => $result['ok'] ? "Annotation successfully saved" : $result['errmsg'],
			"avatar" => AvatarService::getAvatarUrl( $user, self::AVATAR_SIZE )
		];
	}

	public function getNextAnnotationId() {
		$cursor = $this->collection->find();
		$cursor->sort( [ 'annotationId' => -1 ] );
		$result = $cursor->getNext();
		$id = 0;
		if (!empty($result)) {
			$id = $result['annotationId'] + 1;
		}
		return $id;
	}
}