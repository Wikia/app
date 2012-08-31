package com.wikia.webdriver.PageObjects.PageObject.WikiPage;

import java.util.ArrayList;
import java.util.List;

import org.openqa.selenium.By;
import org.openqa.selenium.Keys;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.PageFactory;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.support.ui.Select;

import com.wikia.webdriver.Common.Core.CommonFunctions;
import com.wikia.webdriver.Common.Logging.PageObjectLogging;


public class WikiArticleEditMode extends WikiArticlePageObject {

	@FindBy(css="div.reset[id='ImageUpload']")
	private WebElement ImageUploadModal;
	@FindBy(css="textarea[id='ImageUploadCaption']")
	private WebElement CaptionTextArea;
	@FindBy(css="div.cke_skin_wikia.visible div.cke_contents iframe")
	private WebElement VisualModeIFrame;
	@FindBy(css="textarea.cke_source")
	private WebElement SourceModeTextArea;
	@FindBy(css="textarea.yui-ac-input")
	private WebElement MessageSourceModeTextArea;
	@FindBy(css="div.cke_wrapper.cke_ltr div.cke_contents iframe")
	private WebElement iFrame;
	@FindBy(css="header.WikiaHeader")
	private WebElement header;
	@FindBy(css="tr.ImageUploadFindLinks td a")
	private WebElement AddThisPhotoLink;
	@FindBy(css="div.details input")
	private WebElement AddPhotoButton;
	@FindBy(css="div.module_content nav.buttons nav.wikia-menu-button a")
	private WebElement PreviewButton;
	@FindBy(css="div.neutral.modalToolbar a[id='publish']")
	private WebElement PublishButtonPreview;
	@FindBy(css="span.cke_button_ModeSource span.cke_label")
	private WebElement SourceModeButton;
	@FindBy(css="input.control-button")
	private WebElement PublishButtonGeneral;
	@FindBy(css="span.RTEMediaOverlayEdit")
	private WebElement ModifyButton;
	@FindBy(css="span.RTEMediaOverlayDelete")
	private WebElement RemoveButton;
	@FindBy(css="div.RTEConfirmButtons a[id='RTEConfirmCancel'] span")
	private WebElement CancelImageRemovalButton;
	@FindBy(css="a[id='RTEConfirmOk'] span")
	private WebElement OKbutton;
	@FindBy(css="section[id='WikiaPhotoGalleryEditor']")
	private WebElement ObjectModal;
	@FindBy(css="a[id='WikiaPhotoGallerySearchResultsSelect']")
	private WebElement GalleryDialogSelectButton;
	@FindBy(css="a[id='WikiaPhotoGalleryEditorSave']")
	private WebElement GalleryDialogFinishButton;
	@FindBy(css="input[id='VideoEmbedUrl']")
	private WebElement VideoModalInput;
	@FindBy(css="a[id='VideoEmbedUrlSubmit']")
	private WebElement VideoNextButton;
	@FindBy(css="input[id='VideoEmbedCaption']")
	private WebElement VideoCaptionTextArea;
	@FindBy(css="tr.VideoEmbedNoBorder input.wikia-button")
	private WebElement VideoAddVideoButton;
	@FindBy(css="div[id='VideoEmbed'] input[value='Return to editing']")
	private WebElement VideoReturnToEditing;
	@FindBy(css="img.video")
	private WebElement VideoInEditMode;
	@FindBy(css="div.ArticlePreview span.Wikia-video-play-button")
	private WebElement VideoOnPreview;
	@FindBy(css="span.cke_button_ModeWysiwyg ")
	private WebElement VisualModeButton;
	@FindBy(css="section.modalWrapper.preview section.modalContent figure a img")
	private WebElement ImageOnPreview;

	
	private By CaptionInPreview = By.cssSelector("section.modalWrapper.preview section.modalContent figcaption");
	private By RemovePhotoDialog = By.cssSelector("section.modalWrapper.RTEModal");
	private By ImageOnArticleEditMode = By.cssSelector("div.WikiaArticle figure a img");
	private By GalleryDialogPhotosList = By.cssSelector("ul.WikiaPhotoGalleryResults li input");
	private By GalleryDialogPhotoOrientationsList = By.cssSelector("ul.clearfix[id='WikiaPhotoGalleryOrientation'] li");
	private By GalleryDialogSlideshowOrientationsList = By.cssSelector("ul.clearfix[id='WikiaPhotoGallerySliderType'] li");

	public WikiArticleEditMode(WebDriver driver, String Domain,
			String articlename) {
		super(driver, Domain, articlename);
		PageFactory.initElements(driver, this);
	}

	/**
	 * Left Click on add Object button.
	 *  
	 * @author Michal Nowierski
	 * @param Object Object = {Image, Gallery, Slideshow, Slider, Video}
	 */
	public void ClickOnAddObjectButton(String Object) {
		// TODO Auto-generated method stub
		String ObjectCss = "span.cke_button.RTE"+Object+"Button a";
		WebElement ObjectButton;
		waitForElementByCss(ObjectCss);
		waitForElementClickableByCss(ObjectCss);
		ObjectButton = driver.findElement(By.cssSelector(ObjectCss));
		ObjectButton.click();
		PageObjectLogging.log("ClickOnAddObjectButton", "Edit Article: "+articlename+", on wiki: "+Domain+"", true, driver);
		
	}

	/**
	 * Wait for modal and click on 'add this photo' under the first seen photo
	 *  
	 * @author Michal Nowierski
	 */
	public void WaitForModalAndClickAddThisPhoto() {
		waitForElementByElement(ImageUploadModal);
		waitForElementClickableByElement(AddThisPhotoLink);
		AddThisPhotoLink.click();
		PageObjectLogging.log("WaitForModalAndClickAddThisPhoto", "Wait for modal and click on 'add this photo' under the first seen photo", true, driver);
	
		
	}

	/**
	 * Type given caption for the photo
	 *  
	 * @author Michal Nowierski
	 */
	public void TypeCaption(String caption) {
		waitForElementByElement(CaptionTextArea);
		CaptionTextArea.clear();
		CaptionTextArea.sendKeys(caption);
		PageObjectLogging.log("TypeAcaption", "Type any caption for the photo", true, driver);
		
		
	}
	
	/**
	 * Type given caption for the video
	 *  
	 * @author Michal Nowierski
	 */
	public void TypeVideoCaption(String caption) {
		waitForElementByElement(VideoCaptionTextArea);
		VideoCaptionTextArea.clear();
		VideoCaptionTextArea.sendKeys(caption);
		PageObjectLogging.log("TypeAcaption", "Type any caption for the photo", true, driver);
				
	}

	/**
	 * Left Click on add 'Photo' button.
	 *  
	 * @author Michal Nowierski
	 */
	public void ClickOnAddPhotoButton2() {
		waitForElementByElement(AddPhotoButton);
		waitForElementClickableByElement(AddPhotoButton);
		AddPhotoButton.click();
		PageObjectLogging.log("ClickOnAddPhotoButton2", "Left Click on add 'Photo' button.", true, driver);
		
	}

	/**
	 * Verify that the photo appears in the visual mode
	 *  
	 * @author Michal Nowierski
	 */
	public void VerifyThatThePhotoAppears(String caption) {
		waitForElementByElement(VisualModeIFrame);
		//The Editor is iframe so we have to switch to the iframe in order to investigate its content
		driver.switchTo().frame(VisualModeIFrame);
		wait.until(ExpectedConditions.visibilityOfElementLocated(By.cssSelector("img[data-rte-meta*='"+caption+"']")));
		// Now switch back to the normal DOM
		driver.switchTo().defaultContent();
		PageObjectLogging.log("VerifyThatThePhotoAppears", "Verify that the photo appears in the visual mode", true, driver);
		
	}

	/**
	 * Left Click on 'Preview' Button
	 *  
	 * @author Michal Nowierski
	 */
	public void ClickOnPreviewButton() {
		System.out.println();
		waitForElementByElement(PreviewButton);
		waitForElementClickableByElement(PreviewButton);
		PreviewButton.click();
		PageObjectLogging.log("LeftClickOnPreviewButton", "Left Click on 'Preview' Button", true, driver);
		
		
	}

	/**
	 * Verify that the image appears in the preview
	 *  
	 * @author Michal Nowierski
	 */
	public void VerifyTheImageOnThePreview() {
		waitForElementByElement(ImageOnPreview);
		PageObjectLogging.log("VerifyTheImageOnThePreview", "Verify that the image appears in the preview", true, driver);
	
	}

	/**
	 * Verify that the caption of image appears in the preview
	 *  
	 * @author Michal Nowierski
	 */
	public void VerifyTheCaptionOnThePreview(String caption) {
		wait.until(ExpectedConditions.textToBePresentInElement(CaptionInPreview, caption));
		PageObjectLogging.log("VerifyTheCaptionOnThePreview", "Verify that the caption of image appears in the preview", true, driver);

		
	}

	/**
	 * Click on 'Publish' button
	 *  
	 * @author Michal Nowierski
	 */
	public WikiArticlePageObject ClickOnPublishButtonInPreviewMode() {
		waitForElementByElement(PublishButtonPreview);
		waitForElementClickableByElement(PublishButtonPreview);
		PublishButtonPreview.click();
		PageObjectLogging.log("LeftClickOnPublishButtonInPreviewMode", "Click on 'Publish' button in preview mode", true, driver);
	
		return new WikiArticlePageObject(driver, Domain, articlename);
	}

	/**
	 * Click on 'Source' button
	 *  
	 * @author Michal Nowierski
	 */
	public void ClickOnSourceButton() {
		waitForElementByElement(SourceModeButton);
		waitForElementClickableByElement(SourceModeButton);
		SourceModeButton.click();
		PageObjectLogging.log("ClickOnSourceButton", "Click on 'Source' button", true, driver);
		
	}
	
	/**
	 * Click on 'Source' button
	 *  
	 * @author Michal Nowierski
	 */
	public void ClickOnVisualButton() {
		waitForElementByElement(VisualModeButton);
		waitForElementClickableByElement(VisualModeButton);
		VisualModeButton.click();
		PageObjectLogging.log("ClickOnVisualButton", "Click on 'Visual' button", true, driver);
		
	}
	
	/**
	 * Delete all source code on the article
	 *  
	 * @author Michal Nowierski
	 */
	public void deleteArticleContent() {
		ClickOnSourceButton();
		waitForElementByElement(SourceModeTextArea);
		SourceModeTextArea.clear();
		PageObjectLogging.log("deleteArticleContent", "Delete all source code on the article", true, driver);
		
	}

	/**
	 * Click  on Publish button
	 *  
	 * @author Michal Nowierski
	 */
	public WikiArticlePageObject ClickOnPublishButton() {
		waitForElementByElement(PublishButtonGeneral);
		waitForElementClickableByElement(PublishButtonGeneral);
		PublishButtonGeneral.click();
		PageObjectLogging.log("ClickOnPublishButton", "Click on 'Publish' button", true, driver);
	
		return new WikiArticlePageObject(driver, Domain, articlename);
	}
	
	/**
	 * Hover your phisical mouse cursor over image. Identify image by its caption
	 *  
	 * @author Michal Nowierski
	 * @param caption Caption of the image 
	 * 	 */
	public void HoverCursorOverImage(String caption) {
		waitForElementByElement(iFrame);
		CommonFunctions.MoveCursorToIFrameElement(By.cssSelector("img[data-rte-meta*='"+caption+"']"), iFrame);
		PageObjectLogging.log("HoverCursorOverImage", "Hover your phisical mouse cursor over image.", true, driver);
}
	



	/**
	 * Click on 'modify button' of image with given caption
	 *  
	 * @author Michal Nowierski
	 * @param caption Caption of the image 
	 * 	 */
	public void ClickModifyButtonOfImage(String caption) {
		HoverCursorOverImage(caption);
		waitForElementByElement(ModifyButton);
		waitForElementClickableByElement(ModifyButton);
		ModifyButton.click();
		PageObjectLogging.log("ClickModifyButtonOfImage", "Click on 'modify button' of image with caption: '"+caption+"'", true, driver);

		
	}

	/**
	 * Click on 'remove button' of image with given caption
	 *  
	 * @author Michal Nowierski
	 * @param caption Caption of the image 
	 * 	 */
	public void ClickRemoveButtonOfImage(String caption) {
		CommonFunctions.MoveCursorTo(0, 0);
		HoverCursorOverImage(caption);
		waitForElementByElement(RemoveButton);
		waitForElementClickableByElement(RemoveButton);
		RemoveButton.click();
		PageObjectLogging.log("ClickRemoveButtonOfImage", "Click on 'remove button' of image with caption: '"+caption+"'", true, driver);
		
	}

	/**
	 * Left Click on Cancel button
	 *  
	 * @author Michal Nowierski
	 * 	 */
	public void LeftClickCancelButton() {
		waitForElementByElement(CancelImageRemovalButton);
		waitForElementClickableByElement(CancelImageRemovalButton);
		CancelImageRemovalButton.click();
		PageObjectLogging.log("LeftClickCancelButton", "Left Click on Cancel button", true, driver);
				
	}

	/**
	 * Verify that 'Remove this photo?' modal has disappeared
	 *  
	 * @author Michal Nowierski
	 * 	 */
	public void VerifyModalDisappeared() {
		waitForElementNotVisibleByBy(RemovePhotoDialog);
		PageObjectLogging.log("VerifyModalDisappeared", "Verify that 'Remove this photo?' modal has disappeared", true, driver);
	}

	/**
	 * Left Click on Ok button on remove photo dialog
	 *  
	 * @author Michal Nowierski
	 * 	 */
	public void LeftClickOkButton() {
		waitForElementByElement(OKbutton);
		waitForElementClickableByElement(OKbutton);
		OKbutton.click();
		PageObjectLogging.log("LeftClickOkButton", "Left Click on Ok button on remove photo dialog", true, driver);
		
		
	}

	/**
	 * Verify that the image does not appear on the Article Edit mode
	 *  
	 * @author Michal Nowierski
	 * 	 */
	public void VerifyTheImageNotOnTheArticleEditMode() {
		waitForElementNotVisibleByBy(ImageOnArticleEditMode);
		PageObjectLogging.log("VerifyTheImageNotOnTheArticleEditMode", "Verify that the image does not appear on the Article edit mode", true, driver);
				
	}

	/**
	 * Wait for Object and click on 'add this photo' under the first seen
	 *  
	 * @author Michal Nowierski
	 * @param Object Object = {Gallery, GallerySlideshow, GallerySlider}
	 * 	 */
	public void WaitForObjectModalAndClickAddAphoto(String Object) {
		waitForElementClickableByBy(By.cssSelector("button[id='WikiaPhoto"+Object+"AddImage']"));
		driver.findElement(
				By.cssSelector("button[id='WikiaPhoto"+Object+"AddImage']"))
				.click();
		PageObjectLogging.log("WaitForObjectModalAndClickAddAphoto", "Wait for "
				+ Object
				+ " modal and click on 'add a photo'", true, driver);
		waitForElementByElement(ObjectModal);
	}

	/**
	 * Wait for Object and click on 'add this photo' under the first seen
	 *  
	 * @author Michal Nowierski
	 * @param n n = parameter determining how many inputs the method should check
	 * 	 */
	public void GalleryCheckImageInputs(int n) {
		List<WebElement> List = driver.findElements(GalleryDialogPhotosList);
		for (int i = 0; i < n; i++) {
			List.get(i).click();
		}
		PageObjectLogging.log("CheckGalleryImageInputs", "Check first "+n+" image inputs", true, driver);
	}

	/**
	 * Gallery dialog: Left click 'Select' button
	 *  
	 * @author Michal Nowierski
	 * 	 */
	public void GalleryClickOnSelectButton() {
		waitForElementByElement(GalleryDialogSelectButton);
		waitForElementClickableByElement(GalleryDialogSelectButton);
		GalleryDialogSelectButton.click();
		PageObjectLogging.log("GalleryClickOnSelectButton", "Gallery dialog: Left click 'Select' button", true, driver);
		
	}

	
	/**
	 * Gallery dialog: Left click 'Finish' button 
	 *  
	 * @author Michal Nowierski
	 * 	 */
	public void GalleryClickOnFinishButton() {
		waitForElementByElement(GalleryDialogFinishButton);
		waitForElementClickableByElement(GalleryDialogFinishButton);
		GalleryDialogFinishButton.click();
		PageObjectLogging.log("GalleryClickOnFinishButton", "Gallery dialog: Left click 'Finish' button ", true, driver);
		
	}

	/**
	 * Verify Gallery object appears in edit mode
	 *  
	 * @author Michal Nowierski
	 * @param Object Object = {gallery, slideshow, gallery-slider}
	 * 	 */
	public void VerifyObjectInEditMode(String Object) {
		//The Editor is iframe so we have to switch to the iframe in order to investigate its content
		waitForElementByElement(iFrame);
//		WebElement iFrame = driver.findElement(IframeVisualEditor);
		driver.switchTo().frame(iFrame);
		wait.until(ExpectedConditions.visibilityOfElementLocated(By.cssSelector("img.media-placeholder.image-"+Object)));
		// Now switch back to the normal DOM
		driver.switchTo().defaultContent();
		PageObjectLogging.log("VerifyObjectInEditMode", "Verify "+Object+" object appears in edit mode", true, driver);
		
	}

	/**
	 * Verify Gallery object appears in the preview
	 *  
	 * @author Michal Nowierski
	 * @param Object Object = {gallery, slideshow, slider}
	 * 	 */
	public void VerifyTheObjectOnThePreview(String Object) {
		wait.until(ExpectedConditions.visibilityOfElementLocated(By.cssSelector("div.ArticlePreview div[id*='"+Object+"']")));
		PageObjectLogging.log("VerifyTheObjectOnThePreview", "Verify that the "+Object+" appears in the preview", true, driver);		
	}

	/**
	 * Wait for Video modal and type in the video URL 
	 *  
	 * @author Michal Nowierski
	 * 	 */
	public void WaitForVideoModalAndTypeVideoURL(String videoURL) {
		waitForElementByElement(VideoModalInput);
		waitForElementClickableByElement(VideoModalInput);
		VideoModalInput.clear();
		VideoModalInput.sendKeys(videoURL);
		PageObjectLogging.log("WaitForVideoModalAndTypeVideoURL", "Wait for Video modal and type in the video URL: "+videoURL, true, driver);		
	}

	/**
	 * Video Click Next button
	 *  
	 * @author Michal Nowierski
	 * 	 */
	public void ClickVideoNextButton() {
		waitForElementByElement(VideoNextButton);
		waitForElementClickableByElement(VideoNextButton);
		VideoNextButton.click();
		PageObjectLogging.log("ClickVideoNextButton", "Left Click Next button", true, driver);
			
	}

	/**
	 * Wait For Succes dialog and click on 'return to editing'
	 *  
	 * @author Michal Nowierski
	 * 	 */
	public void WaitForSuccesDialogAndReturnToEditing() {
		waitForElementByElement(VideoReturnToEditing);
		waitForElementClickableByElement(VideoReturnToEditing);
		VideoReturnToEditing.click();
		PageObjectLogging.log("WaitForSuccesDialogAndReturnToEditing", "Wait For Succes dialog and click on 'return to editing'", true, driver);
		
	}

	/**
	 * Verify that video appears in edit mode
	 *  
	 * @author Michal Nowierski
	 * 	 */
	public void VerifyVideoInEditMode() {
		waitForElementByElement(iFrame);
//		WebElement iFrame = driver.findElement(IframeVisualEditor);
		driver.switchTo().frame(iFrame);
		waitForElementByElement(VideoInEditMode);
//		wait.until(ExpectedConditions.visibilityOfElementLocated(VideoInEditMode));
		driver.switchTo().defaultContent();
		PageObjectLogging.log("VerifyVideoInEditMode", "Verify that video appears in edit mode", true, driver);
		
	}

	/**
	 * Verify that the video appears in the preview
	 *  
	 * @author Michal Nowierski
	 * 	 */
	public void VerifyTheVideoOnThePreview() {
	waitForElementByElement(VideoOnPreview);
	PageObjectLogging.log("VerifyTheVideoOnThePreview", "Verify that the video appears in the preview", true, driver);
			
	}

	/**
	 * Set photo orientation option number n
	 *  
	 * @author Michal Nowierski
	 * @param n = {1,2,3,4} <p> 1 - Original.<p> 2 - Square.<p> 3 - Landscape.<p> 4 - Portrait
	 * 	 */
	public void GallerySetPhotoOrientation(int n) {
		List<WebElement> List = driver.findElements(GalleryDialogPhotoOrientationsList);
		waitForElementByElement(List.get(n-1));
		List.get(n-1).click();
		PageObjectLogging.log("GallerySetPhotoOrientation", "Set photo orientation option number "+n, true, driver);
				
	}

	/**
	 * Set Object position to the wanted one
	 *  
	 * @author Michal Nowierski
	 * @param Object {Gallery, Slideshow} 
	 * @param WantedPosition = {Left, Center, Right} !CASE SENSITIVITY!
	 * 	 * 	 */
	public void GallerySetPosition(String Object, String WantedPosition) {
				
		Select select = new Select(driver.findElement(By.cssSelector("select[id*='WikiaPhotoGalleryEditor"+Object+"']")));
		select.selectByVisibleText(WantedPosition);
		// below code will make sure that proper position is selected
		String category_name = select.getAllSelectedOptions().get(0).getText();
		while (!category_name.equalsIgnoreCase(WantedPosition)) {
			select.selectByVisibleText(WantedPosition);
			category_name = select.getAllSelectedOptions().get(0).getText();
		
	}
		PageObjectLogging.log("GallerySetPosition", "Set "+Object+" position to "+WantedPosition, true, driver);
		}

	/**
	 * Set photo orientation option number n
	 *  
	 * @author Michal Nowierski
	 * @param n = {1, 2} <p> 1 - Horizontaal.<p> 2 - Vertical
	 * 	 */
	public void GallerySetSliderPosition(int n) {
		List<WebElement> List = driver.findElements(GalleryDialogSlideshowOrientationsList);
		waitForElementByElement(List.get(n-1));
		List.get(n-1).click();
		PageObjectLogging.log("GallerySetSliderPosition", "Set photo orientation option number "+n, true, driver);
		
		
	}

	/**
	 * Wait for video dialog
	 *  
	 * @author Michal Nowierski
	 * 	 */
	public void WaitForVideoDialog() {
		waitForElementByElement(VideoAddVideoButton);
		PageObjectLogging.log("WaitForVideoDialog", "Wait for video dialog", true, driver);
		
	}

	/**
	 * Click 'Add a video'
	 *  
	 * @author Michal Nowierski
	 * 	 */
	public void ClickAddAvideo() {
		waitForElementClickableByElement(VideoAddVideoButton);
		VideoAddVideoButton.click();
		PageObjectLogging.log("ClickAddAvideo", "Click 'Add a video'", true, driver);
		
	}

	/**
	 * Get text of source mode text of message article page. Remmember that source mode must be turned on to invoke this method. Just invoke 'ClickOnSourceButton'
	 * Message article page is e.g http://mediawiki119.wikia.com/wiki/MediaWiki:RelatedVideosGlobalList
	 * 
	 * @author Michal Nowierski
	 */
	public String getMessageSourceText() {
		waitForElementByElement(MessageSourceModeTextArea);
		PageObjectLogging.log("getMessageSourceText", "Get text of source mode text of message article page.", true, driver);		
		return MessageSourceModeTextArea.getText();
	}
	
	/**
	 * Delete unwanted video by its name.
	 * Message article page is e.g http://mediawiki119.wikia.com/wiki/MediaWiki:RelatedVideosGlobalList
	 * This method destination is exactly related videos message article
	 *  
	 * @author Michal Nowierski
	 * @param unwantedVideoName e.g "What is love (?) - on piano (Haddway)"
	 */
	public void deleteUnwantedVideoFromMessage(String unwantedVideoName) {
		ArrayList<String> videos = new ArrayList<String>();
		String sourceText = getMessageSourceText();
		int index = 0;
		while (true) {
			int previousStarIndex = sourceText.indexOf("*", index);
			int nextStarIndex = sourceText.indexOf("*", previousStarIndex+1);
			if (nextStarIndex<0) {
				break;
			}
			String video = sourceText.substring(previousStarIndex, nextStarIndex);
			if (!video.contains(unwantedVideoName)) {
				videos.add(video);
			}
			index = previousStarIndex+1;
		}
		waitForElementByElement(MessageSourceModeTextArea);
		MessageSourceModeTextArea.clear();
		MessageSourceModeTextArea.sendKeys("WHITELIST");
		MessageSourceModeTextArea.sendKeys(Keys.ENTER);
		MessageSourceModeTextArea.sendKeys(Keys.ENTER);
		for (int i = 0; i < videos.size(); i++) {
			MessageSourceModeTextArea.sendKeys(videos.get(i));
			MessageSourceModeTextArea.sendKeys(Keys.ENTER);
		}
		PageObjectLogging.log("deleteUnwantedVideoFromMessage", "Delete all source code on the article", true, driver);
	}
	
	






}
