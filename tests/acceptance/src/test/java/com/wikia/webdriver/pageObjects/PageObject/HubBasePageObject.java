package com.wikia.webdriver.pageObjects.PageObject;

import java.util.List;

import javax.swing.text.html.CSS;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.PageFactory;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.support.ui.WebDriverWait;


import com.wikia.webdriver.Logging.PageObjectLogging;
import com.wikia.webdriver.pageObjects.PageObject.Hubs.VideoGamesHubPageObject;

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
	
	
	public HubBasePageObject(WebDriver driver) {
		super(driver);
		PageFactory.initElements(driver, this);
	}

	public void ClickOnNewsTab(int TabNumber) {
		List<WebElement> newstabs = driver.findElements(By.cssSelector("section.wikiahubs-newstabs ul.tabbernav li a"));
		waitForElementClickableByCss("section.wikiahubs-newstabs ul.tabbernav li a");
		PageObjectLogging.log("Click on news tab numer "+TabNumber+".", "", true, driver);
		newstabs.get(TabNumber - 1).click();

	}
	public void RelatedVideosScrollLeft() {
		PageObjectLogging.log("RV module: scroll left", "", true, driver);
		RelatedVideosScrollLeft.click();
		}
	
	public void RelatedVideosScrollRight() {
		PageObjectLogging.log("RV module: scroll right", "", true, driver);
		RelatedVideosScrollRight.click();
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
	
	public void verifyWikiaMosaicSliderHasImages() {
		PageObjectLogging.log("Veridy that WikiaMosaicSlider has images ", "", true, driver);
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

}
