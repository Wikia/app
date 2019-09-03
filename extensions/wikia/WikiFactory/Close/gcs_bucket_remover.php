<?php

use Wikia\Logger\Loggable;

class GcsBucketRemover {
	use Loggable;

	public function remove( int $wikiId ) {
		try {
			$wgUploadPath = WikiFactory::getVarValueByName( 'wgUploadPath', $wikiId );

			if ( empty( $wgUploadPath ) ) {
				$this->info( "Upload path path is empty, leave early\n" );

				return false;
			}

			/** @var GcsFileBackend $backend */
			$backend = FileBackendGroup::singleton()->get( 'gcs-backend' );

			$this->info( sprintf( 'Removing images from path %s', $wgUploadPath ) );
			$path = trim( parse_url( $wgUploadPath, PHP_URL_PATH ), '/' );

			$this->info( sprintf( 'Getting file list for %s', $path ) );

			$path = StringUtils::escapeRegexReplacement( "mwstore://{$backend->getName()}/" . $path );

			$objects = iterator_to_array( $backend->getFileList( [ 'dir' => $path ] ) );

			if ( count( $objects ) === 0 ) {
				$this->info( sprintf( "'%s' path is empty, leave early\n", $path ) );

				return false;
			}

			// now delete them all
			foreach ( $objects as $object ) {
				$this->info( sprintf( "Removing file %s", $object ) );

				$backend->bucket()->object( $object )->delete();
			}
		}
		catch ( Exception $ex ) {
			$this->info( __METHOD__ . ' - ' . $ex->getMessage() );

			Wikia\Logger\WikiaLogger::instance()->error( 'Removing files failed', [
				'exception' => $ex,
				'city_id' => $wikiId,
			] );
		}
	}
}
