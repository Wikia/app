<?php
/**
 * Class WikiaMapsBaseController
 */
class WikiaMapsBaseController extends WikiaController {

	const MAP_PREVIEW_WIDTH = 660;
	const POI_CATEGORY_MARKER_WIDTH = 60;
	const IMAGE_ORIGINAL = 0;
	const IMAGE_THUMBNAIL = 1;

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
		$upload = new WikiaMapsUploadImageFromFile();
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

			if ( $file instanceof WikiaUploadStashFile && $file->exists() ) {
				$uploadStatus[ 'success' ] = true;

				// $originalHeight = $file->getHeight();
				// $imageServing = new ImageServing( null, $originalWidth );
				// $uploadStatus[ 'fileUrl' ] = $imageServing->getUrl( $file, $originalWidth, $originalHeight );

				// OK, so I couldn't use ImageService because it works only on uploaded files
				// image serving worked with stashed files but it cuts it in a weird way
				// not to block this any longer I came with the line below but we need to sort it out
				// and write in a cleaner way
				// TODO: Talk to Platform Team about adding possibility to add stashed files via ImageService

				$uploadStatus[ 'fileUrl' ] = $this->getStashedImage( $file );

				switch ( $uploadType ) {
					case WikiaMapsUploadImageFromFile::UPLOAD_TYPE_MAP:
						$thumbWidth = self::MAP_PREVIEW_WIDTH;
						break;

					case WikiaMapsUploadImageFromFile::UPLOAD_TYPE_POI_CATEGORY_MARKER:
						$thumbWidth = self::POI_CATEGORY_MARKER_WIDTH;
						break;
				}

				$uploadStatus[ 'fileThumbUrl' ] = $this->getStashedImage( $file, self::IMAGE_THUMBNAIL, $thumbWidth );
			} else {
				$uploadStatus[ 'success' ] = false;
			}
		}

		$this->setVal( 'results', $uploadStatus );
	}

	/**
	 * Creates stashed image url and returns it
	 *
	 * @param WikiaUploadStashFile $file
	 * @param int $type Image type to return IMAGE_ORIGINAL or IMAGE_THUMBNAIL
	 * @param int $width optional width of the thumbnail
	 *
	 * @return String image url
	 *
	 * @throws MWException
	 */
	public function getStashedImage( WikiaUploadStashFile $file, $type = self::IMAGE_ORIGINAL, $width = 200 ) {
		if( $type === self::IMAGE_ORIGINAL ) {
			$url = $file->getOriginalFileUrl();
		} else if( $type === self::IMAGE_THUMBNAIL ) {
			$url = $file->getThumbUrl( $width . "px-" . $file->getName() );
		} else {
			throw new MWException( 'Invalid $type parameter' );
		}

		return wfReplaceImageServer( $url );
	}

	/**
	 * Maps error status code to an error message
	 * @param Integer $errorStatus error code status returned from UploadBase method
	 * @return String
	 */
	private function translateError( $errorStatus ) {
		switch ( $errorStatus ) {
			case UploadBase::FILE_TOO_LARGE:
				$maxSize = $this->wg->Lang->formatSize( $this->wg->MaxUploadSize );
				$errorMessage = wfMessage( 'wikia-interactive-maps-image-uploads-error-file-too-large', $maxSize )->plain();
				break;
			case UploadBase::EMPTY_FILE:
				$errorMessage = wfMessage( 'wikia-interactive-maps-image-uploads-error-empty-file' )->plain();
				break;
			case UploadBase::FILETYPE_BADTYPE:
			case UploadBase::VERIFICATION_ERROR:
				$errorMessage = wfMessage( 'wikia-interactive-maps-image-uploads-error-bad-type' )->plain();
				break;
			case WikiaMapsUploadImageFromFile::POI_CATEGORY_MARKER_IMAGE_TOO_SMALL_ERROR:
				$errorMessage = wfMessage(
					'wikia-interactive-maps-image-uploads-error-poi-category-marker-too-small',
					WikiaMapsUploadImageFromFile::POI_CATEGORY_MARKER_IMAGE_MIN_SIZE
				)->plain();
				break;
			default:
				$errorMessage = wfMessage( 'wikia-interactive-maps-image-uploads-error' )->parse();
				break;
		}

		return $errorMessage;
	}

	/**
	 * Simple getter
	 *
	 * @return WikiaMaps
	 */
	public function getModel() {
		return $this->mapsModel;
	}

	/**
	 * Returns true if a user is allowed to use maps
	 *
	 * @return bool
	 */
	public function isUserAllowed() {
		return $this->wg->User->isLoggedIn() && !$this->wg->User->isBlocked();
	}

	/**
	 * Returns true if a user has right to remove a map or map's items
	 *
	 * @return bool
	 */
	public function canUserDelete() {
		return $this->wg->User->isAllowed( 'canremovemap' );
	}

	/**
	 * Returns true if a user is map creator of a map
	 *
	 * @param Integer $mapId
	 *
	 * @return bool
	 */
	public function isUserMapCreator( $mapId ) {
		$mapData = $this->getModel()->getMapByIdFromApi( $mapId );
		return $this->wg->User->getName() === $mapData->created_by;
	}

	/**
	 * Temporary change required for ad purpose - https://wikia-inc.atlassian.net/browse/DAT-4051.
	 * We need to limit contribution options on protected maps related to the ad campaign only to stuff
	 * users.
	 * @todo: remove this as a part of https://wikia-inc.atlassian.net/browse/DAT-4055
	 *
	 * @param Integer $mapId
	 * @return bool
	 */
	protected function shouldDisableProtectedMapEdit( $mapId ) {
		$IntMapConfig = $this->wg->IntMapConfig;

		return array_key_exists( 'protectedMaps', $IntMapConfig ) &&
			array_key_exists($mapId, $IntMapConfig[ 'protectedMaps' ]) &&
			$this->wg->User->isStaff() === false;
	}
}
