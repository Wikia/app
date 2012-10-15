<?php
/**
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo( "not a valid entry point.\n" );
	die( 1 );
}

class SpecialSelection extends SpecialPage {

	public function __construct() {
		parent::__construct( 'Selection' );
	}

	private function makeCSV( $articles, $name ) {
		$outstream = fopen( "php://output", "w" );
		$headers = array(
			'article',
			'revision',
			'added'
		);
		fputcsv( $outstream, $headers );
		foreach( $articles as $article ) {
			$row = array(
				$article['title']->getFullText(),
				$article['s_revision'],
				wfTimeStamp( TS_ISO_8601, $article['s_timestamp'] )
			);
			fputcsv( $outstream, $row );
		}
		fclose( $outstream );
	}

	public function execute( $par ) {
        global $wgOut, $wgRequest;

		$name = $wgRequest->getVal( 'name' );
		$format = $wgRequest->getVal( 'format' );

		if( $wgRequest->wasPosted() ) {
			$wgOut->disable();
			$namespace = $wgRequest->getVal( 'namespace' );
			$article = $wgRequest->getVal( 'article' );

			$action = $wgRequest->getVal( 'action' );
			if( $action == 'setrevision' ) {
				$revision = $wgRequest->getVal( 'revision' );
				$success = Selection::setRevision( $name, $namespace, $article, $revision );
				$title = Title::makeTitle( $namespace, $article );
				$url = $title->getLinkUrl( array( 'oldid' => $revision ) );
				$return = array(
					'status' => $success,
					'revision' => $revision,
					'revision_url' => $url
				);
			} elseif ( $action == 'deletearticle') {
				$success = Selection::deleteArticle( $name, $namespace, $article );
				$return = array(
					'status' => $success
				);
			}
			echo json_encode($return);
			return;
		}
		$entries = Selection::getSelection( $name );
		$this->setHeaders();

		$wgOut->setPageTitle("Selection");

		if( $format == 'csv' ) {
			$wgRequest->response()->header( 'Content-type: text/csv' );
			// Is there a security issue in letting the name be arbitrary?
			$wgRequest->response()->header(
				"Content-Disposition: attachment; filename=$name.csv"
			);
			$wgOut->disable();
			$this->makeCSV( $entries, $name );
		}

		$csv_link = $this->getFullTitle()->getFullUrl( array(
			'format' => 'csv',
			'name' => $name
		) );
		$template = new SelectionTemplate();
		$template->set( 'articles', $entries );
		$template->set( 'name', $name );
		$template->set( 'csv_link', $csv_link );

		$wgOut->addTemplate( $template );
	}
}
