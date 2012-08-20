package com.wikia.webdriver.pageObjects.PageObject.WikiPage;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.PageFactory;
import org.openqa.selenium.support.ui.ExpectedConditions;

import com.wikia.webdriver.Common.Core.CommonFunctions;
import com.wikia.webdriver.Common.Logging.PageObjectLogging;
import com.wikia.webdriver.pageObjects.PageObject.WikiBasePageObject;

public class WikiArticlePageObject extends WikiBasePageObject {
	
	protected String articlename;
	
	@FindBy(css="a[accesskey='e']")
	private WebElement EditButton;
	@FindBy(css="section.RelatedVideosModule")
	private WebElement RVModule;
	@FindBy(css="input.videoUrl")
	private WebElement VideoRVmodalInput;
	
	private By ImageOnWikiaArticle = By.cssSelector("div.WikiaArticle figure a img");
	private By VideoOnWikiaArticle = By.cssSelector("div.WikiaArticle span.Wikia-video-play-button");
	private By AddVideoRVButton = By.cssSelector("a.addVideo");
	private By VideoModalAddButton = By.cssSelector("button.relatedVideosConfirm");
	private By RVvideoLoading = By.cssSelector("section.loading");
	
	

	public WikiArticlePageObject(WebDriver driver, String Domain,
			String wikiArticle) {
		super(driver, Domain);
		this.articlename = wikiArticle;
		PageFactory.initElements(driver, this);
	}

	/**
	 * Click Edit button on a wiki article
	 *  
	 * @author Michal Nowierski
	 */
	public WikiArticleEditMode Edit() {
		waitForElementByElement(EditButton);
		PageObjectLogging.log("Edit", "Edit Article: "+articlename+", on wiki: "+Domain+"", true, driver);
		EditButton.click();
		return new WikiArticleEditMode(driver, Domain, articlename);
	}

	/**
	 * Verify that the image appears on the page
	 *  
	 * @author Michal Nowierski
	 */
	public void VerifyTheImageOnThePage() {
		PageObjectLogging.log("VerifyTheImageOnThePage", "Verify that the image appears on the page", true, driver);
		waitForElementByBy(ImageOnWikiaArticle);
				
	}
	
	/**
	 * Verify that the image does not appear on the page
	 *  
	 * @author Michal Nowierski
	 */
	public void VerifyTheImageNotOnThePage() {
		PageObjectLogging.log("VerifyTheImageNotOnThePage", "Verify that the image does not appear on the page", true, driver);
		waitForElementNotVisibleByBy(ImageOnWikiaArticle);
						
	}
	
	/**
	 * Verify that the Object appears on the page
	 *  
	 * @author Michal Nowierski
	 * @param Object Object = {gallery, slideshow}
	 * 	 */
	public void VerifyTheObjetOnThePage(String Object) {
		PageObjectLogging.log("VerifyTheObjetOnThePage", "Verify that the "+Object+" appears on the page", true, driver);
		wait.until(ExpectedConditions.visibilityOfElementLocated(By.cssSelector("div.WikiaArticle div[id*='"+Object+"']")));
		
	}
	
	/**
	 * Verify that the Video appears on the page
	 *  
	 * @author Michal Nowierski
	 * 	 */
	public void VerifyTheVideoOnThePage() {
		PageObjectLogging.log("VerifyTheVideoOnThePage", "Verify that the Video appears on the page", true, driver);
		waitForElementByBy(VideoOnWikiaArticle);
				
	}
	
	/**
	 * Verify that the RV Module Is Present
	 *  
	 * @author Michal Nowierski
	 * 	 */
	public void VerifyRVModulePresence() {
		PageObjectLogging.log("VerifyRVModulePresence", "Verify that the RV Module Is Present", true, driver);
		waitForElementByElement(RVModule);
		
	}

	/**
	 * Click On 'Add a video' button on RV module
	 *  
	 * @author Michal Nowierski
	 * 	 */
	public void ClickOnAddVideoRVModule() {
		PageObjectLogging.log("ClickOnAddVideoRVModule", "Click On 'Add a video' button on RV module", true, driver);
		waitForElementByBy(AddVideoRVButton);
		CommonFunctions.scrollToElement(driver.findElement(AddVideoRVButton));
		waitForElementClickableByBy(AddVideoRVButton);
		driver.findElement(AddVideoRVButton).click();
			
	}

	/**
	 * Type given URL into RV modal
	 *  
	 * @author Michal Nowierski
	 * @param videoURL URL of the video to be added
	 * 	 */
	public void TypeInVideoURL(String videoURL) {
		PageObjectLogging.log("TypeInVideoURL", "Type given URL into RV modal", true, driver);
		waitForElementByElement(VideoRVmodalInput);		
		VideoRVmodalInput.clear();
		VideoRVmodalInput.sendKeys(videoURL);
	}

	/**
	 * Click on Add button on RV modal
	 *  
	 * @author Michal Nowierski
	 * 	 */
	public void ClickOnRVModalAddButton() {
		PageObjectLogging.log("ClickOnRVModalAddButton", "Click on Add button on RV modal", true, driver);
		waitForElementByBy(VideoModalAddButton);
		waitForElementClickableByBy(VideoModalAddButton);
		driver.findElement(VideoModalAddButton).click();
		
	}

	/**
	 * Wait for processing the added video to finish
	 *  
	 * @author Michal Nowierski
	 * 	 */
	public void WaitForProcessingToFinish() {
		PageObjectLogging.log("WaitForProcessingToFinish", "Wait for processing the added video to finish", true, driver);
		waitForElementNotVisibleByBy(RVvideoLoading);
		
	}

	/**
	 * Verify that video given by its name has been added to RV module
	 *  
	 * @author Michal Nowierski
	 * @param videoURL2name The name of the video, or any fragment of the video name
	 * 	 */
	public void VerifyVideoAddedToRVModule(String videoURL2name) {
		PageObjectLogging.log("VerifyVideoAddedToRVModule", "Verify that video given by its name has been added to RV module", true, driver);
		waitForElementByCss("img[data-video*='"+videoURL2name+"']");
		
	}

}
