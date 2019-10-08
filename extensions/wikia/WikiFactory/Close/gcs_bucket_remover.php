<?php

use Wikia\Logger\Loggable;

class GcsBucketRemover {
	use Loggable;

	public function remove( int $wikiId ) {
		try {
			$wgUploadPath = WikiFactory::getVarValueByName( 'wgUploadPath', $wikiId );

			if ( empty( $wgUploadPath ) ) {
				$this->info( "Upload path path is empty, leave early" );
				return false;
			}

			/** @var GcsFileBackend $backend */
			$backend = FileBackendGroup::singleton()->get( 'gcs-backend' );

			$this->info( "Removing images from path: $wgUploadPath" );
			$path = trim( parse_url( $wgUploadPath, PHP_URL_PATH ), '/' );

			if ( $this->pathLooksUnsafeToRemove( $path ) ) {
				$this->warning( "Upload path looks unsafe to remove: $path" );
				return false;
			}

			$this->info( sprintf( 'Getting file list for %s', $path ) );

			$path = StringUtils::escapeRegexReplacement( "mwstore://{$backend->getName()}/" . $path );

			$objects = $backend->getFileList( [ 'dir' => $path ] );

			// now delete them all
			foreach ( $objects as $object ) {
				$this->info( sprintf( "Removing file %s", $object ) );

				$backend->bucket()->object( $object )->delete();
			}
		}
		catch ( Exception $ex ) {
			$this->error( 'Removing files failed', [
				'exception' => $ex,
				'wiki_id' => $wikiId,
			] );
		}
	}

	// We don't want to trigger file removal if the path looks too short (i. e. doesn't have at least 2 segments)
	private function pathLooksUnsafeToRemove( string $path ) : bool {
		return count( explode( '/', $path ) ) < 2;
	}
}
