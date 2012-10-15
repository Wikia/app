<?php

/**
 * Represents an convenience methods for logging
 **/
class AssessmentChangeLog {
	public static function makeEntry( $project, $namespace, $article, $timestamp, $action, $old, $new, $revision_timestamp ) {
		$dbw = wfGetDB( DB_MASTER );
		$dbw->insert(
			'assessment_changelog',
			array(
				'l_project' => $project,
				'l_namespace' => $namespace,
				'l_article' => $article,
				'l_action' => $action,
				'l_timestamp' => $timestamp,
				'l_old' => $old,
				'l_new' => $new,
				'l_revision_timestamp' => $revision_timestamp 
			),
			__METHOD__
		);
	}
}
