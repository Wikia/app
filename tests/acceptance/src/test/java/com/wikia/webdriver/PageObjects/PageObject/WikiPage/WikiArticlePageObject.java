package com.wikia.webdriver.PageObjects.PageObject.WikiPage;

import org.openqa.selenium.By;
import org.openqa.selenium.JavascriptExecutor;
import org.openqa.selenium.Point;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.PageFactory;
import org.openqa.selenium.support.ui.ExpectedConditions;

import com.wikia.webdriver.Common.Core.CommonFunctions;
import com.wikia.webdriver.Common.Core.Global;
import com.wikia.webdriver.Common.Logging.PageObjectLogging;
import com.wikia.webdriver.PageObjects.PageObject.WikiBasePageObject;

public class WikiArticlePageObject extends WikiBasePageObject {
	
	protected String articlename;
	
	@FindBy(css="div.WikiaPageHeaderDiffHistory")
	private WebElement historyHeadLine;
	@FindBy(css="section.RelatedVideosModule")
	private WebElement rVModule;
	@FindBy(css="input.videoUrl")
	private WebElement videoRVmodalInput;
	@FindBy(css="div[class='editarea']")
	private WebElement editCommentTrigger;
	@FindBy(css="body[id='bodyContent']")
	private WebElement editCommentArea;
	@FindBy(css="div.cke_contents iframe")
	private WebElement iframe;
	@FindBy(css="input[id*='article-comm-submit']")
	private WebElement submitCommentButton;
	@FindBy(css="a.article-comm-delete")
	private WebElement deleteCommentButton;
	@FindBy(css="span.edit-link a")
	private WebElement editCommentButton;
	@FindBy(css="input[id*='article-comm-reply']")
	private WebElement submitReplyButton;
	
	private By ImageOnWikiaArticle = By.cssSelector("div.WikiaArticle figure a img");
	private By VideoOnWikiaArticle = By.cssSelector("div.WikiaArticle span.Wikia-video-play-button");
	private By AddVideoRVButton = By.cssSelector("a.addVideo");
	private By VideoModalAddButton = By.cssSelector("button.relatedVideosConfirm");
	private By RVvideoLoading = By.cssSelector("section.loading");
	private By galleryOnPublish = By.cssSelector("div[class*='gallery']");
	private By slideShowOnPublish = By.cssSelector("div.wikia-slideshow");
	private By videoOnPublish = By.cssSelector("a.image.video");
	

	public WikiArticlePageObject(WebDriver driver, String Domain,
			String wikiArticle) {
		super(driver, Domain);
		this.articlename = wikiArticle;
		PageFactory.initElements(driver, this);
	}
	
	public void triggerCommentArea()
	{
		jQueryFocus("textarea#article-comm");
	}
	
	public void writeOnCommentArea(String comment)
	{
		driver.switchTo().frame(iframe);
		waitForElementByElement(editCommentArea);
		editCommentArea.clear();
		if (Global.BROWSER.equals("FF"))
		{
			((JavascriptExecutor) driver).executeScript("document.body.innerHTML='" + comment + "'");
		}
		else
		{			
			editCommentArea.sendKeys(comment);
		}
		driver.switchTo().defaultContent();
	}
	
	public void clickSubmitButton()
	{
//		submitCommentButton.click();
		executeScript("document.querySelectorAll('#article-comm-submit')[0].click()");
		PageObjectLogging.log("clickSubmitButton", "submit article button clicked", true, driver);
//		return new WikiArticlePageObject(driver, Domain, articlename);
	}
	
	public void clickSubmitButton(String userName)
	{		
		click(driver.findElement(By.xpath("//a[contains(text(), '"+userName+"')]/../../..//input[@class='actionButton']")));//submit button taken by username which edited comment
		PageObjectLogging.log("clickSubmitButton", "submit article button clicked", true, driver);
//		return new WikiArticlePageObject(driver, Domain, articlename);
	}
	
	public void verifyComment(String message, String userName)
	{
		waitForElementByXPath("//blockquote//p[contains(text(), '"+message+"')]");
		waitForElementByXPath("//div[@class='edited-by']//a[contains(text(), '"+userName+"')]");
		PageObjectLogging.log("verifyComment", "comment: "+message+" is visible", true, driver);
	}
	
	private void clickReplyCommentButton(String comment)
	{
		waitForElementByXPath("//p[contains(text(), '"+comment+"')]//..//..//button[contains(text(), 'Reply')]");
		click(driver.findElement(By.xpath("//p[contains(text(), '"+comment+"')]//..//..//button[contains(text(), 'Reply')]")));
		waitForElementByElement(iframe);
		PageObjectLogging.log("clickReplyCommentButton", "reply comment button clicked", true);
	}
	
	
	private void writeReply(String reply)
	{
		waitForElementByElement(iframe);
		driver.switchTo().frame(iframe);
		editCommentArea.sendKeys(reply);
		driver.switchTo().defaultContent();
		click(submitReplyButton);
		waitForElementByXPath("//p[contains(text(), '"+reply+"')]");
		PageObjectLogging.log("writeReply", "reply comment written", true);
	}
	
	
	public void replyComment(String comment, String reply)
	{
		driver.navigate().refresh();
		clickReplyCommentButton(comment);
		writeReply(reply);
		PageObjectLogging.log("reply comment", "reply comment written and checked", true, driver);
	}
	
//	private void hoverMouseOverCommentArea(String commentContent)
//	{
//		WebElement commentArea = driver.findElement(By.xpath("//p[contains(text(), '"+commentContent+"')]"));
//		Point p = commentArea.getLocation();
//		CommonFunctions.MoveCursorToElement(p, driver);
//		PageObjectLogging.log("hoverMouseOverCommentArea", "mouse moved to comment area", true, driver);
//	}
	
	private void clickDeleteCommentButton()
	{
		executeScript("document.querySelectorAll('.article-comm-delete')[0].click()");
//		deleteCommentButton.click();
		PageObjectLogging.log("clickDeleteCommentButton", "delete comment button clicked", true, driver);
	}
	
	private void clickEditCommentButton()
	{
//		waitForElementByElement(editCommentButton);
//		clickRobot(editCommentButton);
//		editCommentButton.click();
		executeScript("document.querySelectorAll('.article-comm-edit')[0].click()");
		waitForElementByElement(iframe);
		PageObjectLogging.log("clickEditCommentButton", "edit comment button clicked", true, driver);
	}
	
	public void deleteComment(String comment)
	{
		((JavascriptExecutor)driver).executeScript("window.scrollTo(0,0)");
//		hoverMouseOverCommentArea(comment);
		clickDeleteCommentButton();
		clickCommentDeleteConfirmationButton();
		PageObjectLogging.log("deleteComment", "comment deleted", true, driver);
	}
	
	public void editComment(String comment)
	{
		driver.navigate().refresh();
//		hoverMouseOverCommentArea(comment);
		clickEditCommentButton();
	}
	
	public void verifyPageTitle(String title)
	{
		title = title.replace("_", " ");
		waitForElementByXPath("//h1[contains(text(), '"+title+"')]");
		PageObjectLogging.log("verifyPageTitle", "page title is verified", true, driver);
	}
	
	public void verifyArticleText(String content)
	{
		waitForElementByXPath("//div[@id='mw-content-text']//*[contains(text(), '"+content+"')]");
		PageObjectLogging.log("verifyArticleText", "article text is verified", true, driver);
	}
	
	
	/**
	 * Click Edit button on a wiki article
	 *  
	 * @author Michal Nowierski
	 */
	public WikiArticleEditMode edit() {
		waitForElementByElement(editButton);
		editButton.click();
		PageObjectLogging.log("Edit", "Edit Article: "+articlename+", on wiki: "+Domain+"", true, driver);
		return new WikiArticleEditMode(driver, Domain, articlename);
	}

	/**
	 * Verify that the image appears on the page
	 *  
	 * @author Michal Nowierski
	 */
	public void VerifyTheImageOnThePage() {
		waitForElementByBy(ImageOnWikiaArticle);
		PageObjectLogging.log("VerifyTheImageOnThePage", "Verify that the image appears on the page", true, driver);
	}
	
	/**
	 * Verify that the image does not appear on the page
	 *  
	 * @author Michal Nowierski
	 */
	public void verifyTheImageNotOnThePage() {
		waitForElementNotVisibleByBy(ImageOnWikiaArticle);
		PageObjectLogging.log("VerifyTheImageNotOnThePage", "Verify that the image does not appear on the page", true, driver);	
	}
	
	public void verifyTheGalleryNotOnThePage() {
		waitForElementNotVisibleByBy(galleryOnPublish);
		PageObjectLogging.log("verifyTheGalleryNotOnThePage", "Verify that the gallery does not appear on the page", true, driver);	
	}
	
	public void verifyTheSlideshowNotOnThePage() 
	{
		waitForElementNotVisibleByBy(slideShowOnPublish);
		PageObjectLogging.log("verifyTheSlideshowNotOnThePage", "Verify that the slideshow does not appear on the page", true, driver);			
	}
	
	public void verifyTheVideoNotOnThePage() {
		waitForElementNotVisibleByBy(videoOnPublish);
		PageObjectLogging.log("verifyTheVideoNotOnThePage", "Verify that the video does not appear on the page", true, driver);
	}

	/**
	 * Verify that the Object appears on the page
	 *  
	 * @author Michal Nowierski
	 * @param Object Object = {gallery, slideshow}
	 * 	 */
	public void verifyTheObjectOnThePage(String Object) {
		wait.until(ExpectedConditions.visibilityOfElementLocated(By.cssSelector("div.WikiaArticle div[id*='"+Object+"']")));
		PageObjectLogging.log("VerifyTheObjetOnThePage", "Verify that the "+Object+" appears on the page", true, driver);
		
	}
	
	/**
	 * Verify that the Video appears on the page
	 *  
	 * @author Michal Nowierski
	 * 	 */
	public void verifyTheVideoOnThePage() {
		waitForElementByBy(VideoOnWikiaArticle);
		PageObjectLogging.log("VerifyTheVideoOnThePage", "Verify that the Video appears on the page", true, driver);
	}
	
	/**
	 * Verify that the RV Module Is Present
	 *  
	 * @author Michal Nowierski
	 * 	 */
	public void verifyRVModulePresence() {
		waitForElementByElement(rVModule);
		PageObjectLogging.log("VerifyRVModulePresence", "Verify that the RV Module Is Present", true, driver);
		
	}

	/**
	 * Click On 'Add a video' button on RV module
	 *  
	 * @author Michal Nowierski
	 * 	 */
	public void clickOnAddVideoRVModule() {
		waitForElementByBy(AddVideoRVButton);
		CommonFunctions.scrollToElement(driver.findElement(AddVideoRVButton));
		waitForElementClickableByBy(AddVideoRVButton);
		driver.findElement(AddVideoRVButton).click();
		PageObjectLogging.log("ClickOnAddVideoRVModule", "Click On 'Add a video' button on RV module", true, driver);
			
	}

	/**
	 * Type given URL into RV modal
	 *  
	 * @author Michal Nowierski
	 * @param videoURL URL of the video to be added
	 * 	 */
	public void typeInVideoURL(String videoURL) {
		waitForElementByElement(videoRVmodalInput);		
		videoRVmodalInput.clear();
		videoRVmodalInput.sendKeys(videoURL);
		PageObjectLogging.log("TypeInVideoURL", "Type given URL into RV modal", true, driver);
	}

	/**
	 * Click on Add button on RV modal
	 *  
	 * @author Michal Nowierski
	 * 	 */
	public void clickOnRVModalAddButton() {
		waitForElementByBy(VideoModalAddButton);
		waitForElementClickableByBy(VideoModalAddButton);
		driver.findElement(VideoModalAddButton).click();
		PageObjectLogging.log("ClickOnRVModalAddButton", "Click on Add button on RV modal", true, driver);
		
	}

	/**
	 * Wait for processing the added video to finish
	 *  
	 * @author Michal Nowierski
	 * 	 */
	public void waitForProcessingToFinish() {
		waitForElementNotVisibleByBy(RVvideoLoading);
		PageObjectLogging.log("WaitForProcessingToFinish", "Wait for processing the added video to finish", true, driver);
		
	}

	/**
	 * Verify that video given by its name has been added to RV module
	 *  
	 * @author Michal Nowierski
	 * @param videoURL2name The name of the video, or any fragment of the video name
	 * 	 */
	public void verifyVideoAddedToRVModule(String videoURL2name) {
		waitForElementByCss("img[data-video*='"+videoURL2name+"']");
		PageObjectLogging.log("VerifyVideoAddedToRVModule", "Verify that video given by its name has been added to RV module", true, driver);
		
	}

	public void verifyGalleryPosion(String position) {
		waitForElementByCss("div.wikia-gallery-position-"+position);
		PageObjectLogging.log("verifyGalleryPosion", "Gallery position verified: "+position, true, driver);
	}

	public void verifySlideshowPosition(String position) {
		if (position.equals("left")||position.equals("right"))
		{
			waitForElementByCss("div.wikia-slideshow.float"+position);
			PageObjectLogging.log("verifySlideshowPosion", "Slideshow position verified: "+position, true, driver);
		}
		else if (position.equals("center"))
		{
			waitForElementByCss("div.wikia-slideshow.slideshow-center");			
			PageObjectLogging.log("verifySlideshowPosion", "Slideshow position verified: "+position, true, driver);
		}
		
	}
/**
 * 
 * @param position available values (vertical, horizontal)
 */
	public void verifySliderThumbnailsPosition(String position) {
		waitForElementByCss(".wikiaPhotoGallery-slider-body div."+position);
		PageObjectLogging.log("verifySliderThumbnailsPosition", "Slider thumbnails position verified: "+position, true, driver);		
	}

	public WikiHistoryPageObject openHistoryPage()
	{
		driver.get(driver.getCurrentUrl() + "?action=history");
		waitForElementByElement(historyHeadLine);
		return new WikiHistoryPageObject(driver, articlename, articlename);
	}



}