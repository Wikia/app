<?php

class ImageDropController extends WikiaController {

	const UPLOAD_WARNING = -2;
	const UPLOAD_PERMISSION_ERROR = -1;

	const LEFT = 'left';
	const RIGHT = 'right';

	function upload (){

		$details = null;
		$this->content = 'error';

		$up = new UploadFromFile();
		$up->initializeFromRequest($this->wg->request);
		$permErrors = $up->verifyPermissions( $this->wg->user );

		if ( $permErrors !== true ) {
			$this->status = self::UPLOAD_PERMISSION_ERROR;
			$this->statusMessage = $this->uploadMessage( $this->status, null );
		} else if (empty($this->wg->EnableUploads)) {
			// BugId:6122
			$this->statusMessage = wfMsg('uploaddisabled');
		} else {
			$details = $up->verifyUpload();

			$this->status = (is_array($details) ? $details['status'] : UploadBase::UPLOAD_VERIFICATION_ERROR);
			$this->statusMessage = '';

			if ($this->status > 0) {
				$this->statusMessage = $this->uploadMessage($this->status, $details);
			} else {
				$titleText = $this->request->getVal('title');
				$sectionNumber = $this->request->getVal('section', 0);

				$this->status = $up->performUpload( '', '', '',  $this->wg->user );
				$mainArticle = new Article( Title::newFromText( $titleText ) );

				if ( $sectionNumber == 0 ) {
					$mainArticle->updateArticle(
						$this->getWikiText( $up->getTitle()->getText(), self::LEFT ). $mainArticle->getRawText(), '', false, false);
				} else {
					$firstSectionText = $mainArticle->getSection($mainArticle->getRawText(), $sectionNumber);
					$matches = array();
					if ( preg_match( '/={2,3}[^=]+={2,3}/', $firstSectionText, $matches ) ) {

						$firstSectionText = trim( str_replace( $matches[0], '', $firstSectionText ) );
						$newSectionText =
							$mainArticle->replaceSection(
								$sectionNumber,
								$matches[0]
									."\n"
									.$this->getWikiText( $up->getTitle()->getText(), self::LEFT )
									.$firstSectionText
							);
						$mainArticle->updateArticle($newSectionText, '', false, false);
					}
				}
				$this->content = $this->renderImage( $up->getTitle()->getText(), self::LEFT );
			}
		}
	}

	protected function getWikiText( $filename, $orientation = self::RIGHT ){
		return "[[File:{$filename}|thumb|{$orientation}]]";
	}

	protected function renderImage ( $filename, $orientation = self::RIGHT ){
		$parser = (new Parser);
		$parser->setOutputType( OT_HTML );
		$parserOptions = (new ParserOptions);
		$fakeTitle = new FakeTitle( '');

		return $parser->parse(
				$this->getWikiText( $filename, $orientation ),
				$fakeTitle,
				$parserOptions,
				false
			)->getText();
	}

	protected function uploadMessage($statusCode, $details) {
		$msg = '';
		switch($statusCode) {
			case UploadBase::SUCCESS:
				break;

			case UploadBase::EMPTY_FILE:
				$msg = wfMsgHtml( 'emptyfile' );
				break;

			case UploadBase::MIN_LENGTH_PARTNAME:
				$msg = wfMsgHtml( 'minlength1' );
				break;

			case UploadBase::ILLEGAL_FILENAME:
				$filtered = $details['filtered'];
				$msg = wfMsgWikiHtml( 'illegalfilename', htmlspecialchars( $filtered ) );
				break;

			case UploadBase::OVERWRITE_EXISTING_FILE:
				$msg = $details['overwrite'];
				break;

			case UploadBase::FILETYPE_MISSING:
				$msg = wfMsgExt( 'filetype-missing', array ( 'parseinline' ) );
				break;

			case UploadBase::FILETYPE_BADTYPE:
				$finalExt = $details['finalExt'];
				$msg = wfMsgExt( 'filetype-banned-type',
					array( 'parseinline' ),
					htmlspecialchars( $finalExt ),
					$this->wg->Lang->commaList( $this->wg->FileExtensions ),
					$this->wg->Lang->formatNum( count( $this->wg->FileExtensions) )
				);
				break;

			case UploadBase::VERIFICATION_ERROR:
				$msg = wfMsgHtml($details['details'][0]);
				break;

			case UploadBase::UPLOAD_VERIFICATION_ERROR:
				$msg = $details['error'];
				break;

			case self::UPLOAD_PERMISSION_ERROR:
				$msg = wfMsg( 'badaccess' );
				break;

			default:
				throw new MWException( __METHOD__ . ": Unknown value `{$statusCode}`" );
		}

		return $msg;
	}

	private function uploadWarning($warnings) {
		$msg = '<h2>'.wfMsgHtml('uploadwarning').'</h2><ul class="warning">';

		foreach($warnings as $warning => $args) {
			if( $warning == 'exists' ) {
				$msg .= "\t<li>" . SpecialUpload::getExistsWarning( $args ) . "</li>\n";
			} elseif( $warning == 'duplicate' ) {
				$msg .= SpecialUpload::getDupeWarning( $args );
			} elseif( $warning == 'duplicate-archive' ) {
				$msg .= "\t<li>" . wfMsgExt( 'file-deleted-duplicate', 'parseinline',
					array( Title::makeTitle( NS_FILE, $args )->getPrefixedText() ) )
					. "</li>\n";
			} else {
				if ( $args === true )
					$args = array();
				elseif ( !is_array( $args ) )
					$args = array( $args );
				$msg .= "\t<li>" . wfMsgExt( $warning, 'parseinline', $args ) . "</li>\n";
			}
		}

		$msg .= '</ul>';
		return $msg;
	}
}
