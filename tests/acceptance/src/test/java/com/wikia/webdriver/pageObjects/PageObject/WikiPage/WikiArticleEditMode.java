package com.wikia.webdriver.pageObjects.PageObject.WikiPage;

import org.apache.commons.exec.Watchdog;
import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.PageFactory;
import org.openqa.selenium.support.ui.ExpectedConditions;

import com.wikia.webdriver.Common.CommonFunctions;
import com.wikia.webdriver.Logging.PageObjectLogging;


public class WikiArticleEditMode extends WikiArticlePageObject {

	@FindBy(css="div.reset[id='ImageUpload']")
	private WebElement ImageUploadModal;
	@FindBy(css="textarea[id='ImageUploadCaption']")
	private WebElement CaptionTextArea;
	@FindBy(css="div.cke_skin_wikia.visible div.cke_contents iframe")
	private WebElement VisualModeIFrame;
	@FindBy(css="textarea.cke_source")
	private WebElement SourceModeTextArea;
	@FindBy(css="div.cke_wrapper.cke_ltr div.cke_contents iframe")
	private WebElement iFrame;
	@FindBy(css="header.WikiaHeader")
	private WebElement header;
	
	private By AddPhotoButton = By.cssSelector("div.details input");	
	private By AddThisPhotoLink = By.cssSelector("tr.ImageUploadFindLinks td a");
	private By PreviewButton = By.cssSelector("div.module_content nav.buttons nav.wikia-menu-button a");
	private By ImageOnPreview = By.cssSelector("section.modalWrapper.preview section.modalContent figure a img");
	private By CaptionInPreview = By.cssSelector("section.modalWrapper.preview section.modalContent figcaption");
	private By PublishButtonPreview = By.cssSelector("div.neutral.modalToolbar a[id='publish']");
	private By PublishButton = By.cssSelector("input.control-button");
	private By SourceButton = By.cssSelector("span.cke_button_ModeSource");
	private By VisualButton = By.cssSelector("span.cke_button_ModeWysiwyg ");
	private By ModifyButton = By.cssSelector("span.RTEMediaOverlayEdit");
	private By RemoveButton = By.cssSelector("span.RTEMediaOverlayDelete");
	private By CancelImageRemovalButton = By.cssSelector("div.RTEConfirmButtons a[id='RTEConfirmCancel'] span");
	private By RemovePhotoDialog = By.cssSelector("section.modalWrapper.RTEModal");
	private By OKbutton = By.cssSelector("a[id='RTEConfirmOk'] span");
	private By ImageOnPage = By.cssSelector("div.WikiaArticle figure a img");
	
//	private String CSS_RemovePhotoDialog = "section.modalWrapper.RTEModal";
//	private String CSS_ImageOnPage = "div.WikiaArticle figure a img";
	
	public WikiArticleEditMode(WebDriver driver, String wikiname,
			String articlename) {
		super(driver, wikiname, articlename);
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
		waitForElementByCss("span.cke_button.RTE"+Object+"Button");
		waitForElementClickableByCss("span.cke_button.RTE"+Object+"Button");
		PageObjectLogging.log("ClickOnAddObjectButton", "Edit Article: "+articlename+", on wiki: "+wikiname+"", true, driver);
		driver.findElement(By.cssSelector("span.cke_button.RTE"+Object+"Button")).click();
	}

	/**
	 * Wait for modal and click on 'add this photo' under the first seen photo
	 *  
	 * @author Michal Nowierski
	 */
	public void WaitForModalAndClickAddThisPhoto() {
		waitForElementByElement(ImageUploadModal);
		waitForElementClickableByBy(AddThisPhotoLink);
		PageObjectLogging.log("WaitForModalAndClickAddThisPhoto", "Wait for modal and click on 'add this photo' under the first seen photo", true, driver);
		driver.findElement(AddThisPhotoLink).click();
	
		
	}

	/**
	 * Type any caption for the photo
	 *  
	 * @author Michal Nowierski
	 */
	public void TypeCaption(String caption) {
		waitForElementByElement(CaptionTextArea);
		PageObjectLogging.log("TypeAcaption", "Type any caption for the photo", true, driver);
		CaptionTextArea.clear();
		CaptionTextArea.sendKeys(caption);
		
		
	}

	/**
	 * Left Click on add 'Photo' button.
	 *  
	 * @author Michal Nowierski
	 */
	public void ClickOnAddPhotoButton2() {
		waitForElementByBy(AddPhotoButton);
		waitForElementClickableByBy(AddPhotoButton);
		PageObjectLogging.log("ClickOnAddPhotoButton2", "Left Click on add 'Photo' button.", true, driver);
		driver.findElement(AddPhotoButton).click();
		
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
		PageObjectLogging.log("VerifyThatThePhotoAppears", "Verify that the photo appears in the visual mode", true, driver);
		wait.until(ExpectedConditions.visibilityOfElementLocated(By.cssSelector("img[data-rte-meta*='"+caption+"']")));
		// Now switch back to the normal DOM
		driver.switchTo().defaultContent();
		
	}

	/**
	 * Left Click on 'Preview' Button
	 *  
	 * @author Michal Nowierski
	 */
	public void ClickOnPreviewButton() {
		System.out.println();
		waitForElementByBy(PreviewButton);
		PageObjectLogging.log("LeftClickOnPreviewButton", "Left Click on 'Preview' Button", true, driver);
		waitForElementClickableByBy(PreviewButton);
		driver.findElement(PreviewButton).click();
		
		
	}

	/**
	 * Verify that the image appears in the preview
	 *  
	 * @author Michal Nowierski
	 */
	public void VerifyTheImageOnThePreview() {
		PageObjectLogging.log("VerifyTheImageOnThePreview", "Verify that the image appears in the preview", true, driver);
		waitForElementByBy(ImageOnPreview);
		wait.until(ExpectedConditions.visibilityOfElementLocated(ImageOnPreview));
		
	}

	/**
	 * Verify that the caption of image appears in the preview
	 *  
	 * @author Michal Nowierski
	 */
	public void VerifyTheCaptionOnThePreview(String caption) {
		PageObjectLogging.log("VerifyTheCaptionOnThePreview", "Verify that the caption of image appears in the preview", true, driver);
		wait.until(ExpectedConditions.textToBePresentInElement(CaptionInPreview, caption));

		
	}

	/**
	 * Click on 'Publish' button
	 *  
	 * @author Michal Nowierski
	 */
	public WikiArticlePageObject ClickOnPublishButtonInPreviewMode() {
		waitForElementByBy(PublishButtonPreview);
		PageObjectLogging.log("LeftClickOnPublishButtonInPreviewMode", "Click on 'Publish' button in preview mode", true, driver);
		waitForElementClickableByBy(PublishButtonPreview);
		driver.findElement(PublishButtonPreview).click();
	
		return new WikiArticlePageObject(driver, wikiname, articlename);
	}

	/**
	 * Click on 'Source' button
	 *  
	 * @author Michal Nowierski
	 */
	public void ClickOnSourceButton() {
		waitForElementByBy(SourceButton);
		PageObjectLogging.log("ClickOnSourceButton", "Click on 'Source' button", true, driver);
		waitForElementClickableByBy(SourceButton);
		driver.findElement(SourceButton).click();
		
	}
	
	/**
	 * Click on 'Source' button
	 *  
	 * @author Michal Nowierski
	 */
	public void ClickOnVisualButton() {
		waitForElementByBy(VisualButton);
		PageObjectLogging.log("ClickOnVisualButton", "Click on 'Visual' button", true, driver);
		waitForElementClickableByBy(VisualButton);
		driver.findElement(VisualButton).click();
		
	}
	
	/**
	 * Delete all source code on the article
	 *  
	 * @author Michal Nowierski
	 */
	public void deleteArticleContent() {
		ClickOnSourceButton();
		PageObjectLogging.log("deleteArticleContent", "Delete all source code on the article", true, driver);
		waitForElementByElement(SourceModeTextArea);
		SourceModeTextArea.clear();
		
	}

	/**
	 * Click  on Publish button
	 *  
	 * @author Michal Nowierski
	 */
	public WikiArticlePageObject ClickOnPublishButton() {
		waitForElementByBy(PublishButton);
		PageObjectLogging.log("ClickOnPublishButton", "Click on 'Publish' button", true, driver);
		waitForElementClickableByBy(PublishButton);
		driver.findElement(PublishButton).click();
	
		return new WikiArticlePageObject(driver, wikiname, articlename);
	}
	
	/**
	 * Hover your phisical mouse cursor over image. Identify image by its caption
	 *  
	 * @author Michal Nowierski
	 * @param caption Caption of the image 
	 * 	 */
	public void HoverCursorOverImage(String caption) {
		waitForElementByElement(iFrame);
		
		int headerY = header.getSize().getHeight();
		int iFrameX = iFrame.getLocation().getX();
		int iFrameY = iFrame.getLocation().getY();
		driver.switchTo().frame(iFrame);
		wait.until(ExpectedConditions.visibilityOfElementLocated(By.cssSelector("img[data-rte-meta*='"+caption+"']")));
		WebElement Image = driver.findElement(By.cssSelector("img[data-rte-meta*='"+caption+"']"));
		int ImageX = Image.getLocation().getX();
		int ImageY = Image.getLocation().getY();
		int ImageWidth = Image.getSize().getWidth();
		int ImageHeight = Image.getSize().getHeight();
		
		PageObjectLogging.log("HoverCursorOverImage", "Hover your phisical mouse cursor over image.", true, driver);
		CommonFunctions.MoveCursorTo(iFrameX+ImageX+(ImageWidth/2), iFrameY+headerY+2*ImageY+(ImageHeight/2));
		driver.switchTo().defaultContent();
		
	}
	



	/**
	 * Click on 'modify button' of image with given caption
	 *  
	 * @author Michal Nowierski
	 * @param caption Caption of the image 
	 * 	 */
	public void ClickModifyButtonOfImage(String caption) {
		HoverCursorOverImage(caption);
		waitForElementByBy(ModifyButton);
		waitForElementClickableByBy(ModifyButton);
		PageObjectLogging.log("ClickModifyButtonOfImage", "Click on 'modify button' of image with caption: '"+caption+"'", true, driver);
		driver.findElement(ModifyButton).click();

		
	}

	/**
	 * Click on 'remove button' of image with given caption
	 *  
	 * @author Michal Nowierski
	 * @param caption Caption of the image 
	 * 	 */
	public void ClickRemoveButtonOfImage(String caption) {
		PageObjectLogging.log("ClickRemoveButtonOfImage", "Click on 'remove button' of image with caption: '"+caption+"'", true, driver);
		WebElement Button = driver.findElement(RemoveButton);
		CommonFunctions.MoveCursorTo(0, 0);
		HoverCursorOverImage(caption);
		waitForElementByBy(RemoveButton);
		waitForElementClickableByBy(RemoveButton);
		Button.click();
		
	}

	/**
	 * Left Click on Cancel button
	 *  
	 * @author Michal Nowierski
	 * 	 */
	public void LeftClickCancelButton() {
		waitForElementByBy(CancelImageRemovalButton);
		waitForElementClickableByBy(CancelImageRemovalButton);
		PageObjectLogging.log("LeftClickCancelButton", "Left Click on Cancel button", true, driver);
		driver.findElement(CancelImageRemovalButton).click();
				
	}

	/**
	 * Verify that 'Remove this photo?' modal has disappeared
	 *  
	 * @author Michal Nowierski
	 * 	 */
	public void VerifyModalDisappeared() {
		PageObjectLogging.log("VerifyModalDisappeared", "Verify that 'Remove this photo?' modal has disappeared", true, driver);
//		waitForElementNotVisibleByBy(RemovePhotoDialog);
		wait.until(ExpectedConditions.invisibilityOfElementLocated(RemovePhotoDialog));		
	}

	/**
	 * Left Click on Ok button on remove photo dialog
	 *  
	 * @author Michal Nowierski
	 * 	 */
	public void LeftClickOkButton() {
		waitForElementByBy(OKbutton);
		waitForElementClickableByBy(OKbutton);
		PageObjectLogging.log("LeftClickOkButton", "Left Click on Ok button on remove photo dialog", true, driver);
		driver.findElement(OKbutton).click();
		
		
	}

	/**
	 * Verify that the image does not appear on the page
	 *  
	 * @author Michal Nowierski
	 * 	 */
	public void VerifyTheImageNotOnThePage() {
		PageObjectLogging.log("VerifyTheImageNotOnThePage", "Verify that the image does not appear on the page", true, driver);
		wait.until(ExpectedConditions.invisibilityOfElementLocated(ImageOnPage));
//		waitForElementNotVisibleByBy(ImageOnPage);
				
	}








}
