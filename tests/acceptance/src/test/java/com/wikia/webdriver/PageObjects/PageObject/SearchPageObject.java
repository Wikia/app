package com.wikia.webdriver.PageObjects.PageObject;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.PageFactory;
import org.openqa.selenium.support.ui.ExpectedConditions;

import com.wikia.webdriver.Common.Core.Global;
import com.wikia.webdriver.Common.Core.CommonFunctions;
import com.wikia.webdriver.Common.Logging.PageObjectLogging;

public class SearchPageObject extends BasePageObject
{
	private String searchUri = "wiki/Special:Search";
	private String adLoadingClass = "loading";

	// Search form:
	@FindBy(css="form.WikiaSearch input[name='search']")
	private WebElement searchInput;

	@FindBy(css="form.WikiaSearch *[type='submit']")
	private WebElement searchButton;

	// Search ads boxes:
	@FindBy(css="div.SearchAdsTop ul.list")
	private WebElement searchAdsTopBox;

	@FindBy(css="div.SearchAdsBottom ul.list")
	private WebElement searchAdsBottomBox;

	// Empty search ads locators:
	private By searchAdsTopBoxEmptyLocator = By.cssSelector("div.SearchAdsTop ul.list:empty");
	private By searchAdsBottomBoxEmptyLocator = By.cssSelector("div.SearchAdsBottom ul.list:empty");

	// Search ad units locators:
	private By adsInTopUnit = By.cssSelector("div.SearchAdsTop ul.list li.unit");
	private By adsInBottomUnit = By.cssSelector("div.SearchAdsBottom ul.list li.unit");

	public SearchPageObject(WebDriver driver)
	{
		super(driver);
		PageFactory.initElements(driver, this);
	}

	public void openSearchPage()
	{
		driver.get(Global.DOMAIN + searchUri);
		driver.getCurrentUrl();
	}

	public void searchForPhrase(String phrase)
	{
		searchInput.sendKeys(phrase);
		PageObjectLogging.log("searchForPhrase", "Typed \"" + phrase + "\"", true, driver);
		searchButton.click();
	}

	public void verifyTopSponsoredAdBox()
	{
		waitForElementByElement(searchAdsTopBox);
		PageObjectLogging.log("verifyTopSponsoredAdBox", "Top sponsored ad box present", true, driver);
	}

	public void verifyBottomSponsoredAdBox()
	{
		waitForElementByElement(searchAdsBottomBox);
		PageObjectLogging.log("verifyBottomSponsoredAdBox", "Bottom sponsored ad box present", true, driver);
	}

	public void verifyNumberOfAdsInTopUnit(int expectedNumberOfAds)
	{
		waitForClassRemovedFromElement(searchAdsTopBox, adLoadingClass);
		if (expectedNumberOfAds == 0) {
			waitForElementPresenceByBy(searchAdsTopBoxEmptyLocator);
			PageObjectLogging.log("verifyNumberOfAdsInTopUnit", "Verified number of ads in top unit is 0", true, driver);
		} else {
			int actualNumberOfAds = driver.findElements(adsInTopUnit).size();
			CommonFunctions.assertNumber(expectedNumberOfAds, actualNumberOfAds, "Checking number of ads in top unit");
		}
	}

	public void verifyNumberOfAdsInBottomUnit(int expectedNumberOfAds)
	{
		waitForClassRemovedFromElement(searchAdsBottomBox, adLoadingClass);
		if (expectedNumberOfAds == 0) {
			waitForElementPresenceByBy(searchAdsBottomBoxEmptyLocator);
			PageObjectLogging.log("verifyNumberOfAdsInBottomUnit", "Verified number of ads in bottom unit is 0", true, driver);
		} else {
			int actualNumberOfAds = driver.findElements(adsInBottomUnit).size();
			CommonFunctions.assertNumber(expectedNumberOfAds, actualNumberOfAds, "Checking number of ads in bottom unit");
		}
	}
}
