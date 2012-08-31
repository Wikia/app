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
import com.wikia.webdriver.Common.Core.Global;
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
	@FindBy(css="button[id='suggestArticle']") 
	private WebElement suggestArticleButton;
	@FindBy(css="section.modalWrapper") 
	private WebElement suggestVideoOrArticleModal;
	@FindBy(css="section.modalWrapper h1") 
	private WebElement suggestVideoOrArticleModalTopic;
	@FindBy(css="div.videourl input") 
	private WebElement suggestVideoWhatInput;
	@FindBy(css="div.articleurl input") 
	private WebElement suggestArticleWhatInput;
	@FindBy(css="div.wikiname input") 
	private WebElement suggestVideoWhichWikiInput;
	@FindBy(css="div.required textarea") 
	private WebElement suggestArticleWhyCooliInput;
	@FindBy(css="button.submit") 
	private WebElement submitButton;
	@FindBy(css="section.wikiahubs-pulse") 
	private WebElement pulseModule;
	@FindBy(css="a[id='facebook']") 
	private WebElement FacebookButton;
	@FindBy(css="a[id='twitter']") 
	private WebElement TwitterButton;
	@FindBy(css="a[id='google']") 
	private WebElement GoogleButton;
	@FindBy(css="div.top-wikis-content") 
	private WebElement topWikisModule;
		
	By MosaicSliderLargeImageDescription = By.cssSelector("div.wikia-mosaic-slider-description span.description-more");
	By NewsTabsList = By.cssSelector("div.tabbertab");
	By RelatedVideosList = By.cssSelector("div.wikiahubs-popular-videos div.container div.item");
	By FromCommunityImagesList = By.cssSelector("ul.wikiahubs-ftc-list div img");
	By FromCommunityHeadlinesList = By.cssSelector("ul.wikiahubs-ftc-list div.wikiahubs-ftc-title a");
	By FromCommunityWikinameAndUsernameFieldsList = By.cssSelector("ul.wikiahubs-ftc-list div.wikiahubs-ftc-subtitle a");
	By FromCommunityQuatationsList = By.cssSelector("ul.wikiahubs-ftc-list div.wikiahubs-ftc-creative");
	By PulseStatisticsList = By.cssSelector("div.boxes div");
	By topWikissList = By.cssSelector("div.boxes div");
	
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
		PageObjectLogging.log("SearchButtonClick", "Left click on the WikiaSearch button", true, driver);
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
		PageObjectLogging.log("SearchResultsVerifyFoundURL", "Verify if " + URL
				+ " URL is one of found the results", true, driver);
		
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
		PageObjectLogging.log("MosaicSliderHoverOverImage", "MosaicSlider: Hover over image number "+n, true, driver);
		if (n>5) {
			PageObjectLogging.log("MosaicSliderHoverOverImage", "MosaicSlider: The n parameter must be less than 5. It can not be: n = "+n, false, driver);
			return;
		}
		waitForElementByBy(By.cssSelector("ul.wikia-mosaic-thumb-region img"));
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
		PageObjectLogging.log("MosaicSliderGetCurrentLargeImageDescription", "Get description of current LargeImage on Mosaic Slider", true, driver);
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
		List<WebElement> List = driver.findElements(RelatedVideosList);
		int size = List.size();
		WebElement Video1 = List.get(3*n-3);
		waitForElementByElement(Video1);	
		//the below 'if' statements prevents situations when driver wants to verify presence of 3 videos in RV module, when there are only 2 videos (or 1 video) in the module. (The situation when there are only 2 or 1 videos is correct)	
		if (size%3==0 | size%3==2) {	
			WebElement Video2 = List.get(3*n-2);
			waitForElementByElement(Video2);
		}
		if (size%3==0) {	
			WebElement Video3 = List.get(3*n-1);
			waitForElementByElement(Video3);				
		}
	}

	public void ClickOnRelatedVideo(int i) {
		int n = RVmoduleCurrentVideosSet;
		PageObjectLogging.log("ClickOnRelatedVideo", "Click on related video number "+i+"' is present as well", true, driver);
		waitForElementByBy(RelatedVideosList);
		List<WebElement> NewsTabs = driver.findElements(RelatedVideosList);	
		WebElement Video = NewsTabs.get(3*n-4+i).findElement(By.cssSelector("div.playButton"));
		waitForElementByElement(Video);
		CommonFunctions.scrollToElement(Video);
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
		PageObjectLogging.log("ClickSuggestAVideo", "Click on a suggest video button", true, driver);
		waitForElementByElement(suggestVideoButton);
		CommonFunctions.scrollToElement(suggestVideoButton);
		waitForElementClickableByElement(suggestVideoButton);	
		suggestVideoButton.click();
		
	}
	
	/**
	 * Click on suggest an article button
	 * 
	 * @author Michal Nowierski
	 */
	public void ClickSuggestAnArticle() {
		PageObjectLogging.log("ClickSuggestAnArticle", "Click on suggest an article button", true, driver);
		waitForElementByElement(suggestArticleButton);
		CommonFunctions.scrollToElement(suggestArticleButton);
		waitForElementClickableByElement(suggestArticleButton);	
		suggestArticleButton.click();
		
	}

	/**
	 * Verify that suggest a video or article modal appeared
	 * 
	 * @author Michal Nowierski
	 */
	public void VerifySuggestAVideoOrArticleModalAppeared() {
		PageObjectLogging.log("VerifySuggestAVideoOrArticleModalAppeared", "Verify that suggest a video modal appeared", true, driver);
		waitForElementByElement(suggestVideoOrArticleModal);
		
	}

	/**
	 * Verify that suggest a video or an article modal has topic: 
	 * 
	 * @author Michal Nowierski
	 */
	public void VerifySuggestAVideoOrArticleModalTopic(String topic) {
		PageObjectLogging.log("VerifySuggestAVideoOrArticleModalTopic", "Verify that suggest a video or an article modal has topic: "+topic, true, driver);
		waitForElementByElement(suggestVideoOrArticleModalTopic);
		waitForTextToBePresentInElementByElement(suggestVideoOrArticleModalTopic, topic);
		
	}
	
	/**
	 * Click on [x] to close suggest a video or article modal
	 * 
	 * @author Michal Nowierski
	 */
	public void Click_X_toCloseSuggestAVideoOrArticle() {
		PageObjectLogging.log("Click_X_toCloseSuggestAVideoOrArticle", "Click on [x] to close suggest a video or article modal", true, driver);
		closeModalWrapper();		
	}
	
	/**
	 * Click on Cancel to close suggest a video or article modal
	 * 
	 * @author Michal Nowierski
	 */
	public void Click_Cancel_toCloseSuggestAVideoOrArticle() {
		PageObjectLogging.log("Click_Cancel_toCloseSuggestAVideoOrArticle", "Click on Cancel to close suggest a video or article modal", true, driver);
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
	 * Verify that Suggest Video or Article submit button is disabled
	 * 
	 * @author Michal Nowierski
	 */	
	public void VerifySuggestVideoOrArticleButtonNotClickable() {
		PageObjectLogging.log("VerifySuggestVideoOrArticleButtonNotClickable", "Verify that 'Suggest Video' or 'Article' submit button button is disabled", true, driver);
		waitForElementByElement(submitButton);
		waitForElementNotClickableByElement(submitButton);
		
	}
	
	/**
	 * Verify that Suggest Video or Article submit button is enabled
	 * 
	 * @author Michal Nowierski
	 */	
	public void VerifySuggestVideoOrArticleButtonClickable() {
		PageObjectLogging.log("VerifySuggestVideoOrArticleButtonClickable", "Verify that Suggest Video or Article submit button is enabled", true, driver);
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
		waitForElementByElement(suggestVideoWhatInput);
		suggestVideoWhatInput.sendKeys(text);
		
	}
	
	/**
	 * Type text into 'What Video' field on 'Suggest Video Modal'
	 * 
	 * @author Michal Nowierski
	 */	
	public void SuggestArticleTypeIntoWhatVideoField(String text) {
		PageObjectLogging.log("SuggestArticleTypeIntoWhatVideoField", "Type '"+text+"' into 'What Video' field on 'Suggest Article Modal'", true, driver);
		waitForElementByElement(suggestArticleWhatInput);
		suggestArticleWhatInput.sendKeys(text);
		
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
	
	/**
	 * Type text into 'Why cool' field on 'Suggest Video Modal'
	 * 
	 * @author Michal Nowierski
	 */	
	public void SuggestArticleTypeIntoWhyCoolField(String text) {
		PageObjectLogging.log("SuggestArticleTypeIntoWhyCoolField", "Type '"+text+"' into 'Why cool' field on 'Suggest Video Modal'", true, driver);
		waitForElementByElement(suggestArticleWhyCooliInput);
		suggestArticleWhyCooliInput.sendKeys(text);
		
	}

	/**
	 * Verify that from the community module has images
	 * 
	 * @author Michal Nowierski
	 */	
	public void verifyFromModuleHasImages() {
		PageObjectLogging.log("verifyFromModuleHasImages", "Verify that from the community module has images", true, driver);
		List<WebElement> List = driver.findElements(FromCommunityImagesList);
		for (int i = 0; i < List.size(); i++) {
			PageObjectLogging.log("verifyFromModuleHasImages", "Checking image number "+(i+1), true, driver);
			CommonFunctions.scrollToElement(List.get(i));
			waitForElementByElement(List.get(i));		
		}
		
	}
	/**
	 * Verify that from the communitz module has headline
	 * 
	 * @author Michal Nowierski
	 */	
	public void verifyFromModuleHasHeadline() {
		PageObjectLogging.log("verifyFromModuleHasHeadline", "Verify that from the community module has headline", true, driver);
		List<WebElement> List = driver.findElements(FromCommunityHeadlinesList);
		for (int i = 0; i < List.size(); i++) {
			PageObjectLogging.log("verifyFromModuleHasHeadline", "Checking headline number "+(i+1), true, driver);
			CommonFunctions.scrollToElement(List.get(i));
			waitForElementByElement(List.get(i));		
		}
		
	}
	/**
	 * Verify that from the community module has username field
	 * 
	 * @author Michal Nowierski
	 */	
	public void verifyFromModuleHasUserAndWikiField() {
		PageObjectLogging.log("verifyFromModuleHasUserAndWikiField", "Verify that from the community module has username field", true, driver);
		List<WebElement> List = driver.findElements(FromCommunityWikinameAndUsernameFieldsList);
		for (int i = 0; i < List.size(); i++) {
			PageObjectLogging.log("verifyFromModuleHasUserAndWikiField", "Checking field number "+(i+1), true, driver);
			CommonFunctions.scrollToElement(List.get(i));
			waitForElementByElement(List.get(i));		
		}
	}

	/**
	 * Verify that from the communitz module has a quatation
	 * 
	 * @author Michal Nowierski
	 */	
	public void verifyFromModuleHasQuatation() {
		PageObjectLogging.log("verifyFromModuleHasQuatation", "Verify that from the community module has a quatation", true, driver);
		List<WebElement> List = driver.findElements(FromCommunityQuatationsList);
		for (int i = 0; i < List.size(); i++) {
			PageObjectLogging.log("verifyFromModuleHasQuatation", "Checking quotation number "+(i+1), true, driver);
			CommonFunctions.scrollToElement(List.get(i));
			waitForElementByElement(List.get(i));		
		}
		
	}

	/**
	 * Verify that Pulse module appears
	 * 
	 * @author Michal Nowierski
	 */	
	public void verifyPulseModuleAppears() {
		PageObjectLogging.log("verifyPulseModuleAppears", "Verify that Pulse module appears", true, driver);
		waitForElementByElement(pulseModule);		
	}
	
	/**
	 * Verify that top wikis module appears
	 * 
	 * @author Michal Nowierski
	 */	
	public void verifyTopWikisModuleAppears() {
		PageObjectLogging.log("verifyTopWikisModuleAppears", "Verify that top wikis module appears", true, driver);
		waitForElementByElement(topWikisModule);		
	}
	
	
	/**
	 * Verify that facebook button is displayed
	 * 
	 * @author Michal Nowierski
	 */	
	public void verifyFacebookButtonAppears() {
		PageObjectLogging.log("verifyFacebookButtonAppears", "Verify that facebook button is displayed", true, driver);
		waitForElementByElement(FacebookButton);		
	}
	
	/**
	 * Verify that twitter button is displayed
	 * 
	 * @author Michal Nowierski
	 */	
	public void verifyTwitterButtonAppears() {
		PageObjectLogging.log("verifyTwitterButtonAppears", "Verify that twitter button is displayed", true, driver);
		waitForElementByElement(TwitterButton);		
	}
	
	/**
	 * Verify that google button is displayed
	 * 
	 * @author Michal Nowierski
	 */	
	public void verifyGoogleButtonAppears() {
		PageObjectLogging.log("verifyGoogleButtonAppears", "Verify that google button is displayed", true, driver);
		waitForElementByElement(GoogleButton);		
	}
	
	/**
	 * verify that facebook button is clickable
	 * 
	 * @author Michal Nowierski
	 */	
	public void verifyFacebookButtonIsClickable() {
		PageObjectLogging.log("verifyFacebookButtonIsClickable", "verify that facebook button is clickable", true, driver);
		waitForElementClickableByElement(FacebookButton);		
	}
	
	/**
	 * verify that twitter button is clickable
	 * 
	 * @author Michal Nowierski
	 */	
	public void verifyTwitterButtonIsClickable() {
		PageObjectLogging.log("verifyTwitterButtonIsClickable", "verify that twitter button is clickable", true, driver);
		waitForElementClickableByElement(TwitterButton);		
	}
	
	/**
	 * verify that google button is clickable
	 * 
	 * @author Michal Nowierski
	 */	
	public void verifyGoogleButtonIsClickable() {
		PageObjectLogging.log("verifyGoogleButtonIsClickable", "verify that google button is clickable", true, driver);
		waitForElementClickableByElement(GoogleButton);		
	}
	
	
	/**
	 * verify that statistics are displayed
	 * 
	 * @author Michal Nowierski
	 */	
	public void verifyStatisticsAreDisplayed() {
		PageObjectLogging.log("verifyStatisticsAreDisplayed", "verify that statistics are displayed", true, driver);
		List<WebElement> List = driver.findElements(PulseStatisticsList);
		for (int i = 0; i < List.size(); i++) {
			PageObjectLogging.log("verifyStatisticsAreDisplayed", "Checking statistics box number "+(i+1), true, driver);
			CommonFunctions.scrollToElement(List.get(i));
			waitForElementByElement(List.get(i));		
		}
	}
	
	/**
	 * verify that wikis are listed in 'Top Wikis' module
	 * 
	 * @author Michal Nowierski
	 */	
	public void verifyWikisAreListedInTopWikisModule() {
		PageObjectLogging.log("verifyWikisAreListedInTopWikisModule", "verify that wikis are listed in 'Top Wikis' module", true, driver);
		List<WebElement> List = driver.findElements(topWikissList);
		for (int i = 0; i < List.size(); i++) {
			PageObjectLogging.log("verifyWikisAreListedInTopWikisModule", "Checking  top wiki number "+(i+1), true, driver);
			CommonFunctions.scrollToElement(List.get(i));
			waitForElementByElement(List.get(i));		
		}
	}
	

	
	/**
	 * 
	 * 
	 * @author Michal Nowierski
	 */	
	public void templateMethod() {
		PageObjectLogging.log("", "", true, driver);
	
	}
}
































