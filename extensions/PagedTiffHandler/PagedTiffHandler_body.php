<?php
 /**
  * Copyright (C) Wikimedia Deuschland, 2009
  * Authors Hallo Welt! Medienwerkstatt GmbH
  * Authors Sebastian Ulbricht, Daniel Lynge, Marc Reymann, Markus Glaser
  *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 */

class PagedTiffHandler extends ImageHandler {
    /**
     * Sets $wgShowEXIF to true when file is a tiff file.
     * This does not influence other ImageHandlers, which are possibly dependent on read-exif-data.
     */
    function PagedTiffHandler() {
        global $wgShowEXIF;
        $wgShowEXIF = true;
    }

    /**
     * Add the "lossy"-parameter to image link.
     * Usage:
     *  lossy=true|false
     *  lossy=1|0
     *  lossy=lossy|lossless
     * E.g. [[Image:Test.tif|lossy=1]]
     */
    static function addTiffLossyMagicWordLang( &$magicWords, $langCode ) {
        $magicWords['img_lossy'] = array( 0, "lossy=$1" );
        return true;
    }
    
    /**
     * Customize the thumbnail shell command.
     */
    static function renderCommand( &$cmd, $srcPath, $dstPath, $page, $width, $height ) {
        return true;
    }

    function isEnabled() { return true; }
    function mustRender() { return true; }
    function isMultiPage($img = false) {
        if (!$img) return true;
        $meta = unserialize($img->metadata);
        return ($meta['Pages'] > 1);
    }

    /**
     * various checks against the uploaded file
     * - maximum upload-size
     * - maximum number of embedded files
     * - maximum size of metadata
     * - maximum size of metadata
     * - identify-errors
     * - identify-warnings
     * - check for running-identify-service
     */
    function check( $saveName, $tempName, &$error ) {
        global $wgTiffMaxEmbedFiles, $wgTiffMaxMetaSize, $wgMaxUploadSize, $wgTiffRejectOnError, $wgTiffRejectOnWarning,
               $wgTiffUseTiffReader, $wgTiffReaderPath, $wgTiffReaderCheckEofForJS;
        if (!(substr($saveName, -5, 5)=='.tiff' || substr($saveName, -4, 4)=='.tif')) return true;
        wfLoadExtensionMessages( 'PagedTiffHandler' );
        if($wgTiffUseTiffReader) {
            require_once($wgTiffReaderPath.'/TiffReader.php');
            $tr = new TiffReader($tempName);
            $tr->check();
            if(!$tr->isValidTiff()) {
                $error = 'tiff_bad_file';
                wfDebug( __METHOD__.": tiff_bad_file ($saveName)\n" );
                return false;
            }
            if($tr->checkScriptAtEnd($wgTiffReaderCheckEofForJS)) {
                $error = 'tiff_script_detected';
                wfDebug( __METHOD__.": tiff_script_detected ($saveName)\n" );
                return false;
            }
            if(!$tr->checkSize()) {
                $error = 'tiff_size_error';
                wfDebug( __METHOD__.": tiff_size_error ($saveName)\n" );
                return false;
            }
        }
        $meta = self::getTiffImage(false, $tempName)->retrieveMetaData();
        if(!$meta && $meta != -1) {
            $error = 'tiff_out_of_service';
            wfDebug( __METHOD__.": tiff_out_of_service ($saveName)\n" );
            return false;
        }
        if($meta == -1) {
            $error = 'tiff_error_cached';
            wfDebug( __METHOD__.": tiff_error_cached ($saveName)\n" );
        }
        return self::extCheck($meta, $error, $saveName);
    }

    function extCheck($meta, &$error, $saveName = '') {
    global $wgTiffMaxEmbedFiles, $wgTiffMaxMetaSize;
        if(isset($meta['errors'])) {
            $error = 'tiff_bad_file';

            //NOTE: in future, it will become possible to pass parameters
            //$error = array( 'tiff_bad_file' , join('<br />', $meta['errors']) );

            wfDebug( __METHOD__.": tiff_bad_file ($saveName) " . join('; ', $meta['errors']) . "\n" );
            return false;
        }
        if((strlen(serialize($meta))+1) > $wgTiffMaxMetaSize) {
            $error = 'tiff_too_much_meta';
            wfDebug( __METHOD__.": tiff_too_much_meta ($saveName)\n" );
            return false;
        }
        if($wgTiffMaxEmbedFiles && $meta['Pages'] > $wgTiffMaxEmbedFiles) {
            $error = 'tiff_too_much_embed_files';
            wfDebug( __METHOD__.": tiff_too_much_embed_files ($saveName)\n" );
            return false;
        }
        return true;
    }

    /**
     * maps MagicWord-IDs to parameters.
     * parameter 'lossy' was added.
     */
    function getParamMap() {
        return array(
        'img_width' => 'width',
        // @todo check height
        'img_page' => 'page',
        'img_lossy' => 'lossy',
        );
    }


    /*
     * checks whether parameters are valid and have valid values.
     * check for lossy was added.
     */
    function validateParam( $name, $value ) {
        if ( in_array( $name, array( 'width', 'height', 'page', 'lossy' ) ) ) {
            if($name == 'lossy') {
                if(in_array($value, array(1, 0, '1', '0', 'true', 'false', 'lossy', 'lossless'))) {
                    return true;
                }
                return false;
            }
            if ( $value <= 0 ) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    /**
     * creates parameter string for file name.
     * page number was added.
     */
    function makeParamString( $params ) {
        $page = isset( $params['page'] ) ? $params['page'] : 1;
        if ( !isset( $params['width'] ) ) {
            return false;
        }
        return "page{$page}-{$params['width']}px";
    }

    /**
     * parses parameter string into an array.
     */
    function parseParamString( $str ) {
        $m = false;
        if ( preg_match( '/^page(\d+)-(\d+)px$/', $str, $m ) ) {
            return array( 'width' => $m[2], 'page' => $m[1] );
        } else {
            return false;
        }
    }

    /**
     * lossy-paramter added
     * TODO: The purpose of this function is not yet fully clear.
     */
    function getScriptParams( $params ) {
        return array(
        'width' => $params['width'],
        'page' => $params['page'],
        'lossy' => $params['lossy'],
        );
    }

    /**
     * prepares param array and sets standard values
     * standard values for page and lossy are added
     */
    function normaliseParams( $image, &$params ) {
        global $wgImageMagickIdentifyCommand;

        $mimeType = $image->getMimeType();

        if ( !isset( $params['width'] ) ) {
            return false;
        }
        if ( !isset( $params['page'] ) || $params['page'] < 1 ) {
            $params['page'] = 1;
        }
        if ( $params['page'] > $this->pageCount( $image ) ) {
            $params['page'] = $this->pageCount( $image );
        }
        if ( !isset( $params['lossy'] ) ) {
            $params['lossy'] = NULL;
        }
        $size =  PagedTiffImage::getPageSize($this->getMetaArray($image), $params['page']);
        $srcWidth = $size['width'];
        $srcHeight = $size['height'];

        if ( isset( $params['height'] ) && $params['height'] != -1 ) {
            if ( $params['width'] * $srcHeight > $params['height'] * $srcWidth ) {
                $params['width'] = wfFitBoxWidth( $srcWidth, $srcHeight, $params['height'] );
            }
        }
        $params['height'] = File::scaleHeight( $srcWidth, $srcHeight, $params['width'] );
        if ( !$this->validateThumbParams( $params['width'], $params['height'], $srcWidth, $srcHeight, $mimeType ) ) {
            return false;
        }
        return true;
    }

    /**
     * doTransform was changed for multipage and lossy support.
     * self::TRANSFORM_LATER is ignored. Instead, the function checks whether a
     * thumbnail with the requested file type and resolution exists. It will be
     * created if necessary.
     */
    function doTransform( $image, $dstPath, $dstUrl, $params, $flags = 0 ) {
        global $wgImageMagickConvertCommand, $wgTiffMaxEmbedFileResolution, $wgTiffUseVips, $wgTiffVipsCommand;

        $metadata = $image->getMetadata();

        if ( !$metadata ) {
            if($metadata == -1) {
                return $this->doThumbError( @$params['width'], @$params['height'], 'tiff_error_cached' );
            }
            return $this->doThumbError( @$params['width'], @$params['height'], 'tiff_no_metadata' );
        }
        if ( !$this->normaliseParams( $image, $params ) )
            return new TransformParameterError( $params );

        $width = $params['width'];
        $height = $params['height'];
        $srcPath = $image->getPath();
        $page = $params['page'];

        $extension = $this->getThumbExtension($image, $page, $params['lossy']);
        $dstPath  .= $extension;
        $dstUrl   .= $extension;

        $meta = unserialize($metadata);

        if(!$this->extCheck($meta, $error, $dstPath)) {
            return $this->doThumbError( @$params['width'], @$params['height'], $error );
        }

        if ( is_file($dstPath) )
            return new ThumbnailImage( $image, $dstUrl, $width,
            $height, $dstPath, $page );

        if(isset($meta['pages'][$page]['pixels']) && $meta['pages'][$page]['pixels'] > $wgTiffMaxEmbedFileResolution)
            return $this->doThumbError( $width, $height, 'tiff_sourcefile_too_large' );

        if ( !wfMkdirParents( dirname( $dstPath ) ) )
            return $this->doThumbError( $width, $height, 'thumbnail_dest_directory' );

        if($wgTiffUseVips) {
            // tested in Linux
            $cmd = wfEscapeShellArg( $wgTiffVipsCommand );
            $cmd .= ' im_resize_linear "'.$srcPath.':'.($page-1).'" ';
            $cmd .= wfEscapeShellArg( $dstPath );
            $cmd .= " {$width} {$height} 2>&1";
        }
        else {
            $cmd = wfEscapeShellArg( $wgImageMagickConvertCommand );
            $cmd .= " ". wfEscapeShellArg( $srcPath )."[".($page-1)."]";
            $cmd .= " -depth 8 -resize {$width} ";
            $cmd .= wfEscapeShellArg( $dstPath );
        }

        wfRunHooks( "PagedTiffHandlerRenderCommand", array( &$cmd, $srcPath, $dstPath, $page, $width, $height ) );

        wfProfileIn( 'PagedTiffHandler' );
        wfDebug( __METHOD__.": $cmd\n" );
        $err = wfShellExec( $cmd, $retval );
        wfProfileOut( 'PagedTiffHandler' );

        $removed = $this->removeBadFile( $dstPath, $retval );

        if ( $retval != 0 || $removed ) {
            wfDebugLog( 'thumbnail',
                sprintf( 'thumbnail failed on %s: error %d "%s" from "%s"',
                wfHostname(), $retval, trim($err), $cmd ) );
            return new MediaTransformError( 'thumbnail_error', $width, $height, $err );
        } else {
            return new ThumbnailImage( $image, $dstUrl, $width, $height, $dstPath, $page );
        }
    }

    /**
     * Decides (taking lossy parameter into account) the filetype of the thumbnail.
     * If there is no lossy-Parameter (NULL = not set), the decision is being made
     * according to the presence of an alpha value.
     * (alpha == true = png, alpha == false = jpg)
     */
    function getThumbExtension( $image, $page, $lossy ) {
        if($lossy === NULL) {
            $data = $this->getMetaArray($image);
            if((strtolower($data['pages'][$page]['alpha']) == 'true')) {
                return '.png';
            }
            else {
                return '.jpg';
            }
        }
        else {
            if(in_array($lossy, array(1, '1', 'true', 'lossy'))) {
                return '.jpg';
            }
            else {
                return '.png';
            }
        }
    }

    /**
     * Returns the number of available pages/embedded files
     */
    function pageCount( $image ) {
        $data = $this->getMetaArray( $image );
        if ( !$data ) return false;
        return intval( $data['Pages'] );
    }

    /**
     * Returns a new Error-Message.
     */
    protected function doThumbError( $width, $height, $msg ) {
        wfLoadExtensionMessages( 'PagedTiffHandler' );
        return new MediaTransformError( 'thumbnail_error',
        $width, $height, wfMsg($msg) );
    }

    /**
     * Get handler-specific metadata which will be saved in the img_metadata field.
     *
     * @param Image $image The image object, or false if there isn't one
     * @param string $fileName The filename
     * @return string
     */
    function getMetadata( $image, $path ) {
        return serialize( $this->getTiffImage( $image, $path )->retrieveMetaData() );
    }

    /**
     * Creates detail information that is being displayed on image page.
     */
    function getLongDesc( $image ) {
        global $wgLang;
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        if ( !isset( $page ) || $page < 1 ) {
            $page = 1;
        }
        if ( $page > $this->pageCount( $image ) ) {
            $page = $this->pageCount( $image );
        }
        $metadata = $this->getMetaArray($image);
        if( $metadata ) {
            wfLoadExtensionMessages( 'PagedTiffHandler' );
            return wfMsgExt('tiff-file-info-size', 'parseinline',
            $wgLang->formatNum( $metadata['pages'][$page]['width'] ),
            $wgLang->formatNum( $metadata['pages'][$page]['height'] ),
            $wgLang->formatSize( $image->getSize() ),
            'image/tiff',
            $page );
        }
        return true;
    }

    /**
     * Check if the metadata string is valid for this handler.
     * If it returns false, Image will reload the metadata from the file and update the database
     */
    function isMetadataValid( $image, $metadata ) {
        if(!empty( $metadata ) && $metadata != serialize(array())) {
            $meta = unserialize($metadata);
            if(isset($meta['Pages']) && isset($meta['pages'])) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get a list of EXIF metadata items which should be displayed when
     * the metadata table is collapsed.
     *
     * @return array of strings
     * @access private
     */
    function visibleMetadataFields() {
        $fields = array();
        $lines = explode( "\n", wfMsg( 'metadata-fields' ) );
        foreach( $lines as $line ) {
            $matches = array();
            if( preg_match( '/^\\*\s*(.*?)\s*$/', $line, $matches ) ) {
                $fields[] = $matches[1];
            }
        }
        $fields = array_map( 'strtolower', $fields );
        return $fields;
    }

    /**
     * Get an array structure that looks like this:
     *
     * array(
     *    'visible' => array(
     *       'Human-readable name' => 'Human readable value',
     *       ...
     *    ),
     *    'collapsed' => array(
     *       'Human-readable name' => 'Human readable value',
     *       ...
     *    )
     * )
     * The UI will format this into a table where the visible fields are always
     * visible, and the collapsed fields are optionally visible.
     *
     * The function should return false if there is no metadata to display.
     */

    function formatMetadata( $image ) {
        $result = array(
            'visible' => array(),
            'collapsed' => array()
        );
        $metadata = $image->getMetadata();
        if ( !$metadata ) {
            return false;
        }
        $exif = unserialize( $metadata );
        $exif = $exif['exif'];
        if ( !$exif ) {
            return false;
        }
        unset( $exif['MEDIAWIKI_EXIF_VERSION'] );
        $format = new FormatExif( $exif );

        $formatted = $format->getFormattedData();
        // Sort fields into visible and collapsed
        $visibleFields = $this->visibleMetadataFields();
        foreach ( $formatted as $name => $value ) {
            $tag = strtolower( $name );
            self::addMeta( $result,
                in_array( $tag, $visibleFields ) ? 'visible' : 'collapsed',
                'exif',
                $tag,
                htmlspecialchars($value)
            );
        }
        $meta = unserialize($metadata);
        if(isset($meta['errors'])) {
            $errors = array();
            foreach($meta['errors'] as $error) {
                $errors[] = htmlspecialchars($error);
            }
            self::addMeta( $result,
                'collapsed',
                'identify',
                'error',
                join('<br />', $errors)
            );
        }
        if(isset($meta['warnings'])) {
            $warnings = array();
            foreach($meta['warnings'] as $warning) {
                $warnings[] = htmlspecialchars($warning);
            }
            self::addMeta( $result,
                'collapsed',
                'identify',
                'warning',
                join('<br />', $warnings)
            );
        }
        return $result;
    }

    /**
     * Returns a PagedTiffImage or create a new one if don´t exist.
     */
    static function getTiffImage( $image, $path ) {
        if ( !$image )
            $tiffimg = new PagedTiffImage( $path );
        elseif ( !isset( $image->tiffImage ) )
            $tiffimg = $image->tiffImage = new PagedTiffImage( $path );
        else
            $tiffimg = $image->tiffImage;

        return $tiffimg;
    }

    /**
     * Returns an Array with the Image-Metadata.
     */
    function getMetaArray( $image ) {
        if ( isset( $image->tiffMetaArray ) )
            return $image->tiffMetaArray;

        $metadata = $image->getMetadata();

        if ( !$this->isMetadataValid( $image, $metadata ) ) {
            wfDebug( "Tiff metadata is invalid or missing, should have been fixed in upgradeRow\n" );
            return false;
        }

        wfProfileIn( __METHOD__ );
        wfSuppressWarnings();
        $image->tiffMetaArray = unserialize( $metadata );
        wfRestoreWarnings();
        wfProfileOut( __METHOD__ );

        return $image->tiffMetaArray;
    }

    /**
     * Get an associative array of page dimensions
     * Currently "width" and "height" are understood, but this might be
     * expanded in the future.
     * Returns false if unknown or if the document is not multi-page.
     */
    function getPageDimensions( $image, $page ) {
        if(!$page) { $page=1; } // makeImageLink2 (Linker.php) sets $page to false if no page parameter in wiki code is set
        $data = $this->getMetaArray( $image );
        return PagedTiffImage::getPageSize( $data, $page );
    }
}
