package com.wikia.webdriver.TestCases.AdTests;

import org.testng.annotations.Test;

import com.wikia.webdriver.Common.Core.CommonFunctions;
import com.wikia.webdriver.Common.Properties.Properties;
import com.wikia.webdriver.Common.Templates.TestTemplate;
import com.wikia.webdriver.PageObjects.PageObject.SearchPageObject;

public class AdsInSearchTests extends TestTemplate
{
	/*
	 * A search phrase to always get some wiki results and as many ads as possible
	 */
	private String popularSearchPhrase = "wiki OR hotel OR home OR page OR fun";
	private int popularSearchPhraseExpectedTopAdsCount = 3;
	private int popularSearchPhraseExpectedBottomAdsCount = 3;

	/*
	 * A search phrase that we expect to get zero ad results for
	 */
	private String veryUncommonSearchPhrase = "aaarghhhhhhhh123";

	@Test(groups = {"Ads"})
	public void AdsInSearch_TC_001_both_ad_boxes_on_popular_phrase()
	{
		SearchPageObject searchPage = new SearchPageObject(driver);
		searchPage.openSearchPage();
		searchPage.searchForPhrase(popularSearchPhrase);

		searchPage.verifyTopSponsoredAdBox();
		searchPage.verifyBottomSponsoredAdBox();
	}

	/*
	 * Checking  if ad boxes are displayed when searching for a popular phrase
	 */
	@Test(groups = {"Ads"})
	public void AdsInSearch_TC_002_max_count_of_ads_on_popular_phrase()
	{
		SearchPageObject searchPage = new SearchPageObject(driver);
		searchPage.openSearchPage();
		searchPage.searchForPhrase(popularSearchPhrase);

		searchPage.verifyNumberOfAdsInTopUnit(popularSearchPhraseExpectedTopAdsCount);
		searchPage.verifyNumberOfAdsInBottomUnit(popularSearchPhraseExpectedBottomAdsCount);
	}

	@Test(groups = {"Ads"})
	public void AdsInSearch_TC_003_no_results_for_uncommon_phrase()
	{
		SearchPageObject searchPage = new SearchPageObject(driver);
		searchPage.openSearchPage();
		searchPage.searchForPhrase(veryUncommonSearchPhrase);

		searchPage.verifyNumberOfAdsInTopUnit(0);
	}
}
