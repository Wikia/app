<?php
/**
 * Script to upload image and description from Special:Promote to Curated Content
 * Usage: run in context of a given wiki
 * SERVER_ID=wiki_id php SpecialPromoteToCuratedContentMigrator.php
 *
 * @ingroup Maintenance
 */

require_once( dirname( __FILE__ ) . '/../../../../maintenance/Maintenance.php' );

class SpecialPromoteToCuratedContentMigrator extends Maintenance {
	public function __construct() {
		$this->addOption( 'dry-run', 'Dry run - do not save changes to curated content' );
		parent::__construct();
	}

	public function execute() {
		global $wgCityId, $wgLang, $wgDBname;

		$dryRun = $this->hasOption('dry-run');

		$change = false;
		$cv = new CityVisualization();
		$communityDataService = new CommunityDataService( $wgCityId );

		$curatedContentData = [
			'curated' => $communityDataService->getCurated(),
			'featured' => $communityDataService->getFeatured(),
			'optional' => $communityDataService->getOptional(),
			'community_data' => $communityDataService->getCommunityData()
		];

		if ( empty( $curatedContentData['community_data']['description'] ) ) {
			$originalDescription = '';
			// updateDescription
			$description = $this->getPromoteDescription( $cv, $wgCityId, $wgLang->getCode() );
		} else {
			$originalDescription = $curatedContentData['community_data']['description'];
		}

		if ( empty( $curatedContentData['community_data']['image_id'] ) ) {
			$originalImageId = $curatedContentData['community_data']['image_id'];

			// fetch image Id for update from corporate wiki for a given language
			$image = ( new PromoImage( PromoImage::MAIN, $wgDBname ) );
			$corporateWikiId = $cv->getTargetWikiId( $wgLang->getCode() );
			$originFile = $image->getOriginFile($corporateWikiId);
			$imageName = $image->getPathname();
			$imageTitle = $originFile->getTitle();
			$imageUrl = $originFile->getUrl();
			$imageId = $imageTitle->exists() ? $imageTitle->getArticleID() : null;

			if ( !empty( $imageId ) ) {
				// image exists on the corporate site. Since it's the final source of truth
				// for apps (and unapproved images cannot be there) we upload it to the local wiki
				// we first need to fetch it from the corporate wiki
				// and now we upload it, disabling the Special:Promote upload prevention
				// implemented as validation hook
				$this->disableUploadValidationHook();
				$result = $this->uploadImageToLocalWiki( $imageName, $imageUrl );

				if ( !empty( $result['page_id'] ) ) {
					$imageId = $result['page_id'];
				} else {
					$this->output( 'Upload failed: ' . serialize( $result ) );
				}
			} else {
				// image may exist on the local wiki, we use it as fallback
				$imageTitle = $image->getOriginFile()->getTitle();
				$imageId = $imageTitle->exists() ? $imageTitle->getArticleID() : null;
			}

		}

		if(!empty($description)) {
			$curatedContentData['community_data']['description'] = $description;
			$this->output( sprintf(
					"\nPreparing to update description from:\n%s\nto\n%s\n",
					empty( $originalDescription ) ? "''" : $originalDescription,
					$description)
			);
			$change = true;
		}

		if(!empty($imageId)) {
			$curatedContentData['community_data']['image_id'] = $imageId;
			$this->output( sprintf(
					"\nPreparing to update image from %d to %d\n",
					$originalImageId,
					$imageId)
			);
			$change = true;
		}

		if ( $dryRun ) {
			$this->output( "\nDRY RUN: Skipping save of Curated Content\n" );
		} else {
			if ( $change ) {
				$this->output( "\nSaving Curated Content\n" );
				$result = $communityDataService->setCuratedContent( $curatedContentData );
				if ( $result ) {
					$this->output( "Success!\n" );
				} else {
					$this->output( "FAILED!\n" );
				}
			} else {
				$this->output( "\nNO change in Curated Content\n" );
			}
		}
		$this->output( "\n" );
		$this->output( "Done\n" );
	}

	/**
	 * @param $cv CityVisualization
	 * @param $cityId int
	 * @param $langCode string
	 * @return mixed
	 */
	private function getPromoteDescription( $cv, $cityId, $langCode ) {
		$data = $cv->getWikiData( $cityId, $langCode, new WikiGetDataForVisualizationHelper() );

		if ( !empty( $data['description'] ) ) {
			$description = $data['description'];
			return $description;
		}

		return null;
	}

	/**
	 * For a one-time script it does not make sense to extract logic in this method for reuse
	 * @see fixVisualizationImage.php
	 */
	private function disableUploadValidationHook() {
		global $wgHooks;

		$SPECIAL_UPLOAD_VERIFICATION = "UploadVisualizationImageFromFile::UploadVerification";
		$UPLOAD_VERIFICATION_KEY = "UploadVerification";

		if ( in_array( $SPECIAL_UPLOAD_VERIFICATION, $wgHooks[$UPLOAD_VERIFICATION_KEY] ) ) {
			$idx = array_search( $SPECIAL_UPLOAD_VERIFICATION, $wgHooks[$UPLOAD_VERIFICATION_KEY] );
			$this->output( sprintf( "Deleting upload verification hook %d\n", $idx ) );
			unset( $wgHooks['UploadVerification'][$idx] );
		}
	}

	/**
	 * @param $imageName string
	 * @param $imageUrl string
	 * @return array
	 */
	private function uploadImageToLocalWiki( $imageName, $imageUrl ) {
		$uploadOptions = new StdClass();
		$uploadOptions->name = $imageName;
		$uploadOptions->comment = wfMessage( 'wikiacuratedcontent-image-upload-comment' )->inContentLanguage()->escaped();
		$uploadOptions->description = wfMessage( 'wikiacuratedcontent-image-upload-description' )->inContentLanguage()->escaped();
		$wikiaBotUser = User::newFromName( 'WikiaBot' );

		$result = ImagesService::uploadImageFromUrl( $imageUrl, $uploadOptions, $wikiaBotUser );
		return $result;
	}
}

$maintClass = 'SpecialPromoteToCuratedContentMigrator';
require_once( RUN_MAINTENANCE_IF_MAIN );
