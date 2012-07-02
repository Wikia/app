<?php

/**
 * Represents an convenience methods for logging
 **/
class Selection {
	public static function addEntries( $name, $articles ) {
		$dbw = wfGetDB( DB_MASTER );
		$timestamp = wfTimestamp( TS_MW );
		foreach( $articles as $article ) {
			$success = $dbw->insert(
				'selections',
				array(
					's_selection_name' => $name,
					's_namespace' => $article['r_namespace'],
					's_article' => $article['r_article'],
					's_timestamp' => $timestamp
				),
				__METHOD__,
				array( 'IGNORE' )
			);
		}
	}

	public static function setRevision( $name, $namespace, $article, $revision ) {	
		$dbw = wfGetDB( DB_MASTER );
		$success = $dbw->update(
			'selections',
			array(
				's_revision' => $revision
			),
			array(
				's_selection_name' => $name,
				's_namespace' => $namespace,
				's_article' => $article
			),
			__METHOD__
		);
		return $success;
	}

	public static function deleteArticle( $name, $namespace, $article ) {
		$dbw = wfGetDB( DB_MASTER );
		$success = $dbw->delete(
			'selections',
			array(
				's_selection_name' => $name,
				's_namespace' => $namespace,
				's_article' => $article
			),
			__METHOD__
		);
		return $success;
	}
	public static function getSelection( $name ) {
		$dbr = wfGetDB( DB_SLAVE );

		$query = $dbr->select(
			'selections',
			'*',
			array('s_selection_name' => $name),
			__METHOD__
		);

		$articles = array();
		foreach( $query as $article_row ) {
			$article = (array)$article_row;
			$title = Title::makeTitle( $article['s_namespace'], $article['s_article'] );
			$article['title'] = $title;
			array_push( $articles, $article );
		}
		return $articles;
	}
}
