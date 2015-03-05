<?php

class SpriteService {

	protected $name = '';
	protected $source = '';
	protected $sourceFiles = array();
	protected $cssClassMap = array();
	protected $scss = '';
	protected $sprite = '';
	protected $postprocess = array();

	protected $startingspace = 60;
	protected $spacing = 12;
	protected $eol = "\n";

	protected $images = array();

	/**
	 * Create new SpriteService
	 *
	 * @param array $options Options (required are:
	 * - name - sprite name
	 * - source - source directory with images
	 * - scss - path where to write the scss file
	 * - sprite - path where to write sprite image file
	 * @throws Exception
	 */
	public function __construct( $options ) {
		foreach ( $options as $key => $value ) {
			if ( property_exists( $this, $key ) )
				$this->$key = $value;
		}

		if ( empty( $this->name ) || empty( $this->source ) || empty( $this->scss ) || empty( $this->sprite ) )
			throw new Exception( "Required arguments not supplied: name, source, scss, sprite" );

		$this->source = $this->realPath( $this->source ) . '/';
		$this->scss = $this->realPath( $this->scss );
		$this->sprite = $this->realPath( $this->sprite );
	}

	/**
	 * Works like a standard realpath() function except the fact it accepts
	 * non-existent files and returns the path as if the file existed
	 */
	protected function realPath( $path ) {
		$path = rtrim( $path, '\\/' );
		$dir = dirname( $path );

		return realpath( $dir ) . substr( $path, strlen( $dir ) );
	}

	/**
	 * Analyzes existing scss file and finds references to images
	 * and where are they present in the current sprite
	 * to minimize incompatibilities between versions
	 */
	protected function analyzeExistingSassFile() {
		$contents = (string)@file_get_contents( $this->scss );

		$lines = preg_split( "/\r?\n/", $contents );
		foreach ( $lines as $line ) {
			$matches = array();
			if ( preg_match( "/@autosprite-([^:]+):[ \t\r\n]*(.*)\$/", trim( $line ), $matches ) ) {
				list( , $key, $value ) = $matches;
				switch ( $key ) {
					case 'image-details':
						if ( preg_match( "/([^@]+)@([0-9]+),([0-9]+),([0-9A-Fa-f]+)/", trim( $value ), $matches ) ) {
							list( , $name, $x, $y, $md5 ) = $matches;
							$this->images[$name] = array(
								'x' => intval( $x ),
								'y' => intval( $y ),
								'md5' => $md5
							);
						}
						break;
				}
			}
		}
	}

	/**
	 * Scans directory and returns array where existing images become keys
	 *
	 * @param string $prefix Path prefix to search in
	 * @return array
	 */
	protected function scandir( $prefix = '' ) {
		$path = $this->source . $prefix;
		$files = scandir( $path );
		$list = array();
		foreach ( $files as $file ) {
			if ( substr( $file, 0, 1 ) == '.' )
				continue;
			if ( is_dir( $path . $file ) ) {
				$list = $list + $this->scandir( $prefix . $file . '/' );
			} else {
				$info = pathinfo( $file );
				if ( in_array( strtolower( $info['extension'] ), array( 'jpg', 'jpeg', 'png', 'gif' ) ) ) {
					$list[$prefix . $file] = array();
				}
			}
		}
		if ( count( $list ) == 0 ) {
			die( "No images found in $path \n" );
		}

		return $list;
	}

	protected function getFileList() {
		if ( empty( $this->sourceFiles ) ) {
			$list = $this->scandir();
		} else {
			$list = array();
			foreach ( $this->sourceFiles as $file ) {
				$list[$file] = array();
			}
		}

		return $list;
	}

	/**
	 * Loads image to memory using GD
	 *
	 * @param string $name Subpath to image file (inside the source directory)
	 * @return resource
	 */
	protected function loadImage( $name ) {
		$image = null;
		$info = pathinfo( $name );
		$extension = strtolower( $info['extension'] );
		$fullName = $this->source . $name;
		switch ( $extension ) {
			case 'jpg':
			case 'jpeg':
				$image = imagecreatefromjpeg( $fullName );
				break;
			case 'png':
				$image = imagecreatefrompng( $fullName );
				break;
			case 'gif':
				$image = imagecreatefromgif( $fullName );
				break;
		}

		return $image;
	}

	/**
	 * Consistent method to close the GD image
	 *
	 * @param resource $image Image resource returned by loadImage()
	 */
	protected function closeImage( $image ) {
		imagedestroy( $image );
	}

	/**
	 * Returns information about image
	 *
	 * @param string $name Subpath to image file (inside the source directory)
	 * @return array
	 */
	protected function getImageData( $name ) {
		$image = $this->loadImage( $name );
		if ( !$image )
			return false;

		$data = array(
			'width' => imagesx( $image ),
			'height' => imagesy( $image ),
			'md5' => md5_file( $this->source . $name ),
		);
		$this->closeImage( $image );

		return $data;
	}

	/**
	 * Removes references to images which does not still exist
	 * (updates the "images" property)
	 */
	protected function cleanImageData() {
		foreach ( $this->images as $file => $data ) {
			$imageData = $this->getImageData( $file );
			if ( !$imageData ) {
				unset( $this->images[$file] );
				continue;
			}
			if ( isset( $data['md5'] ) && $data['md5'] != $imageData['md5'] )
				$this->images[$file] = $imageData;
			else
				$this->images[$file] = array_merge( $data, $imageData );
		}
	}

	/**
	 * The main method which calculates the positions of images in sprite image
	 * (updates the "images" property)
	 *
	 * The algorithm here is very easy - it just puts the images horizontally
	 * and adds spacing and does not reclaim sprite space used for deleted
	 * source images.
	 */
	protected function allocateImageSpace() {
		$max = intval( $this->startingspace );
		foreach ( $this->images as $data )
			if ( isset( $data['x'] ) )
				$max = max( $max, $data['width'] + $data['x'] );
		foreach ( $this->images as $file => $data ) {
			if ( !isset( $data['x'] ) ) {
				$data['x'] = $max + intval( $this->spacing );
				$data['y'] = 0;
				$max = max( $data['x'] + $data['width'], $max );
			}
			$this->images[$file] = $data;
		}
	}

	/**
	 * Creates and writes the sprite file
	 */
	protected function createSpriteFile() {
		$width = 0;
		$height = 0;
		foreach ( $this->images as $data ) {
			$width = max( $width, $data['x'] + $data['width'] );
			$height = max( $height, $data['y'] + $data['height'] );
		}

		$out = imagecreatetruecolor( $width, $height );
		imagealphablending( $out, false );
		imagesavealpha( $out, true );
		$transparent = imagecolorallocatealpha( $out, 255, 255, 255, 127 );
		imagecolortransparent( $out, $transparent );
		imagefilledrectangle( $out, 0, 0, $width, $height, $transparent );

		foreach ( $this->images as $file => $data ) {
			$image = $this->loadImage( $file );
			imagecopy( $out, $image, $data['x'], $data['y'], 0, 0, $data['width'], $data['height'] );
			$this->closeImage( $image );
		}

		imagepng( $out, $this->sprite, 9 );
		imagedestroy( $out );

		$this->doPostProcessing( $this->sprite );
	}

	protected function doPostProcessing( $fileName ) {
		if ( empty( $this->postprocess ) ) {
			return;
		}

		$tmpDir = sys_get_temp_dir();
		$tmpInput = tempnam( $tmpDir, 'sprite' );
		$tmpOutput = tempnam( $tmpDir, 'sprite' );
		unlink( $tmpInput );
		unlink( $tmpOutput );
		$tmpInput .= '.png';
		$tmpOutput .= '.png';

		foreach ( $this->postprocess as $command ) {
			copy( $fileName, $tmpInput );
			$command = strtr( $command, array(
				'[INPUT]' => $tmpInput,
				'[OUTPUT]' => $tmpOutput,
			) );
			clearstatcache();
			$tmpSize = filesize( $tmpInput );

			$retval = null;
			$output = wfShellExec( $command, $retval );
			clearstatcache();
			if ( $retval == 0 ) {
				if ( file_exists( $tmpOutput ) && filesize( $tmpOutput ) > 0 ) {
					unlink( $fileName );
					copy( $tmpOutput, $fileName );
				} else if ( filesize( $tmpInput ) != $tmpSize ) {
					unlink( $fileName );
					copy( $tmpInput, $fileName );
				}
			} else {
				echo "warning: postprocessing failed ($command):\n$output\n";
			}

			@unlink( $tmpInput );
			@unlink( $tmpOutput );
		}
	}

	/** SASS GENERATION **/

	/**
	 * Returns information about all the included images in the format
	 * more usable for sass file generating
	 *
	 * @return array
	 */
	protected function getSassImageAttributes() {
		global $IP;

		$images = array();
		foreach ( $this->images as $file => $data ) {
			$name = $file;
			$i = strrpos( $name, '.' );
			if ( $i !== false ) {
				$name = substr( $name, 0, $i );
			}
			$relPath = $this->source
				. ( substr( $this->source, -1 ) == '/' ? '' : '/' )
				. $file;
			$relPath = wfRelativePath( $relPath, realpath( $IP ) );
			$images[] = array(
				'file' => $file,
				'relPath' => $relPath,
				'name' => $name,
				'x' => $this->formatCssValue( $data['x'], 'px'),
				'y' => $this->formatCssValue( $data['y'], 'px' ),
				'width' => $this->formatCssValue( $data['width'], 'px'),
				'height' => $this->formatCssValue( $data['height'], 'px'),
				'details' => "{$data['x']},{$data['y']},{$data['md5']}",
			);
		}

		return $images;
	}

	protected function formatCssValue( $value, $unit ) {
		if ( $value === 0 ) {
			$unit = '';
		}
		return $value . $unit;
	}

	/**
	 * Returns a CSS class name by the given image
	 *
	 * @param $name string Image name
	 * @return string CSS class name
	 */
	protected function getCssClassName( $name ) {
		echo " >> $name\n";
		$className = $name;
		echo " 2> $className\n";
		if ( isset( $this->cssClassMap[$className] ) ) {
			$className = $this->cssClassMap[$className];
		}
		$className = preg_replace( "#^(\\.\\./)*#", '', $className );
		echo " 3> $className\n";
		if ( isset( $this->cssClassMap[$className] ) ) {
			$className = $this->cssClassMap[$className];
		}
		$className = preg_replace( "/[^-a-zA-Z0-9]/", '-', $className );
		echo " 4> $className\n";
		if ( isset( $this->cssClassMap[$className] ) ) {
			$className = $this->cssClassMap[$className];
		}
		$className = preg_replace( "/[^-a-zA-Z0-9]/", '-', $className );
		echo " 5> $className\n";

		return $className;
	}

	/**
	 * Returns the sass file contents which needs to be put inside scss file
	 *
	 * @return string
	 */
	protected function getSassMixins() {
		global $IP;
		$name = $this->name;
		$spriteUrl = substr( $this->sprite, strlen( realpath( $IP ) ) );
		$images = $this->getSassImageAttributes();
		$contents = '';

		/** mixin sprite-NAME-base **/
		$contents .= <<<EOF
@mixin sprite-{$name}-base() {
	background-color: transparent;
	background-image: url('{$spriteUrl}'); /* wgCdnStylePath */
	background-repeat: no-repeat;
}


EOF;

		/** mixin sprite-NAME-base-embed **/
		$contents .= <<<EOF
@mixin sprite-{$name}-base-embed() {
	background-color: transparent;
	background-repeat: no-repeat;
}


EOF;

		/** mixin sprite-NAME **/
		$contents .= <<<EOF
@mixin sprite-{$name}(\$image-name, \$width: 0, \$height: 0, \$offset-x: 0, \$offset-y: 0) {
	\$image-x: -1;
	\$image-y: -1;
	\$image-width: -1;
	\$image-height: -1;

EOF;
		foreach ( $images as $image ) {
			$contents .= <<<EOF
	// @autosprite-image-details: {$image['file']}@{$image['details']}
	@if \$image-name == '{$image['name']}' {
		\$image-x: {$image['x']};
		\$image-y: {$image['y']};
		\$image-width: {$image['width']};
		\$image-height: {$image['height']};
	}

EOF;
		}

		$contents .= <<<EOF
	@if \$image-x != -1 {
		\$position-x: 0 - \$image-x;
		\$position-y: 0 - \$image-y;
		@if \$width > 0 {
			\$position-x: \$position-x + (\$width - \$image-width) / 2;
		}
		@if \$height > 0 {
			\$position-y: \$position-y + (\$height - \$image-height) / 2;
		}
		@if \$offset-x != 0 {
			\$position-x: \$position-x + \$offset-x;
		}
		@if \$offset-y != 0 {
			\$position-y: \$position-y + \$offset-y;
		}
		background-position: \$position-x \$position-y;
	}
}


EOF;

		/** mixin sprite-NAME-embed **/
		$contents .= <<<EOF
@mixin sprite-{$name}-embed(\$image-name, \$width: 0, \$height: 0, \$offset-x: 0, \$offset-y: 0) {
	\$image-width: -1;
	\$image-height: -1;

EOF;
		foreach ( $images as $image ) {
			$contents .= <<<EOF
	// @autosprite-image-details: {$image['file']}@{$image['details']}
	@if \$image-name == '{$image['name']}' {
		\$image-width: {$image['width']};
		\$image-height: {$image['height']};
		background-image: url('/{$image['relPath']}'); /* base64 */
	}

EOF;
		}

		$contents .= <<<EOF
	@if \$image-width != -1 {
		\$position-x: 0;
		\$position-y: 0;
		@if \$width > 0 {
			\$position-x: \$position-x + (\$width - \$image-width) / 2;
		}
		@if \$height > 0 {
			\$position-y: \$position-y + (\$height - \$image-height) / 2;
		}
		@if \$offset-x != 0 {
			\$position-x: \$position-x + \$offset-x;
		}
		@if \$offset-y != 0 {
			\$position-y: \$position-y + \$offset-y;
		}
		background-position: \$position-x \$position-y;
	}
}


EOF;

		/** mixin sprite-NAME-full **/
		$contents .= <<<EOF
@mixin sprite-{$name}-full(\$image-name, \$width: 0, \$height: 0, \$offset-x: 0, \$offset-y: 0) {
	@include sprite-{$name}-base;
	@include sprite-{$name}(\$image-name, \$width, \$height, \$offset-x, \$offset-y);
}


EOF;

		/** mixin sprite-NAME-full-embed **/
		$contents .= <<<EOF
@mixin sprite-{$name}-full-embed(\$image-name, \$width: 0, \$height: 0, \$offset-x: 0, \$offset-y: 0) {
	@include sprite-{$name}-base-embed;
	@include sprite-{$name}-embed(\$image-name, \$width, \$height, \$offset-x, \$offset-y);
}


EOF;

		/** mixin sprite-NAME-deep **/
		$contents .= <<<EOF
@mixin sprite-{$name}-deep(\$width: 0, \$height: 0) {
	@include sprite-{$name}-base;

EOF;
		foreach ( $images as $image ) {
			$className = $this->getCssClassName( $image['name'] );
			$contents .= <<<EOF

	&.{$className} {
		@include sprite-{$name}('{$image['name']}', \$width, \$height);
	}

EOF;
		}

		$contents .= <<<EOF
}


EOF;

		/** mixin sprite-NAME-deep-embed **/
		$contents .= <<<EOF
@mixin sprite-{$name}-deep-embed(\$width: 0, \$height: 0) {
	@include sprite-{$name}-base-embed;

EOF;
		foreach ( $images as $image ) {
			$className = $this->getCssClassName( $image['name'] );
			$contents .= <<<EOF

	&.{$className} {
		@include sprite-{$name}-embed('{$image['name']}', \$width, \$height);
	}

EOF;
		}

		$contents .= <<<EOF
}


EOF;

		return $contents;
	}

	protected function getTopNotice() {
		return <<<EOF
// Generated automatically by Sprite Generator.
//
// Do not edit anything between @autopsrite directives manually
// or your changes will be lost next time someone regenerates the file!
//
// Use maintenance/wikia/generateSprites.php to update sprite mixins and/or images.
// Config file is config/wikia/sprites.php
//


EOF;
	}

	const SASS_LINE_COMMENT = '// ';
	const SASS_START_MARKER = '@autosprite-start';
	const SASS_END_MARKER = '@autosprite-end';

	/**
	 * Creates or updates the scss file
	 */
	protected function createSassFile() {
		$contents = (string)@file_get_contents( $this->scss );
		$contents = str_replace( "\r", "", $contents );
		$startMarkerRegex = preg_quote( self::SASS_START_MARKER, '/' );
		$endMarkerRegex = preg_quote( self::SASS_END_MARKER, '/' );
		$regex = "/^(.*" . $startMarkerRegex . "[^\n]*)[\n].*[\n]([^\n]*" . $endMarkerRegex . ".*)$/ims";
		if ( preg_match( $regex, $contents, $matches ) ) {
			$before = $matches[1] . $this->eol;
			$after = $matches[2];
		} else {
			$before = $contents . $this->eol . self::SASS_LINE_COMMENT . self::SASS_START_MARKER . $this->eol;
			$after = self::SASS_LINE_COMMENT . self::SASS_END_MARKER;
		}

		$topNotice = $this->getTopNotice();
		if ( substr($before,0,strlen($topNotice)) !== $topNotice) {
			$before = $topNotice . $before;
		}

		$contents = $before . $this->getSassMixins() . $after;

		$contents = str_replace( "\r", "", $contents );

		if (substr($contents,-1) !== "\n" ) {
			$contents .= "\n";
		}

		file_put_contents( $this->scss, $contents );
	}

	/** GENERAL PROCESSING **/

	/**
	 * Starts the generation process
	 */
	public function process( $minimizeConflicts = true ) {
		// gather information about existing images
		$this->images = $this->getFileList();
		if ( $minimizeConflicts ) {
			$this->analyzeExistingSassFile();
		}
		$this->cleanImageData();
		ksort( $this->images );

		// create and write the sprite image
		$this->allocateImageSpace();
		$this->createSpriteFile();

		// create and write the scss file
		$this->createSassFile();
	}


	static public function newStandard( $name, $dir ) {
		$dir = realpath( $dir );
		$service = new SpriteService( array(
			'name' => $name,
			'source' => "{$dir}/images/sprite-{$name}/",
			'sprite' => "{$dir}/images/sprite-{$name}.png",
			'scss' => "{$dir}/css/_sprite-{$name}.scss",
		) );

		return $service;
	}

}

