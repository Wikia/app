package com.wikia.webdriver.PageObjects.PageObject;

import org.openqa.selenium.Point;
import java.util.List;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.PageFactory;
import org.openqa.selenium.support.ui.ExpectedConditions;

import com.wikia.webdriver.Common.Core.CommonFunctions;
import com.wikia.webdriver.Common.Logging.PageObjectLogging;

public class HubBasePageObject extends BasePageObject{
	//Author Michal Nowierski
	@FindBy(css="div.button.scrollleft p") 
	private WebElement RelatedVideosScrollLeft;
	@FindBy(css="div.button.scrollright p") 
	private WebElement RelatedVideosScrollRight;
	@FindBy(css="form.WikiaSearch input[name='search']") 
	private WebElement SearchField;
	@FindBy(css="form.WikiaSearch button.wikia-button") 
	private WebElement SearchButton;
	@FindBy(css="form.WikiaSearch button.wikia-button") 
	private WebElement NewsTabsNav;
	@FindBy(css="section.modalWrapper") 
	private WebElement VideoPlayer;
	@FindBy(css="button.wikia-chiclet-button img") 
	private WebElement modalWrapper_X_CloseButton;
	@FindBy(css="button.cancel") 
	private WebElement modalWrapper_Cancel_CloseButton;
	@FindBy(css="button[id='suggestVideo']") 
	private WebElement suggestVideoButton;
	@FindBy(css="section.modalWrapper") 
	private WebElement suggestVideoModal;
	@FindBy(css="section.modalWrapper h1") 
	private WebElement suggestVideoModalTopic;
	@FindBy(css="div.videourl input") 
	private WebElement suggestVideoWhatVideoInput;
	@FindBy(css="div.wikiname input") 
	private WebElement suggestVideoWhichWikiInput;
	@FindBy(css="button.submit") 
	private WebElement submitButton;
		
	By MosaicSliderLargeImageDescription = By.cssSelector("div.wikia-mosaic-slider-description span.description-more");
	By NewsTabsList = By.cssSelector("div.tabbertab");
	By RelatedVideosList = By.cssSelector("div.container div.item");
	
	int RVmoduleCurrentVideosSet;
	
	public HubBasePageObject(WebDriver driver) {
		super(driver);
		PageFactory.initElements(driver, this);
		RVmoduleCurrentVideosSet = 1;
	}

	public void ClickOnNewsTab(int TabNumber) {
		PageObjectLogging.log("ClickOnNewsTab", "Click on news tab number "+TabNumber+".", true, driver);
		List<WebElement> newstabs = driver.findElements(By.cssSelector("section.wikiahubs-newstabs ul.tabbernav li a"));
		waitForElementClickableByCss("section.wikiahubs-newstabs ul.tabbernav li a");
		newstabs.get(TabNumber - 1).click();

	}
	public void RelatedVideosScrollLeft() {
		PageObjectLogging.log("RelatedVideosScrollLeft", "RV module: scroll left", true, driver);
		waitForElementClickableByElement(RelatedVideosScrollLeft);
		RelatedVideosScrollLeft.click();
		--RVmoduleCurrentVideosSet;
		}
	
	public void RelatedVideosScrollRight() {
		PageObjectLogging.log("RelatedVideosScrollRight", "RV module: scroll right", true, driver);
		waitForElementClickableByElement(RelatedVideosScrollRight);
		RelatedVideosScrollRight.click();
		++RVmoduleCurrentVideosSet;
	}
	public HomePageObject BackToHomePage() {
		PageObjectLogging.log("navigate to www.wikia.com", "", true, driver);
		return new HomePageObject(driver);
	}

	/**
	 * Allows to type into a search filed the given SearchString
	 * <p>
	 * This method is global for all WikiaSearch forms on all of the wikis
	 *
	 * @author Michal Nowierski
	 * @param  SearchString  Specifies what you want to search for
	 */
	public void SearchFieldTypeIn(String SearchString) {
		PageObjectLogging.log("Type " + SearchString
				+ " String into the search field ", "", true, driver);
		SearchField.sendKeys(SearchString);
		}

	/**
	 * Allows to left click on search button in order to initiate searching.
	 * <p>
	 * This method is global for all WikiaSearch forms on all of the wikis
	 * The method should be invoked after SearchFieldType method
	 *
	 * @author Michal Nowierski
	 * @param  SearchString  Specifies what you want to search for
	 */
	public void SearchButtonClick() {
		PageObjectLogging.log("Left click on the WikiaSearch button", "", true, driver);
		SearchButton.click();
		
		
	}
	
	public void MosaicSliderVerifyHasImages() {
		PageObjectLogging.log("MosaicSliderVerifyHasImages", "Verify that WikiaMosaicSlider has images", true, driver);
		List<WebElement> WikiaMosaicSliderPanoramaImages = driver.findElements(By.cssSelector("div.wikia-mosaic-slider-panorama"));
		List<WebElement> WikiaMosaicSliderThumbRegionImages = driver.findElements(By.cssSelector("ul.wikia-mosaic-thumb-region img"));
		waitForElementByElement(WikiaMosaicSliderPanoramaImages.get(0));
		for (int i = 0; i < 5; i++) {
			waitForElementByElement(WikiaMosaicSliderThumbRegionImages.get(i));
		}
	}
	
	/**
	 * Verifies that the given URL is one of the searching process results. You must be 100% sure that the URL will be found after searching
	 * <p>
	 * The method should be invoked after SearchButtonClick method
	 *
	 * @author Michal Nowierski
	 * @param  URL  Specifies what URL you expect as 100% sure result of searching
	 */
	protected void SearchResultsVerifyFoundURL(String URL) {
		PageObjectLogging.log("Verify if " + URL
				+ " URL is one of found the results", "", true, driver);
		
			wait.until(ExpectedConditions.visibilityOfElementLocated(By
					.cssSelector("li.result a[href='"+URL+"']")));

		
	}

	/**
	 * Hover Over Image number 'n'on Mosaic Slider
	 * 
	 * @param  n number of the image n={1,2,3,4,5}
	 * @author Michal Nowierski
	 */
	public void MosaicSliderHoverOverImage(int n) {
		PageObjectLogging.log("MosaicSliderHoverOverImage", "MosaicSlider: Hover over image number"+n, true, driver);
		if (n>5) {
			PageObjectLogging.log("MosaicSliderHoverOverImage", "MosaicSlider: The n parameter must be less than 5. It can not be: n = "+n, false, driver);
			return;
		}
		waitForElementByBy(By.cssSelector("ul.wikia-mosaic-thumb-region img"));
		List<WebElement> WikiaMosaicSliderPanoramaImages = driver.findElements(By.cssSelector("div.wikia-mosaic-slider-panorama"));
		List<WebElement> WikiaMosaicSliderThumbRegionImages = driver.findElements(By.cssSelector("ul.wikia-mosaic-thumb-region img"));
		waitForElementByElement(WikiaMosaicSliderThumbRegionImages.get(n-1));
		Point ImageLocation = WikiaMosaicSliderThumbRegionImages.get(n-1).getLocation();
		CommonFunctions.MoveCursorToElement(ImageLocation);
		
	}

	/**
	 * Get title of current LargeImage on Mosaic Slider
	 * 
	 * @author Michal Nowierski
	 */
	public String MosaicSliderGetCurrentLargeImageDescription() {
		PageObjectLogging.log("MosaicSliderGetCurrentLargeImage", "Get title of current LargeImage on Mosaic Slider", true, driver);
		WebElement MosaicSliderLargeImageDesc = driver.findElement(MosaicSliderLargeImageDescription);
		waitForElementByElement(MosaicSliderLargeImageDesc);
		String description = MosaicSliderLargeImageDesc.getText();
		return description;
	}
	
	/**
	 * Verify that Large Image has changed (by verifying description change), and get the current description
	 * 
	 * @param  n number of the image n={1,2,3,4,5}
	 * @author Michal Nowierski
	 */
	public String MosaicSliderVerifyLargeImageChangeAndGetCurrentDescription(
			String PreviousLargeImageDescription) {
		PageObjectLogging.log("MosaicSliderVerifyLargeImageChangeAndGetCurrentDescription", "Verify that Large Image has changed", true, driver);
		String CurrentDescription = MosaicSliderGetCurrentLargeImageDescription();
		if (CurrentDescription.equals(PreviousLargeImageDescription)) {
			PageObjectLogging.log("MosaicSliderVerifyLargeImageChangeAndGetCurrentDescription", "Large Image hasn't changed", false, driver);
			
		}
		return CurrentDescription;
	}

	/**
	 * Verify that News tabs bar is present and content of newstab number n is present as well
	 *
	 * @param  n number of the tab n={1,2,3}
	 * @author Michal Nowierski
	 *
	 */
	public void VerifyNewsTabsPresence(int n) {
		PageObjectLogging.log("VerifyNewsTabsPresence", "Verify that News tabs bar is present and content of newstab number '"+n+"' is present as well", true, driver);
		waitForElementByElement(NewsTabsNav);
		List<WebElement> NewsTabs = driver.findElements(NewsTabsList);
		WebElement NewsTab = NewsTabs.get(n-1);
		waitForElementByElement(NewsTab);
		
	}

	/**
	 * Verify that given  set of videos appears in Related Videos
	 *
	 * @param  n number of the tab n={1,2,3,4 (...)}
	 * @author Michal Nowierski
	 *
	 */
	public void VerifyRelatedVideosPresence() {
		int n = RVmoduleCurrentVideosSet;
		PageObjectLogging.log("VerifyRelatedVideosPresence", "Verify that News tabs bar is present and content of newstab number '"+n+"' is present as well", true, driver);
		waitForElementByBy(RelatedVideosList);
		List<WebElement> NewsTabs = driver.findElements(RelatedVideosList);
		WebElement Video1 = NewsTabs.get(3*n-1);
		waitForElementByElement(Video1);
		WebElement Video2 = NewsTabs.get(3*n-2);
		waitForElementByElement(Video2);
		WebElement Video3 = NewsTabs.get(3*n-3);
		waitForElementByElement(Video3);				
	}

	public void ClickOnRelatedVideo(int i) {
		int n = RVmoduleCurrentVideosSet;
		PageObjectLogging.log("ClickOnRelatedVideo", "Click on related video number "+i+"' is present as well", true, driver);
		waitForElementByBy(RelatedVideosList);
		List<WebElement> NewsTabs = driver.findElements(RelatedVideosList);
		WebElement Video = NewsTabs.get(3*n-4+i);
		waitForElementByElement(Video);
		waitForElementClickableByElement(Video);	
		Video.click();
	}

	/**
	 * Verify that video player appeared
	 * 
	 * @author Michal Nowierski
	 */
	public void VerifyVideoPlayerAppeared() {
		PageObjectLogging.log("VerifyVideoPlayerAppeared", "Verify that video player appeared", true, driver);
		waitForElementByElement(VideoPlayer);
		
	}

	/**
	 * Click on [x] to close video player
	 * 
	 * @author Michal Nowierski
	 */
	public void Click_X_toCloseVideoPlayer() {
		PageObjectLogging.log("Click_X_toCloseVideoPlayer", "Click on [x] to close video player", true, driver);
		closeModalWrapper();		
	}

	/**
	 * Click on suggest video button
	 * 
	 * @author Michal Nowierski
	 */
	public void ClickSuggestAVideo() {
		PageObjectLogging.log("ClickSuggestAVideo", "Click on suggest video button", true, driver);
		waitForElementByElement(suggestVideoButton);
		CommonFunctions.scrollToElement(suggestVideoButton);
		waitForElementClickableByElement(suggestVideoButton);	
		suggestVideoButton.click();
		
	}

	/**
	 * Verify that suggest a video modal appeared
	 * 
	 * @author Michal Nowierski
	 */
	public void VerifySuggestAVideoModalAppeared() {
		PageObjectLogging.log("VerifyVideoPlayerAppeared", "Verify that suggest a video modal appeared", true, driver);
		waitForElementByElement(suggestVideoModal);
		
	}

	/**
	 * Verify that suggest a video modal appeared
	 * 
	 * @author Michal Nowierski
	 */
	public void VerifySuggestAVideoModalTopic(String topic) {
		PageObjectLogging.log("VerifySuggestAVideoModalTopic", "Verify that suggest a video modal has topic: "+topic, true, driver);
		waitForElementByElement(suggestVideoModalTopic);
		waitForTextToBePresentInElementByElement(suggestVideoModalTopic, topic);
		
	}
	
	/**
	 * Click on [x] to close suggest a video modal
	 * 
	 * @author Michal Nowierski
	 */
	public void Click_X_toCloseSuggestAVideo() {
		PageObjectLogging.log("Click_X_toCloseSuggestAVideo", "Click on [x] to close suggest a video modal", true, driver);
		closeModalWrapper();		
	}
	
	/**
	 * Click on Cancel to close suggest a video modal
	 * 
	 * @author Michal Nowierski
	 */
	public void Click_Cancel_toCloseSuggestAVideo() {
		PageObjectLogging.log("Click_X_toCloseSuggestAVideo", "Click on Cancel to close suggest a video modal", true, driver);
		waitForElementByElement(modalWrapper_Cancel_CloseButton);
		waitForElementClickableByElement(modalWrapper_Cancel_CloseButton);	
		modalWrapper_Cancel_CloseButton.click();		
	}
	
	/**
	 * Close modal wrapper. Modal wrapper can be e.g 'video player' or 'suggest a video modal'.
	 * 
	 * @author Michal Nowierski
	 */	
	private void closeModalWrapper() {
		waitForElementByElement(modalWrapper_X_CloseButton);
		waitForElementClickableByElement(modalWrapper_X_CloseButton);	
		modalWrapper_X_CloseButton.click();
	}

	/**
	 * Verify that Suggest Video button is disabled
	 * 
	 * @author Michal Nowierski
	 */	
	public void VerifySuggestVideoButtonNotClickable() {
		PageObjectLogging.log("VerifySuggestVideoButtonNotClickable", "Verify that Suggest Video button is disabled", true, driver);
		waitForElementByElement(submitButton);
		waitForElementNotClickableByElement(submitButton);
		
	}
	
	/**
	 * Verify that Suggest Video button is enabled
	 * 
	 * @author Michal Nowierski
	 */	
	public void VerifySuggestVideoButtonClickable() {
		PageObjectLogging.log("VerifySuggestVideoButtonNotClickable", "Verify that Suggest Video button is enabled", true, driver);
		waitForElementByElement(submitButton);
		waitForElementClickableByElement(submitButton);
		
	}

	/**
	 * Type text into 'What Video' field on 'Suggest Video Modal'
	 * 
	 * @author Michal Nowierski
	 */	
	public void SuggestVideoTypeIntoWhatVideoField(String text) {
		PageObjectLogging.log("SuggestVideoTypeIntoWhatVideoField", "Type '"+text+"' into 'What Video' field on 'Suggest Video Modal'", true, driver);
		waitForElementByElement(suggestVideoWhatVideoInput);
		suggestVideoWhatVideoInput.sendKeys(text);
		
	}
	
	/**
	 * Type text into 'Which Wiki' field on 'Suggest Video Modal'
	 * 
	 * @author Michal Nowierski
	 */	
	public void SuggestVideoTypeIntoWhichWikiField(String text) {
		PageObjectLogging.log("SuggestVideoTypeIntoWhatVideoField", "Type '"+text+"' into 'Which Wiki' field on 'Suggest Video Modal'", true, driver);
		waitForElementByElement(suggestVideoWhichWikiInput);
		suggestVideoWhichWikiInput.sendKeys(text);
		
	}
}
































