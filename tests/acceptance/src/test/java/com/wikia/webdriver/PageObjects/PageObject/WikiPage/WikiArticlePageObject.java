package com.wikia.webdriver.PageObjects.PageObject.WikiPage;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.PageFactory;
import org.openqa.selenium.support.ui.ExpectedConditions;

import com.wikia.webdriver.Common.Core.CommonFunctions;
import com.wikia.webdriver.Common.Logging.PageObjectLogging;
import com.wikia.webdriver.PageObjects.PageObject.WikiBasePageObject;

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
		EditButton.click();
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
	public void VerifyTheImageNotOnThePage() {
		waitForElementNotVisibleByBy(ImageOnWikiaArticle);
		PageObjectLogging.log("VerifyTheImageNotOnThePage", "Verify that the image does not appear on the page", true, driver);
						
	}
	
	/**
	 * Verify that the Object appears on the page
	 *  
	 * @author Michal Nowierski
	 * @param Object Object = {gallery, slideshow}
	 * 	 */
	public void VerifyTheObjetOnThePage(String Object) {
		wait.until(ExpectedConditions.visibilityOfElementLocated(By.cssSelector("div.WikiaArticle div[id*='"+Object+"']")));
		PageObjectLogging.log("VerifyTheObjetOnThePage", "Verify that the "+Object+" appears on the page", true, driver);
		
	}
	
	/**
	 * Verify that the Video appears on the page
	 *  
	 * @author Michal Nowierski
	 * 	 */
	public void VerifyTheVideoOnThePage() {
		waitForElementByBy(VideoOnWikiaArticle);
		PageObjectLogging.log("VerifyTheVideoOnThePage", "Verify that the Video appears on the page", true, driver);
				
	}
	
	/**
	 * Verify that the RV Module Is Present
	 *  
	 * @author Michal Nowierski
	 * 	 */
	public void VerifyRVModulePresence() {
		waitForElementByElement(RVModule);
		PageObjectLogging.log("VerifyRVModulePresence", "Verify that the RV Module Is Present", true, driver);
		
	}

	/**
	 * Click On 'Add a video' button on RV module
	 *  
	 * @author Michal Nowierski
	 * 	 */
	public void ClickOnAddVideoRVModule() {
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
	public void TypeInVideoURL(String videoURL) {
		waitForElementByElement(VideoRVmodalInput);		
		VideoRVmodalInput.clear();
		VideoRVmodalInput.sendKeys(videoURL);
		PageObjectLogging.log("TypeInVideoURL", "Type given URL into RV modal", true, driver);
	}

	/**
	 * Click on Add button on RV modal
	 *  
	 * @author Michal Nowierski
	 * 	 */
	public void ClickOnRVModalAddButton() {
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
	public void WaitForProcessingToFinish() {
		waitForElementNotVisibleByBy(RVvideoLoading);
		PageObjectLogging.log("WaitForProcessingToFinish", "Wait for processing the added video to finish", true, driver);
		
	}

	/**
	 * Verify that video given by its name has been added to RV module
	 *  
	 * @author Michal Nowierski
	 * @param videoURL2name The name of the video, or any fragment of the video name
	 * 	 */
	public void VerifyVideoAddedToRVModule(String videoURL2name) {
		waitForElementByCss("img[data-video*='"+videoURL2name+"']");
		PageObjectLogging.log("VerifyVideoAddedToRVModule", "Verify that video given by its name has been added to RV module", true, driver);
		
	}

}
