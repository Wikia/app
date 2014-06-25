<?php
/**
 * Class WikiaInteractiveMapsBaseController
 */
class WikiaInteractiveMapsBaseController extends WikiaController {

	const MAP_PREVIEW_WIDTH = 660;
	const POI_CATEGORY_MARKER_WIDTH = 60;

	/**
	 * @var WikiaMaps
	 */
	protected $mapsModel;

	/**
	 * Keeps data needed while creating map/tile/poi process
	 * @var Array
	 */
	protected $data;

	public function __construct() {
		parent::__construct();
		$this->mapsModel = new WikiaMaps( $this->wg->IntMapConfig );
	}

	/**
	 * Getter for data we don't want expose outside
	 *
	 * @param String $name name of the data key
	 * @param Bool $default
	 *
	 * @return Mixed
	 */
	protected function getData( $name, $default = false ) {
		if( isset( $this->data[ $name ] ) ) {
			return $this->data[ $name ];
		}

		return $default;
	}

	/**
	 * Setter of data we don't want expose outside
	 *
	 * @param String $name
	 * @param Mixed $value
	 */
	protected function setData( $name, $value ) {
		$this->data[ $name ] = $value;
	}

	/**
	 * Returns all data
	 * @return Array
	 */
	protected function getAllData() {
		return $this->data;
	}

	/**
	 * Upload a file entry point
	 */
	public function upload() {
		$uploadType = $this->request->getVal( 'uploadType' );
		$upload = new WikiaInteractiveMapsUploadImageFromFile();
		$upload->initializeFromRequest( $this->wg->Request );
		$uploadResults = $upload->verifyUpload( $uploadType );
		$uploadStatus = [ 'success' => false ];

		if ( empty( $this->wg->EnableUploads ) ) {
			$uploadStatus[ 'errors' ] = [ wfMessage( 'wikia-interactive-maps-image-uploads-disabled' )->plain() ];
		} else if ( $uploadResults[ 'status' ] !== UploadBase::OK ) {
			$uploadStatus[ 'errors' ] = [ $this->translateError( $uploadResults[ 'status' ] ) ];
		} else if ( ( $warnings = $upload->checkWarnings() ) && !empty( $warnings ) ) {
			$uploadStatus[ 'errors' ] = [ wfMessage( 'wikia-interactive-maps-image-uploads-warning' )->parse() ];
		} else {
			//save temp file
			$file = $upload->stashFile();

			if ( $file instanceof File && $file->exists() ) {
				$uploadStatus[ 'success' ] = true;
				$originalWidth = $file->getWidth();

				// $originalHeight = $file->getHeight();
				// $imageServing = new ImageServing( null, $originalWidth );
				// $uploadStatus[ 'fileUrl' ] = $imageServing->getUrl( $file, $originalWidth, $originalHeight );

				// OK, so I couldn't use ImageService because it works only on uploaded files
				// image serving worked with stashed files but it cuts it in a weird way
				// not to block this any longer I came with the line below but we need to sort it out
				// and write in a cleaner way
				// TODO: Talk to Platform Team about adding possibility to add stashed files via ImageService

				$uploadStatus[ 'fileUrl' ] = $this->getStashedImageThumb( $file, $originalWidth );

				switch ( $uploadType ) {
					case WikiaInteractiveMapsUploadImageFromFile::UPLOAD_TYPE_MAP:
						$thumbWidth = self::MAP_PREVIEW_WIDTH;
						break;

					case WikiaInteractiveMapsUploadImageFromFile::UPLOAD_TYPE_POI_CATEGORY_MARKER:
						$thumbWidth = self::POI_CATEGORY_MARKER_WIDTH;
						break;
				}

				$uploadStatus[ 'fileThumbUrl' ] = $this->getStashedImageThumb( $file, $thumbWidth );
			} else {
				$uploadStatus[ 'success' ] = false;
			}
		}

		$this->setVal( 'results', $uploadStatus );
	}

	/**
	 * Creates stashed image's thumb url and returns it
	 *
	 * @param File $file stashed upload file
	 * @param Integer $width width of the thumbnail
	 *
	 * @return String
	 */
	private function getStashedImageThumb( $file, $width ) {
		return wfReplaceImageServer( $file->getThumbUrl( $width . "px-" . $file->getName() ) );
	}

	/**
	 * Maps error status code to an error message
	 * @param Integer $errorStatus error code status returned from UploadBase method
	 * @return String
	 */
	private function translateError( $errorStatus ) {
		switch ( $errorStatus ) {
			case UploadBase::FILE_TOO_LARGE:
				$errorMessage = wfMessage( 'wikia-interactive-maps-image-uploads-error-file-too-large', $this->getMaxFileSize() )->plain();
				break;
			case UploadBase::EMPTY_FILE:
				$errorMessage = wfMessage( 'wikia-interactive-maps-image-uploads-error-empty-file' )->plain();
				break;
			case UploadBase::FILETYPE_BADTYPE:
			case UploadBase::VERIFICATION_ERROR:
				$errorMessage = wfMessage( 'wikia-interactive-maps-image-uploads-error-bad-type' )->plain();
				break;
			case WikiaInteractiveMapsUploadImageFromFile::POI_CATEGORY_MARKER_IMAGE_TOO_SMALL_ERROR:
				$errorMessage = wfMessage(
					'wikia-interactive-maps-image-uploads-error-poi-category-marker-too-small',
					WikiaInteractiveMapsUploadImageFromFile::POI_CATEGORY_MARKER_IMAGE_MIN_SIZE
				)->plain();
				break;
			default:
				$errorMessage = wfMessage( 'wikia-interactive-maps-image-uploads-error' )->parse();
				break;
		}

		return $errorMessage;
	}

	/**
	 * Returns max upload file size in MB (gets it from config)
	 * @return float
	 * @todo Extract it somewhere to includes/wikia/
	 */
	private function getMaxFileSize() {
		return $this->wg->MaxUploadSize / 1024 / 1024;
	}
}
