<?php

/*
 * Retrieve metadata for a file
 */

require( dirname( __FILE__ ) . '/WebStoreStart.php' );

class WebStoreMetadata extends WebStoreCommon {
	function execute() {
		global $wgRequest;

		if ( !$wgRequest->wasPosted() ) {
			echo $this->dtd();
?>
<html>
<head><title>metadata.php Test interface</title>
<body>
<form method="post" action="metadata.php">
<p>Zone: <select name="zone" value="public">
<option>public</option>
<option>temp</option>
<option>deleted</option>
</select>
</p>
<p>Relative path: <input type="text" name="path"></p>
<p><input type="submit" value="OK" /></p>
</form>
</body></html>
<?php
			return true;
		}

		$zone = $wgRequest->getVal( 'zone' );
		$root = $this->getZoneRoot( $zone );
		if ( strval( $root ) == '' ) {
				$this->error( 400, 'webstore_invalid_zone', $zone );
				return false;
		}

		$rel = $wgRequest->getVal( 'path' );
		if ( !$this->validateFilename( $rel ) ) {
			$this->error( 400, 'webstore_path_invalid' );
			return false;
		}

		$fullPath = $root . '/' . $rel;

		$name = basename( $fullPath );
		$i = strrpos( $name, '.' );
		$ext = Image::normalizeExtension( $i ? substr( $name, $i + 1 ) : '' );
		$magic = MimeMagic::singleton();
		$mime = $magic->guessTypesForExtension( $ext );
		$type = $magic->getMediaType( $fullPath, $mime);

		$stat = stat( $fullPath );
		if ( !$stat ) {
			$this->error( 400, 'webstore_metadata_not_found', $fullPath );
			return false;
		}

		$image = UnregisteredLocalFile::newFromPath( $fullPath, $mime );
		if ( !$image->getHandler() ) {
			$this->error( 400, 'webstore_no_handler' );
			return false;
		}
		$gis = $image->getImageSize();
		$handlerMeta = $image->getMetadata();
		$stat = stat( $fullPath );

		$metadata = array(
			'width' => $gis[0],
			'height' => $gis[1],
			'bits' => isset( $gis['bits'] ) ? $gis['bits'] : '',
			'type' => $type, 
			'mime' => $mime,
			'metadata' => $handlerMeta,
			'size' => $stat['size'],
		);

		header( 'Content-Type: text/xml' );
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n<response><status>success</status><metadata>\n";
		foreach ( $metadata as $field => $value ) {
			if ( is_bool( $value ) ) {
				$value = $value ? 1 : 0;
			}
			echo "<item name=\"$field\">" . htmlspecialchars( $value ) . "</item>\n";
		}
		echo "</metadata></response>\n";
	}
}

$obj = new WebStoreMetadata;
$obj->executeCommon();

?>
