package com.wikia.webdriver.PageObjects.PageObject.WikiPage;

import java.util.ArrayList;
import java.util.List;

import org.openqa.selenium.By;
import org.openqa.selenium.JavascriptExecutor;
import org.openqa.selenium.Keys;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.PageFactory;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.support.ui.Select;

import com.wikia.webdriver.Common.Core.CommonFunctions;
import com.wikia.webdriver.Common.Core.Global;
import com.wikia.webdriver.Common.Logging.PageObjectLogging;


public class WikiArticleEditMode extends WikiArticlePageObject {

	@FindBy(css="div.reset[id='ImageUpload']")
	private WebElement imageUploadModal;
	@FindBy(css="textarea[id='ImageUploadCaption']")
	private WebElement captionTextArea;
	@FindBy(css="div.cke_skin_wikia.visible div.cke_contents iframe")
	private WebElement visualModeIFrame;
	@FindBy(css="textarea.cke_source")
	private WebElement sourceModeTextArea;
	@FindBy(css="textarea.yui-ac-input")
	private WebElement messageSourceModeTextArea;
	@FindBy(css="div.cke_wrapper.cke_ltr div.cke_contents iframe")
	private WebElement iFrame;
	@FindBy(css="header.WikiaHeader")
	private WebElement header;
	@FindBy(css="tr.ImageUploadFindLinks td a")
	private WebElement addThisPhotoLink;
	@FindBy(css="div.details input")
	private WebElement addPhotoButton;
	@FindBy(css="div.module_content nav.buttons nav.wikia-menu-button a")
	private WebElement previewButton;
	@FindBy(css="div.neutral.modalToolbar a[id='publish']")
	private WebElement publishButtonPreview;
	@FindBy(css="span.cke_button_ModeSource span.cke_label")
	private WebElement sourceModeButton;
	@FindBy(css="input.control-button")
	private WebElement publishButtonGeneral;
	@FindBy(css="span.RTEMediaOverlayEdit")
	private WebElement modifyButton;
	@FindBy(css="span.RTEMediaOverlayDelete")
	private WebElement removeButton;
	@FindBy(css="div.RTEConfirmButtons a[id='RTEConfirmCancel'] span")
	private WebElement cancelImageRemovalButton;
	@FindBy(css="a[id='RTEConfirmOk']")
	private WebElement oKbutton;
	@FindBy(css="section[id='WikiaPhotoGalleryEditor']")
	private WebElement objectModal;
	@FindBy(css="a[id='WikiaPhotoGallerySearchResultsSelect']")
	private WebElement galleryDialogSelectButton;
	@FindBy(css="a[id='WikiaPhotoGalleryEditorSave']")
	private WebElement galleryDialogFinishButton;
	@FindBy(css="input[id='VideoEmbedUrl']")
	private WebElement videoModalInput;
	@FindBy(css="a[id='VideoEmbedUrlSubmit']")
	private WebElement videoNextButton;
	@FindBy(css="input[id='VideoEmbedCaption']")
	private WebElement videoCaptionTextArea;
	@FindBy(css="tr.VideoEmbedNoBorder input.wikia-button")
	private WebElement videoAddVideoButton;
	@FindBy(css="div[id='VideoEmbed'] input[value='Return to editing']")
	private WebElement videoReturnToEditing;
	@FindBy(css="img.video")
	private WebElement videoInEditMode;
	@FindBy(css="div.ArticlePreview span.Wikia-video-play-button")
	private WebElement videoOnPreview;
	@FindBy(css="span.cke_button_ModeWysiwyg a")
	private WebElement visualModeButton;
	@FindBy(css="section.modalWrapper.preview section.modalContent figure a img")
	private WebElement imageOnPreview;
	@FindBy(css="body[id='bodyContent']")
	private WebElement bodyContent;
	

	
	private By captionInPreview = By.cssSelector("section.modalWrapper.preview section.modalContent figcaption");
	private By removePhotoDialog = By.cssSelector("section.modalWrapper.RTEModal");
	private By imageOnArticleEditMode = By.cssSelector("div.WikiaArticle figure a img");
	private By galleryDialogPhotosList = By.cssSelector("ul.WikiaPhotoGalleryResults li input");
	private By galleryDialogPhotoOrientationsList = By.cssSelector("ul.clearfix[id='WikiaPhotoGalleryOrientation'] li");
	private By galleryDialogSlideshowOrientationsList = By.cssSelector("ul.clearfix[id='WikiaPhotoGallerySliderType'] li");

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
	public void clickOnAddObjectButton(String Object) {
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
	public void waitForModalAndClickAddThisPhoto() {
		waitForElementByElement(imageUploadModal);
		waitForElementClickableByElement(addThisPhotoLink);
		addThisPhotoLink.click();
		PageObjectLogging.log("WaitForModalAndClickAddThisPhoto", "Wait for modal and click on 'add this photo' under the first seen photo", true, driver);
	}

	/**
	 * Type given caption for the photo
	 *  
	 * @author Michal Nowierski
	 */
	public void typePhotoCaption(String caption) {
		waitForElementByElement(captionTextArea);
		captionTextArea.clear();
		captionTextArea.sendKeys(caption);
		PageObjectLogging.log("TypeAcaption", "Type any caption for the photo", true, driver);
		}
	
	/**
	 * Type given caption for the video
	 *  
	 * @author Michal Nowierski
	 */
	public void typeVideoCaption(String caption) {
		waitForElementByElement(videoCaptionTextArea);
		videoCaptionTextArea.clear();
		videoCaptionTextArea.sendKeys(caption);
		PageObjectLogging.log("TypeAcaption", "Type any caption for the photo", true, driver);
	}

	/**
	 * Left Click on add 'Photo' button.
	 *  
	 * @author Michal Nowierski
	 */
	public void clickOnAddPhotoButton2() {
		waitForElementByElement(addPhotoButton);
		waitForElementClickableByElement(addPhotoButton);
		addPhotoButton.click();
		PageObjectLogging.log("ClickOnAddPhotoButton2", "Left Click on add 'Photo' button.", true, driver);	
	}

	/**
	 * Verify that the photo appears in the visual mode
	 *  
	 * @author Michal Nowierski
	 */
	public void verifyThatThePhotoAppears(String caption) {
		waitForElementByElement(visualModeIFrame);
		//The Editor is iframe so we have to switch to the iframe in order to investigate its content
		driver.switchTo().frame(visualModeIFrame);
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
	public void clickOnPreviewButton() {
		System.out.println();
		waitForElementByElement(previewButton);
		waitForElementClickableByElement(previewButton);
		previewButton.click();
		PageObjectLogging.log("LeftClickOnPreviewButton", "Left Click on 'Preview' Button", true, driver);
		
		
	}

	/**
	 * Verify that the image appears in the preview
	 *  
	 * @author Michal Nowierski
	 */
	public void verifyTheImageOnThePreview() {
		waitForElementByElement(imageOnPreview);
		PageObjectLogging.log("VerifyTheImageOnThePreview", "Verify that the image appears in the preview", true, driver);
	
	}

	/**
	 * Verify that the caption of image appears in the preview
	 *  
	 * @author Michal Nowierski
	 */
	public void verifyTheCaptionOnThePreview(String caption) {
		wait.until(ExpectedConditions.textToBePresentInElement(captionInPreview, caption));
		PageObjectLogging.log("VerifyTheCaptionOnThePreview", "Verify that the caption of image appears in the preview", true, driver);

		
	}

	/**
	 * Click on 'Publish' button
	 *  
	 * @author Michal Nowierski
	 */
	public WikiArticlePageObject clickOnPublishButtonInPreviewMode() {
		waitForElementByElement(publishButtonPreview);
		waitForElementClickableByElement(publishButtonPreview);
		publishButtonPreview.click();
		PageObjectLogging.log("LeftClickOnPublishButtonInPreviewMode", "Click on 'Publish' button in preview mode", true, driver);
	
		return new WikiArticlePageObject(driver, Domain, articlename);
	}

	/**
	 * Click on 'Source' button
	 *  
	 * @author Michal Nowierski
	 */
	public void clickOnSourceButton() {
		waitForElementByElement(sourceModeButton);
		waitForElementClickableByElement(sourceModeButton);
		sourceModeButton.click();
		PageObjectLogging.log("ClickOnSourceButton", "Click on 'Source' button", true, driver);
		
	}
	
	/**
	 * Click on 'Source' button
	 *  
	 * @author Michal Nowierski
	 */
	public void clickOnVisualButton() {
		waitForElementByElement(visualModeButton);
		waitForElementClickableByElement(visualModeButton);
		visualModeButton.click();
		waitForElementByElement(iFrame);
		PageObjectLogging.log("ClickOnVisualButton", "Click on 'Visual' button", true, driver);
		
	}
	
	/**
	 * Delete all source code on the article
	 *  
	 * @author Michal Nowierski
	 */
	public void deleteArticleContent() {
		clickOnSourceButton();
		waitForElementByElement(sourceModeTextArea);
		sourceModeTextArea.clear();
		PageObjectLogging.log("deleteArticleContent", "Delete all source code on the article", true, driver);
		
	}

	/**
	 * Click  on Publish button
	 *  
	 * @author Michal Nowierski
	 */
	public WikiArticlePageObject clickOnPublishButton() {
		waitForElementByElement(publishButtonGeneral);
		waitForElementClickableByElement(publishButtonGeneral);
		publishButtonGeneral.click();
		waitForElementByElement(editButton);
		PageObjectLogging.log("ClickOnPublishButton", "Click on 'Publish' button", true, driver);
	
		return new WikiArticlePageObject(driver, Domain, articlename);
	}
	
	public WikiArticlePageObject clickOnPublishButtonPreview() {
		waitForElementByElement(publishButtonPreview);
		waitForElementClickableByElement(publishButtonPreview);
		publishButtonPreview.click();
		PageObjectLogging.log("ClickOnPublishButtonPreview", "Click on 'Publish' button in preview", true, driver);
		
		return new WikiArticlePageObject(driver, Domain, articlename);
	}
	
	/**
	 * Hover your phisical mouse cursor over image. Identify image by its caption
	 *  
	 * @author Michal Nowierski
	 * @param caption Caption of the image 
	 * 	 */
	public void hoverCursorOverImage(String caption) {
		waitForElementByElement(iFrame);
		CommonFunctions.MoveCursorToIFrameElement(By.cssSelector("img[data-rte-meta*='"+caption+"']"), iFrame);
		PageObjectLogging.log("HoverCursorOverImage", "Hover your phisical mouse cursor over image.", true, driver);
	}
	
	public void typeInContent(String content)
	{
		waitForElementByElement(visualModeIFrame);
		driver.switchTo().frame(visualModeIFrame);
		waitForElementByElement(bodyContent);
		if (Global.BROWSER.equals("FF"))
		{
			((JavascriptExecutor) driver).executeScript("document.body.innerHTML='" + content + "'");
		}
		else
		{
			bodyContent.sendKeys(content);			
		}
		driver.switchTo().defaultContent();
		PageObjectLogging.log("typeInContent", "content type into article body", true, driver);
	}
	

	



	/**
	 * Click on 'modify button' of image with given caption
	 *  
	 * @author Michal Nowierski
	 * @param caption Caption of the image 
	 * 	 */
	public void clickModifyButtonOfImage(String caption) 
	{
		waitForElementByElement(iFrame);
		mouseOverInArticleIframe("img");
		waitForElementByElement(modifyButton);
		jQueryClick("span.RTEMediaOverlayEdit");
		PageObjectLogging.log("ClickModifyButtonOfImage", "Click on 'modify button' of image with caption: '"+caption+"'", true, driver);
	}
	
	public void clickModifyButtonGallery()
	{
		waitForElementByElement(iFrame);
		mouseOverInArticleIframe("img.image-gallery");
		waitForElementByElement(modifyButton);
		jQueryClick("span.RTEMediaOverlayEdit");
		PageObjectLogging.log("clickModifyButtonGallery", "Click on 'modify button' on gallery", true, driver);
	}
	
	public void clickModifyButtonSlideshow() 
	{
		waitForElementByElement(iFrame);
		mouseOverInArticleIframe("img.image-slideshow");
		waitForElementByElement(modifyButton);
		jQueryClick("span.RTEMediaOverlayEdit");
		PageObjectLogging.log("clickModifyButtonSlideshow", "Click on 'modify button' on slideshow", true, driver);
	}


	/**
	 * Click on 'remove button' of image with given caption
	 *  
	 * @author Michal Nowierski
	 * @param caption Caption of the image 
	 * 	 */
	public void clickRemoveButtonOfImage(String caption) {
		waitForElementByElement(iFrame);
		mouseOverInArticleIframe("img");
		waitForElementByElement(removeButton);
		jQueryClick("span.RTEMediaOverlayDelete");
		PageObjectLogging.log("ClickRemoveButtonOfImage", "Click on 'remove button' of image with caption: '"+caption+"'", true, driver);
	}
	
	public void clickRemoveButtonGallery() {
		waitForElementByElement(iFrame);
		mouseOverInArticleIframe("img.image-gallery");
		waitForElementByElement(removeButton);
		jQueryClick("span.RTEMediaOverlayDelete");
		PageObjectLogging.log("ClickRemoveButtonOfImage", "Click on 'remove button' on gallery", true, driver);
	}

	/**
	 * Left Click on Cancel button
	 *  
	 * @author Michal Nowierski
	 * 	 */
	public void leftClickCancelButton() {
		waitForElementByElement(cancelImageRemovalButton);
		waitForElementClickableByElement(cancelImageRemovalButton);
		cancelImageRemovalButton.click();
		PageObjectLogging.log("LeftClickCancelButton", "Left Click on Cancel button", true, driver);
				
	}

	/**
	 * Verify that 'Remove this photo?' modal has disappeared
	 *  
	 * @author Michal Nowierski
	 * 	 */
	public void verifyModalDisappeared() {
		waitForElementNotVisibleByBy(removePhotoDialog);
		PageObjectLogging.log("VerifyModalDisappeared", "Verify that 'Remove this photo?' modal has disappeared", true, driver);
	}

	/**
	 * Left Click on Ok button on remove photo dialog
	 *  
	 * @author Michal Nowierski
	 * 	 */
	public void leftClickOkButton() {
		waitForElementByElement(oKbutton);
		waitForElementClickableByElement(oKbutton);
		oKbutton.click();
		PageObjectLogging.log("LeftClickOkButton", "Left Click on Ok button on remove photo dialog", true, driver);
		
		
	}

	/**
	 * Verify that the image does not appear on the Article Edit mode
	 *  
	 * @author Michal Nowierski
	 * 	 */
	public void verifyTheImageNotOnTheArticleEditMode() {
		waitForElementNotVisibleByBy(imageOnArticleEditMode);
		PageObjectLogging.log("VerifyTheImageNotOnTheArticleEditMode", "Verify that the image does not appear on the Article edit mode", true, driver);
				
	}

	/**
	 * Wait for Object and click on 'add this photo' under the first seen
	 *  
	 * @author Michal Nowierski
	 * @param Object Object = {Gallery, GallerySlideshow, GallerySlider}
	 * 	 */
	public void waitForObjectModalAndClickAddAphoto(String Object) {
		waitForElementClickableByBy(By.cssSelector("button[id='WikiaPhoto"+Object+"AddImage']"));
		driver.findElement(
				By.cssSelector("button[id='WikiaPhoto"+Object+"AddImage']"))
				.click();
		PageObjectLogging.log("WaitForObjectModalAndClickAddAphoto", "Wait for "
				+ Object
				+ " modal and click on 'add a photo'", true, driver);
		waitForElementByElement(objectModal);
	}

	/**
	 * Wait for Object and click on 'add this photo' under the first seen
	 *  
	 * @author Michal Nowierski
	 * @param n n = parameter determining how many inputs the method should check
	 * 	 */
	public void galleryCheckImageInputs(int n) {
		List<WebElement> List = driver.findElements(galleryDialogPhotosList);
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
	public void galleryClickOnSelectButton() {
		waitForElementByElement(galleryDialogSelectButton);
		waitForElementClickableByElement(galleryDialogSelectButton);
		galleryDialogSelectButton.click();
		PageObjectLogging.log("GalleryClickOnSelectButton", "Gallery dialog: Left click 'Select' button", true, driver);
		
	}

	
	/**
	 * Gallery dialog: Left click 'Finish' button 
	 *  
	 * @author Michal Nowierski
	 * 	 */
	public void galleryClickOnFinishButton() {
		waitForElementByElement(galleryDialogFinishButton);
		waitForElementClickableByElement(galleryDialogFinishButton);
		galleryDialogFinishButton.click();
		PageObjectLogging.log("GalleryClickOnFinishButton", "Gallery dialog: Left click 'Finish' button ", true, driver);
		
	}

	/**
	 * Verify Gallery object appears in edit mode
	 *  
	 * @author Michal Nowierski
	 * @param Object Object = {gallery, slideshow, gallery-slider}
	 * 	 */
	public void verifyObjectInEditMode(String Object) {
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
	public void verifyTheObjectOnThePreview(String Object) {
		wait.until(ExpectedConditions.visibilityOfElementLocated(By.cssSelector("div.ArticlePreview div[id*='"+Object+"']")));
		PageObjectLogging.log("VerifyTheObjectOnThePreview", "Verify that the "+Object+" appears in the preview", true, driver);		
	}

	/**
	 * Wait for Video modal and type in the video URL 
	 *  
	 * @author Michal Nowierski
	 * 	 */
	public void waitForVideoModalAndTypeVideoURL(String videoURL) {
		waitForElementByElement(videoModalInput);
		waitForElementClickableByElement(videoModalInput);
		videoModalInput.clear();
		videoModalInput.sendKeys(videoURL);
		PageObjectLogging.log("WaitForVideoModalAndTypeVideoURL", "Wait for Video modal and type in the video URL: "+videoURL, true, driver);		
	}

	/**
	 * Video Click Next button
	 *  
	 * @author Michal Nowierski
	 * 	 */
	public void clickVideoNextButton() {
		waitForElementByElement(videoNextButton);
		waitForElementClickableByElement(videoNextButton);
		videoNextButton.click();
		PageObjectLogging.log("ClickVideoNextButton", "Left Click Next button", true, driver);
			
	}

	/**
	 * Wait For Succes dialog and click on 'return to editing'
	 *  
	 * @author Michal Nowierski
	 * 	 */
	public void waitForSuccesDialogAndReturnToEditing() {
		waitForElementByElement(videoReturnToEditing);
		waitForElementClickableByElement(videoReturnToEditing);
		videoReturnToEditing.click();
		PageObjectLogging.log("WaitForSuccesDialogAndReturnToEditing", "Wait For Succes dialog and click on 'return to editing'", true, driver);
		
	}

	/**
	 * Verify that video appears in edit mode
	 *  
	 * @author Michal Nowierski
	 * 	 */
	public void verifyVideoInEditMode() {
		waitForElementByElement(iFrame);
//		WebElement iFrame = driver.findElement(IframeVisualEditor);
		driver.switchTo().frame(iFrame);
		waitForElementByElement(videoInEditMode);
//		wait.until(ExpectedConditions.visibilityOfElementLocated(VideoInEditMode));
		driver.switchTo().defaultContent();
		PageObjectLogging.log("VerifyVideoInEditMode", "Verify that video appears in edit mode", true, driver);
		
	}

	/**
	 * Verify that the video appears in the preview
	 *  
	 * @author Michal Nowierski
	 * 	 */
	public void verifyTheVideoOnThePreview() {
	waitForElementByElement(videoOnPreview);
	PageObjectLogging.log("VerifyTheVideoOnThePreview", "Verify that the video appears in the preview", true, driver);
			
	}

	/**
	 * Set photo orientation option number n
	 *  
	 * @author Michal Nowierski
	 * @param n = {1,2,3,4} <p> 1 - Original.<p> 2 - Square.<p> 3 - Landscape.<p> 4 - Portrait
	 * 	 */
	public void gallerySetPhotoOrientation(int n) {
		List<WebElement> List = driver.findElements(galleryDialogPhotoOrientationsList);
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
	public void gallerySetPositionGallery(String WantedPosition) {
				
		Select select = new Select(driver.findElement(By.cssSelector("select[id='WikiaPhotoGalleryEditorGalleryPosition']")));
		select.selectByVisibleText(WantedPosition);
		// below code will make sure that proper position is selected
		String category_name = select.getAllSelectedOptions().get(0).getText();
		while (!category_name.equalsIgnoreCase(WantedPosition)) {
			select.selectByVisibleText(WantedPosition);
			category_name = select.getAllSelectedOptions().get(0).getText();
		
	}
		PageObjectLogging.log("GallerySetPosition", "Set gallery position to "+WantedPosition, true, driver);
		}
	
	public void gallerySetPositionSlideshow(String WantedPosition) {
		
		Select select = new Select(driver.findElement(By.cssSelector("select[id='WikiaPhotoGalleryEditorSlideshowAlign']")));
		select.selectByVisibleText(WantedPosition);
		// below code will make sure that proper position is selected
		String category_name = select.getAllSelectedOptions().get(0).getText();
		while (!category_name.equalsIgnoreCase(WantedPosition)) {
			select.selectByVisibleText(WantedPosition);
			category_name = select.getAllSelectedOptions().get(0).getText();
		
	}
		PageObjectLogging.log("GallerySetPosition", "Set slideshow position to "+WantedPosition, true, driver);
		}

	/**
	 * Set photo orientation option number n
	 *  
	 * @author Michal Nowierski
	 * @param n = {1, 2} <p> 1 - Horizontaal.<p> 2 - Vertical
	 * 	 */
	public void gallerySetSliderPosition(int n) {
		List<WebElement> List = driver.findElements(galleryDialogSlideshowOrientationsList);
		waitForElementByElement(List.get(n-1));
		List.get(n-1).click();
		PageObjectLogging.log("GallerySetSliderPosition", "Set photo orientation option number "+n, true, driver);
		
		
	}

	/**
	 * Wait for video dialog
	 *  
	 * @author Michal Nowierski
	 * 	 */
	public void waitForVideoDialog() {
		waitForElementByElement(videoAddVideoButton);
		PageObjectLogging.log("WaitForVideoDialog", "Wait for video dialog", true, driver);
		
	}

	/**
	 * Click 'Add a video'
	 *  
	 * @author Michal Nowierski
	 * 	 */
	public void clickAddAvideo() {
		waitForElementClickableByElement(videoAddVideoButton);
		videoAddVideoButton.click();
		PageObjectLogging.log("ClickAddAvideo", "Click 'Add a video'", true, driver);
		
	}

	/**
	 * Get text of source mode text of message article page. Remmember that source mode must be turned on to invoke this method. Just invoke 'ClickOnSourceButton'
	 * Message article page is e.g http://mediawiki119.wikia.com/wiki/MediaWiki:RelatedVideosGlobalList
	 * 
	 * @author Michal Nowierski
	 */
	public String getMessageSourceText() {
		waitForElementByElement(messageSourceModeTextArea);
		PageObjectLogging.log("getMessageSourceText", "Get text of source mode text of message article page.", true, driver);		
		return messageSourceModeTextArea.getText();
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
		waitForElementByElement(messageSourceModeTextArea);
		messageSourceModeTextArea.clear();
		messageSourceModeTextArea.sendKeys("WHITELIST");
		messageSourceModeTextArea.sendKeys(Keys.ENTER);
		messageSourceModeTextArea.sendKeys(Keys.ENTER);
		for (int i = 0; i < videos.size(); i++) {
			messageSourceModeTextArea.sendKeys(videos.get(i));
			messageSourceModeTextArea.sendKeys(Keys.ENTER);
		}
		PageObjectLogging.log("deleteUnwantedVideoFromMessage", "Delete all source code on the article", true, driver);
	}

	
	






}
