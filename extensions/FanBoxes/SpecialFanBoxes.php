<?php
/**
 * A special page for creating new social userboxes (a.k.a fanboxes a.k.a
 * fantags).
 *
 * @file
 * @ingroup Extensions
 */
class FanBoxes extends SpecialPage {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'UserBoxes' );
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {
		global $wgOut, $wgUser, $wgRequest, $wgHooks, $wgFanBoxScripts;

		// Set it up so that you must be logged in to create a userbox
		if( $wgUser->getID() == 0 ) {
			$wgOut->setPageTitle( wfMsgHtml( 'fanbox-woops-title' ) );
			$login = SpecialPage::getTitleFor( 'Userlogin' );
			$wgOut->redirect( $login->getFullURL( 'returnto=Special:UserBoxes' ) );
			return false;
		}

		// Don't allow blocked users (RT #12589)
		if( $wgUser->isBlocked() ) {
			$wgOut->blockedPage();
			return true;
		}

		// If the database is in read-only mode, bail out
		if( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return true;
		}

		// Extension's CSS & JS
		$wgOut->addScriptFile( $wgFanBoxScripts . '/FanBoxes.js' );
		$wgOut->addExtensionStyle( $wgFanBoxScripts . '/FanBoxes.css' );

		// colorpicker
		$wgOut->addScript( "<script type=\"text/javascript\" src=\"http://yui.yahooapis.com/2.5.2/build/utilities/utilities.js\"></script>\n" );
		$wgOut->addScript( "<script type=\"text/javascript\" src=\"http://yui.yahooapis.com/2.5.2/build/slider/slider-min.js\"></script>\n" );
		$wgOut->addScript( "<link rel=\"stylesheet\" type=\"text/css\" href=\"http://yui.yahooapis.com/2.5.2/build/colorpicker/assets/skins/sam/colorpicker.css\"/>\n" );
		$wgOut->addScript( "<script type=\"text/javascript\" src=\"http://yui.yahooapis.com/2.5.2/build/colorpicker/colorpicker-min.js\"></script>\n" );

		// Add i18n messages as JS globals (this can be removed once we require
		// ResourceLoader/MW 1.17+)
		$wgHooks['MakeGlobalVariablesScript'][] = 'FanBoxes::addJSGlobals';

		$output = '';
		$title = str_replace( '#', '', $wgRequest->getVal( 'wpTitle' ) );
		$fanboxId = $wgRequest->getInt( 'id' );
		$categories = '';

		// Set up the edit fanbox part
		if( $fanboxId ) {
			$title = Title::newFromID( $fanboxId );
			$update_fan = new FanBox( $title );

			// Get categories
			$dbr = wfGetDB( DB_SLAVE );
			$res = $dbr->select(
				'categorylinks',
				'cl_to',
				array( 'cl_from' => intval( $fanboxId ) ),
				__METHOD__
			);

			$fanboxCategory = wfMsgForContent( 'fanbox-userbox-category' );
			foreach( $res as $row ) {
				if(
					$row->cl_to != $fanboxCategory &&
					// @todo FIXME: i18n
					strpos( $row->cl_to, 'Userboxes_by_User_' ) === false
				)
				{
					$categories .= ( ( $categories ) ? ', ' : '' ) . $row->cl_to;
				}
			}

			$output .= "
			<form action=\"\" method=\"post\" name=\"form1\">
			<input type=\"hidden\" name=\"fantag_image_name\" id=\"fantag_image_name\" value=\"{$update_fan->getFanBoxImage()}\">
			<input type=\"hidden\" name=\"textSizeRightSide\" id=\"textSizeRightSide\" value=\"{$update_fan->getFanBoxRightTextSize()}\" >
			<input type=\"hidden\" name=\"textSizeLeftSide\" id=\"textSizeLeftSide\" value=\"{$update_fan->getFanBoxLeftTextSize()}\">
			<input type=\"hidden\" name=\"bgColorLeftSideColor\" id=\"bgColorLeftSideColor\" value=\"{$update_fan->getFanBoxLeftBgColor()}\">
			<input type=\"hidden\" name=\"textColorLeftSideColor\" id=\"textColorLeftSideColor\" value=\"{$update_fan->getFanBoxLeftTextColor()}\">
			<input type=\"hidden\" name=\"bgColorRightSideColor\" id=\"bgColorRightSideColor\" value=\"{$update_fan->getFanBoxRightBgColor()}\">
			<input type=\"hidden\" name=\"textColorRightSideColor\" id=\"textColorRightSideColor\" value=\"{$update_fan->getFanBoxRightTextColor()}\">";

			if( $update_fan->getFanBoxImage() ) {
				$fantag_image_width = 45;
				$fantag_image_height = 53;
				$fantag_image = wfFindFile( $update_fan->getFanBoxImage() );
				$fantag_image_url = '';
				if ( is_object( $fantag_image ) ) {
					$fantag_image_url = $fantag_image->createThumb(
						$fantag_image_width,
						$fantag_image_height
					);
				}
				$fantag_image_tag = '<img alt="" src="' . $fantag_image_url . '" />';
			}

			if( $update_fan->getFanBoxLeftText() == '' ) {
				$fantag_leftside = $fantag_image_tag;
				$fantag_imageholder = $fantag_image_tag;
			} else {
				$fantag_leftside = $update_fan->getFanBoxLeftText();
				$fantag_imageholder = '';
			}

			$leftfontsize = $rightfontsize = '';
			if( $update_fan->getFanBoxLeftTextSize() == 'mediumfont' ) {
				$leftfontsize = '14px';
			}
			if( $update_fan->getFanBoxLeftTextSize() == 'bigfont' ) {
				$leftfontsize = '20px';
			}

			if( $update_fan->getFanBoxRightTextSize() == 'smallfont' ) {
				$rightfontsize = '12px';
			}
			if( $update_fan->getFanBoxRightTextSize() == 'mediumfont' ) {
				$rightfontsize = '14px';
			}

			$output .= "\n" . '<table class="fanBoxTable" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td id="fanBoxLeftSideContainer" bgcolor="' . $update_fan->getFanBoxLeftBgColor() . '">
						<table cellspacing="0" width="55px" height="63px">
							<tr>
							<td id="fanBoxLeftSideOutput2" style="color:' .
								$update_fan->getFanBoxLeftTextColor() .
								'; font-size:' . $leftfontsize . '">' .
								$fantag_leftside .
							'</td>
						</table>
						</td>
					<td id="fanBoxRightSideContainer" bgcolor="' . $update_fan->getFanBoxRightBgColor() . '">
						<table cellspacing="0">
							<tr>
							<td id="fanBoxRightSideOutput2" style="color:' .
								$update_fan->getFanBoxRightTextColor() .
								'; font-size:' . $rightfontsize . '">' .
									$update_fan->getFanBoxRightText() .
							'</td>
						</table>
					</td>
				</table>';

			$output .= '<h1>' . wfMsg( 'fanbox-addtext' ) . '</h1>
				<div class="create-fanbox-text">
					<div id="fanbox-left-text">
						<h3>' . wfMsg( 'fanbox-leftsidetext' ) . "<span id=\"addImage\" onclick=\"FanBoxes.displayAddImage('create-fanbox-image', 'addImage', 'closeImage')\">" .
							wfMsg( 'fanbox-display-image' ) . "</span> <span id=\"closeImage\" onclick=\"FanBoxes.displayAddImage('create-fanbox-image', 'closeImage', 'addImage')\">" .
							wfMsg( 'fanbox-close-image' ) . "</span></h3>
						<input type=\"text\" name=\"inputLeftSide\" id=\"inputLeftSide\" value=\"{$update_fan->getFanBoxLeftText()}\" oninput=\"FanBoxes.displayLeftSide(); FanBoxes.leftSideFanBoxFormat()\" onkeyup=\"FanBoxes.displayLeftSide(); FanBoxes.leftSideFanBoxFormat()\" onkeydown=\"FanBoxes.displayLeftSide(); FanBoxes.leftSideFanBoxFormat()\" onpaste=\"FanBoxes.displayLeftSide(); FanBoxes.leftSideFanBoxFormat()\" onkeypress=\"FanBoxes.displayLeftSide(); FanBoxes.leftSideFanBoxFormat()\" maxlength=\"11\"><br />
						<font size=\"1\">" . wfMsg( 'fanbox-leftsideinstructions' ) . '</font>
					</div>
					<div id="fanbox-right-text">
						<h3>' . wfMsg( 'fanbox-rightsidetext' ) . '<span class="fanbox-right-text-message">' . wfMsg( 'fanbox-charsleft', '<input readonly="readonly" type="text" name="countdown" style="width:20px; height:15px;" value="70" /> ' ) . "</span></h3>
						<input type=\"text\" name=\"inputRightSide\" id=\"inputRightSide\" style=\"width:350px\" value=\"{$update_fan->getFanBoxRightText()}\" oninput=\"FanBoxes.displayRightSide();
						rightSideFanBoxFormat()\"
						onkeydown=\"FanBoxes.limitText(this.form.inputRightSide,this.form.countdown,70); FanBoxes.displayRightSide(); FanBoxes.rightSideFanBoxFormat()\"
						onkeyup=\"FanBoxes.limitText(this.form.inputRightSide,this.form.countdown,70); FanBoxes.displayRightSide(); FanBoxes.rightSideFanBoxFormat()\"
						onpaste=\"FanBoxes.limitText(this.form.inputRightSide,this.form.countdown,70); FanBoxes.displayRightSide(); FanBoxes.rightSideFanBoxFormat()\"
						onkeypress=\"FanBoxes.limitText(this.form.inputRightSide,this.form.countdown,70); FanBoxes.displayRightSide(); FanBoxes.rightSideFanBoxFormat()\"
						maxlength=\"70\" /><br />
						<font size=\"1\">" . wfMsg( 'fanbox-rightsideinstructions' ) . '</font>
					</div>
					</form>
				</div>';

			$output .= '
					<div id="create-fanbox-image" class="create-fanbox-image">
						<h1>' . wfMsg( 'fanbox-leftsideimage' ) . ' <font size="1">' . wfMsg( 'fanbox-leftsideimageinstructions' ) . " </font></h1>
						<div id=\"fanbox_image\" onclick=\"FanBoxes.insertImageToLeft()\">$fantag_imageholder</div>
						<div id=\"fanbox_image2\"> </div>
						<div id=\"real-form\" style=\"display:block;height:70px;\">
						<iframe id=\"imageUpload-frame\" class=\"imageUpload-frame\" width=\"700\"
							scrolling=\"no\" frameborder=\"0\" src=\"" .
							SpecialPage::getTitleFor( 'FanBoxAjaxUpload' )->escapeFullURL() . '">
						</iframe>
						</div>
					</div>';

			$output .= $this->colorPickerAndCategoryCloud( $categories );

			$output .= '<div class="create-fanbox-buttons">
				<input type="button" class="site-button" value="' .
					wfMsg( 'fanbox-update-button' ) .
					'" size="20" onclick="FanBoxes.createFantagSimple()" />
			</div>';
		}

		// Set it up so that the page title includes the title of the red link that the user clicks on
		$destination = $wgRequest->getVal( 'destName' );
		$page_title = wfMsg( 'fan-addfan-title' );
		if( $destination ) {
			$page_title = wfMsg( 'fan-createfor', str_replace( '_', ' ', $destination ) );
		}
		if( $fanboxId ) {
			$page_title = wfMsg( 'fan-updatefan', str_replace( '_', ' ', $update_fan->getName() ) );
		}

		$wgOut->setPageTitle( $page_title );

		// Set it up so that the title of the page the user creates using the create form ends
		// up being the title of the red link he clicked on to get to the create form
		if( $destination ) {
			$title = $destination;
		}

		if( !$fanboxId ) {
			$output .= '<div class="lr-right">' .
				wfMsgExt( 'userboxes-instructions', 'parse' ) .
			'</div>

			<form action="" method="post" name="form1">
			<input type="hidden" name="fantag_image_name" id="fantag_image_name" />
			<input type="hidden" name="fantag_imgname" id="fantag_imgname" />
			<input type="hidden" name="fantag_imgtag" id="fantag_imgtag" />
			<input type="hidden" name="textSizeRightSide" id="textSizeRightSide" />
			<input type="hidden" name="textSizeLeftSide" id="textSizeLeftSide" />
			<input type="hidden" name="bgColorLeftSideColor" id="bgColorLeftSideColor" value="" />
			<input type="hidden" name="textColorLeftSideColor" id="textColorLeftSideColor" value="" />
			<input type="hidden" name="bgColorRightSideColor" id="bgColorRightSideColor" value="" />
			<input type="hidden" name="textColorRightSideColor" id="textColorRightSideColor" value="" />';

			if( !$destination ) {
				$output .= '<h1>' . wfMsg( 'fanbox-title' ) . '</h1>
					<div class="create-fanbox-title">
						<input type="text" name="wpTitle" id="wpTitle" value="' .
							$wgRequest->getVal( 'wpTitle' ) .
							'" style="width:350px" maxlength="60" /><br />
						<font size="1">(' . wfMsg( 'fanboxes-maxchars-sixty' ) . ')</font><br />
					</div>';
			} else {
				$output .= Html::hidden( 'wpTitle', $destination, array( 'id' => 'wpTitle' ) );
			}

			$output .= '<table class="fanBoxTable" border="0" cellpadding="0" cellspacing="0">
				<tr>
				<td id="fanBoxLeftSideContainer">
					<table cellspacing="0" width="55px" height="63px">
						<tr>
							<td id="fanBoxLeftSideOutput2"></td>
						</tr>
					</table>
				</td>
				<td id="fanBoxRightSideContainer">
					<table cellspacing="0" width="212px" height="63px">
						<tr>
							<td id="fanBoxRightSideOutput2"></td>
						</tr>
					</table>
				</td>
				</tr>
			</table>' . "\n";

			$output.= '<h1>' . wfMsg( 'fanbox-addtext' ) . '</h1>
				<div class="create-fanbox-text">
					<div id="fanbox-left-text">
						<h3>' . wfMsg( 'fanbox-leftsidetext' ) . "<span id=\"addImage\" onclick=\"FanBoxes.displayAddImage('create-fanbox-image', 'addImage', 'closeImage')\">" . wfMsg( 'fanbox-display-image' ) . "</span> <span id=\"closeImage\" onclick=\"FanBoxes.displayAddImage('create-fanbox-image', 'closeImage', 'addImage')\">" . wfMsg( 'fanbox-close-image' ) . '</span></h3>
						<input type="text" name="inputLeftSide" id="inputLeftSide" oninput="FanBoxes.displayLeftSide(); FanBoxes.leftSideFanBoxFormat()" onkeyup="FanBoxes.displayLeftSide(); FanBoxes.leftSideFanBoxFormat()" onkeydown="FanBoxes.displayLeftSide(); FanBoxes.leftSideFanBoxFormat()" onpaste="FanBoxes.displayLeftSide(); FanBoxes.leftSideFanBoxFormat()" onkeypress="FanBoxes.displayLeftSide(); FanBoxes.leftSideFanBoxFormat()"
						maxlength="11" /><br />
						<font size="1">' . wfMsgForContent( 'fanbox-leftsideinstructions' ) . '</font>
					</div>
					<div id="fanbox-right-text">
					<h3>' . wfMsgForContent( 'fanbox-rightsidetext' ) . '<span id="countdownbox"> <span class="fanbox-right-text-message">'
						. wfMsg( 'fanbox-charsleft', '<input readonly="readonly" type="text" name="countdown" style="width:20px; height:15px;" value="70" />' ) . '</span></span></h3>
						<input type="text" name="inputRightSide" id="inputRightSide" style="width:350px" oninput="FanBoxes.displayRightSide();
						FanBoxes.rightSideFanBoxFormat()"
						onkeydown="FanBoxes.limitText(this.form.inputRightSide,this.form.countdown,70); FanBoxes.displayRightSide(); FanBoxes.rightSideFanBoxFormat()"
						onkeyup="FanBoxes.limitText(this.form.inputRightSide,this.form.countdown,70); FanBoxes.displayRightSide(); FanBoxes.rightSideFanBoxFormat()"
						onpaste="FanBoxes.limitText(this.form.inputRightSide,this.form.countdown,70); FanBoxes.displayRightSide(); FanBoxes.rightSideFanBoxFormat()"
						onkeypress="FanBoxes.limitText(this.form.inputRightSide,this.form.countdown,70); FanBoxes.displayRightSide(); FanBoxes.rightSideFanBoxFormat()"
						maxlength="70" /><br />
						<font size="1">' . wfMsg( 'fanbox-rightsideinstructions' ) . '</font>
					</div>
					<div class="cleared"></div>
					</form>
				</div>';

			$output .= '<div id="create-fanbox-image" class="create-fanbox-image">
						<h1>' . wfMsg( 'fanbox-leftsideimage' ) .
							' <font size="1">' .
							wfMsgForContent( 'fanbox-leftsideimageinstructions' ) .
							' </font></h1>
						<div id="fanbox_image" onclick="FanBoxes.insertImageToLeft()"></div>
						<div id="fanbox_image2"></div>

						<div id="real-form" style="display: block; height: 70px;">
						<iframe id="imageUpload-frame" class="imageUpload-frame" width="700"
							scrolling="no" frameborder="0" src="' . SpecialPage::getTitleFor( 'FanBoxAjaxUpload' )->escapeFullURL() . '">
						</iframe>
						</div>
					</div>';

			$output .= $this->colorPickerAndCategoryCloud( $categories );

			$output .= '<div class="create-fanbox-buttons">
				<input type="button" class="site-button" value="' . wfMsg( 'fanbox-create-button' ) . '" size="20" onclick="FanBoxes.createFantag()" />
			</div>';
		}

		$wgOut->addHTML( $output );

		// Send values to database and create fantag page when form is submitted
		if( $wgRequest->wasPosted() ) {
			if( !$fanboxId ) {
				$fan = FanBox::newFromName( $title );
				$fantagId = $fan->addFan(
					$wgRequest->getVal( 'inputLeftSide' ),
					$wgRequest->getVal( 'textColorLeftSideColor' ),
					$wgRequest->getVal( 'bgColorLeftSideColor' ),
					$wgRequest->getVal( 'inputRightSide' ),
					$wgRequest->getVal( 'textColorRightSideColor' ),
					$wgRequest->getVal( 'bgColorRightSideColor' ),
					$wgRequest->getVal( 'fantag_image_name' ),
					$wgRequest->getVal( 'textSizeLeftSide' ),
					$wgRequest->getVal( 'textSizeRightSide' ),
					$wgRequest->getVal( 'pageCtg' )
				);
				$fan->addUserFan( $fantagId );
				$wgOut->redirect( $fan->title->getFullURL() );
			}
			if( $fanboxId ) {
				$title = Title::newFromID( $fanboxId );
				$update_fan = new FanBox( $title );
				$update_fan->updateFan(
					$wgRequest->getVal( 'inputLeftSide' ),
					$wgRequest->getVal( 'textColorLeftSideColor' ),
					$wgRequest->getVal( 'bgColorLeftSideColor' ),
					$wgRequest->getVal( 'inputRightSide' ),
					$wgRequest->getVal( 'textColorRightSideColor' ),
					$wgRequest->getVal( 'bgColorRightSideColor' ),
					$wgRequest->getVal( 'fantag_image_name' ),
					$wgRequest->getVal( 'textSizeLeftSide' ),
					$wgRequest->getVal( 'textSizeRightSide' ),
					$fanboxId,
					$wgRequest->getVal( 'pageCtg' )
				);
				$wgOut->redirect( $update_fan->title->getFullURL() );
			}
		}
	}

	function colorPickerAndCategoryCloud( $categories ) {
		$output = '<div class="add-colors">
					<h1>' . wfMsg( 'fan-add-colors' ) . '</h1>
					<div id="add-colors-left">
						<form name="colorpickerradio" action="">
						<input type="radio" name="colorpickerchoice" value="leftBG" checked="checked" />' .
							wfMsg( 'fanbox-leftbg-color' ) .
						'<br />
						<input type="radio" name="colorpickerchoice" value="leftText" />' .
							wfMsg( 'fanbox-lefttext-color' ) .
						'<br />
						<input type="radio" name="colorpickerchoice" value="rightBG" />' .
							wfMsg( 'fanbox-rightbg-color' ) .
						'<br />
						<input type="radio" name="colorpickerchoice" value="rightText" />' .
						wfMsg( 'fanbox-righttext-color' ) . "
						</form>
					</div>

					<div id=\"add-colors-right\">
					<div id=\"colorpickerholder\"></div>
					</div>

						<script type=\"text/javascript\">
						var colorPickerTest = new YAHOO.widget.ColorPicker( 'colorpickerholder', {
							showhsvcontrols: true,
							showhexcontrols: true,
							images: {
								PICKER_THUMB: 'http://developer.yahoo.com/yui/build/colorpicker/assets/picker_thumb.png',
								HUE_THUMB: 'http://developer.yahoo.com/yui/build/colorpicker/assets/hue_thumb.png'
							}
						});

						colorPickerTest.on( 'rgbChange', function( p_oEvent ) {
							var sColor = '#' + this.get( 'hex' );

							if( document.colorpickerradio.colorpickerchoice[0].checked ) {
								document.getElementById( 'fanBoxLeftSideOutput2' ).style.backgroundColor = sColor;
								// The commented-out line below is the original NYC code but I noticed that it doesn't work
								//document.getElementById( 'fanBoxLeftSideContainer' ).style.backgroundColor = sColor;
								document.getElementById( 'bgColorLeftSideColor' ).value = sColor;
							}

							if( document.colorpickerradio.colorpickerchoice[1].checked ) {
								document.getElementById( 'fanBoxLeftSideOutput2' ).style.color = sColor;
								document.getElementById( 'textColorLeftSideColor' ).value = sColor;
							}

							if( document.colorpickerradio.colorpickerchoice[2].checked ) {
								document.getElementById( 'fanBoxRightSideOutput2' ).style.backgroundColor = sColor;
								// The commented-out line below is the original NYC code but I noticed that it doesn't work
								//document.getElementById( 'fanBoxRightSideContainer' ).style.backgroundColor = sColor;
								document.getElementById( 'bgColorRightSideColor' ).value = sColor;
							}

							if( document.colorpickerradio.colorpickerchoice[3].checked ) {
								document.getElementById( 'fanBoxRightSideOutput2' ).style.color = sColor;
								document.getElementById( 'textColorRightSideColor' ).value = sColor;
							}
						});
						</script>
						<div class=\"cleared\"></div>
					</div>";

		// Category cloud stuff
		$cloud = new TagCloud( 10 );
		$categoriesLabel = wfMsg( 'fanbox-categories-label' );
		$categoriesHelpText = wfMsg( 'fanbox-categories-help' );

		$output .= '<div class="category-section">';
		$tagcloud = '<div id="create-tagcloud" style="line-height: 25pt; width: 600px; padding-bottom: 15px;">';
		$tagnumber = 0;
		$tabcounter = 1;
		foreach( $cloud->tags as $tag => $att ) {
			$tag = str_replace( 'Fans', '', $tag );
			$tag = trim( $tag );
			$slashedTag = $tag; // define variable
			// Fix for categories that contain an apostrophe
			if ( strpos( $tag, "'" ) ) {
				$slashedTag = str_replace( "'", "\'", $tag );
			}
			$tagcloud .= " <span id=\"tag-{$tagnumber}\" style=\"font-size:{$cloud->tags[$tag]['size']}{$cloud->tags_size_type}\">
				<a style='cursor:hand;cursor:pointer;text-decoration:underline' onclick=\"javascript:FanBoxes.insertTag('" . $slashedTag . "',{$tagnumber});\">{$tag}</a>
			</span>\n";
			$tagnumber++;
		}

		$tagcloud .= '</div>';
		$output .= '<div class="create-category-title">';
		$output .= "<h1>$categoriesLabel</h1>";
		$output .= '</div>';
		$output .= "<div class=\"categorytext\">$categoriesHelpText</div>";
		$output .= $tagcloud;
		$output .= '<textarea class="createbox" tabindex="' . $tabcounter . '" accesskey="," name="pageCtg" id="pageCtg" rows="2" cols="80">' .
			$categories . '</textarea><br /><br />';
		$output .= '</div>';

		return $output;
	}

	/**
	 * Add some new JS globals into the page output. This can be replaced by
	 * ResourceLoader in the future.
	 *
	 * @param $vars Array: array of pre-existing JS globals
	 * @return Boolean: true
	 */
	public static function addJSGlobals( Array &$vars ) {
		$vars['__FANBOX_MUSTENTER_LEFT__'] = wfMsg( 'fanbox-mustenter-left' );
		$vars['__FANBOX_MUSTENTER_RIGHT__'] = wfMsg( 'fanbox-mustenter-right' );
		$vars['__FANBOX_MUSTENTER_RIGHT_OR__'] = wfMsg( 'fanbox-mustenter-right-or' );
		$vars['__FANBOX_MUSTENTER_TITLE__'] = wfMsg( 'fanbox-mustenter-title' );
		$vars['__FANBOX_HASH__'] = wfMsg( 'fanbox-hash' );
		$vars['__FANBOX_CHOOSE_ANOTHER__'] = wfMsg( 'fanbox-choose-another' );
		$vars['__FANBOX_UPLOAD_NEW_IMAGE__'] = wfMsg( 'fanbox-upload-new-image' );
		return true;
	}
}
