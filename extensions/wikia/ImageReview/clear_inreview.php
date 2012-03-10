<?php  

require( "../../../maintenance/commandLine.inc" );

$db = $this->wf->GetDB( DB_MASTER, array(), $this->wg->ExternalDatawareDB );

$timeLimit = ( $this->wg->DevelEnvironment ) ? 1 : 3600 ;

$db->update(
		'image_review',
		array(
			'reviewer_id = null',
			'state' => self::STATE_UNREVIEWED,
		     ),
		array(
			"review_start < now() - ".$timeLimit,
			"review_end = '0000-00-00 00:00:00'",
			'state' => self::STATE_IN_REVIEW,
		     ),
		__METHOD__
);
