<?php

require_once( dirname(__FILE__).'/../commandLine.inc' );

$dbr = wfGetDB( DB_SLAVE );
$dbw = wfGetDB( DB_MASTER );
$sth = $dbr->select(
	array( "image" ),
	array( "img_name", "img_media_type" ),
	false,
	__METHOD__
);
while( $row = $dbr->fetchObject( $sth ) ) {
	$file = wfLocalFile( $row->img_name );
	if( $file ) {
		$oldFiles = $file->getHistory();
		foreach( $oldFiles as $oldfile ) {
			$path = $oldfile->getPath();
			$parts = explode( "/", $path );
			$file = array_pop( $parts );
			if( is_file( $path ) ) {
				$sha1 = File::sha1Base36( $path );
				/**
				 * select row from old image
				 */
				$row = $dbr->selectRow(
					array( "oldimage" ),
					array( "*" ),
					array( "oi_archive_name" => $file ),
					__METHOD__
				);
				if( $row->oi_sha1 !== $sha1 ) {
					Wikia::log( "info", "", "{$path} new:{$sha1} <> old:{$row->oi_sha1}" );
					$dbw->update(
						"oldimage",
						array( "oi_sha1" => $sha1 ),
						array( "oi_archive_name" => $file ),
						__METHOD__
					);
				}
			}
			else {
				Wikia::log( "err", "", "{$path} {$file} doesn't exists" );
			}
		}
	}
}
$dbr->freeResult( $sth );
