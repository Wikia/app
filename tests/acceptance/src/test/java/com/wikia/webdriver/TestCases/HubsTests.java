package com.wikia.webdriver.TestCases;

import org.testng.annotations.DataProvider;
import org.testng.annotations.Test;

import com.wikia.webdriver.Common.Core.CommonFunctions;
import com.wikia.webdriver.Common.Core.Global;
import com.wikia.webdriver.Common.Templates.TestTemplate;
import com.wikia.webdriver.PageObjects.PageObject.HomePageObject;
import com.wikia.webdriver.PageObjects.PageObject.HubBasePageObject;
import com.wikia.webdriver.PageObjects.PageObject.Hubs.EntertainmentHubPageObject;
import com.wikia.webdriver.PageObjects.PageObject.Hubs.LifestyleHubPageObject;
import com.wikia.webdriver.PageObjects.PageObject.Hubs.VideoGamesHubPageObject;

public class HubsTests extends TestTemplate{

	
	

	private static final VideoGamesHubPageObject VGHub = null;
	private static final LifestyleHubPageObject LHub = null;
	private static final EntertainmentHubPageObject EHub = null;
	private static HomePageObject home  = null;

	@DataProvider
	private static final Object[][] provideHub(){
		return new Object[][] {
//				{VGHub, "VideoGamesHub", Global.LIVE_DOMAIN+"Video_Games"},
//				{EHub, "EntertainmentHub", Global.LIVE_DOMAIN+"Entertainment"},
				{LHub, "LifestyleHub", Global.LIVE_DOMAIN+"Lifestyle"}
		};
	}
	
	@Test(dataProvider = "provideHub")
//	https://internal.wikia-inc.com/wiki/Hubs/QA/Hubs_Test_Cases#Module_1_.28Mosaic_Slider.29_Test_Cases
	public void VideoGamesHubTest001(HubBasePageObject Hub, String HubName, String HubURL)
	{
		CommonFunctions.MoveCursorTo(0, 0);		
		home = new HomePageObject(driver);
		home.openHomePage();				
		Hub = home.OpenHub(HubName);
		Hub.verifyURL(HubURL);
		
		Hub.MosaicSliderVerifyHasImages();
		Hub.MosaicSliderHoverOverImage(5);
		String CurrentLargeImageDescription = Hub.MosaicSliderGetCurrentLargeImageDescription();
		Hub.MosaicSliderHoverOverImage(4);
		CurrentLargeImageDescription = Hub.MosaicSliderVerifyLargeImageChangeAndGetCurrentDescription(CurrentLargeImageDescription);
		Hub.MosaicSliderHoverOverImage(3);
		CurrentLargeImageDescription = Hub.MosaicSliderVerifyLargeImageChangeAndGetCurrentDescription(CurrentLargeImageDescription);
		Hub.MosaicSliderHoverOverImage(2);
		CurrentLargeImageDescription = Hub.MosaicSliderVerifyLargeImageChangeAndGetCurrentDescription(CurrentLargeImageDescription);
		Hub.MosaicSliderHoverOverImage(1);
		CurrentLargeImageDescription = Hub.MosaicSliderVerifyLargeImageChangeAndGetCurrentDescription(CurrentLargeImageDescription);
		CommonFunctions.MoveCursorTo(0, 0);		
		
			
		home = Hub.BackToHomePage();		
		
		
	}
	
//	@Test(dataProvider = "provideHub")
	public void VideoGamesHubTest002(HubBasePageObject Hub, String HubName, String HubURL)
	{
		
		
		home = new HomePageObject(driver);
		home.openHomePage();
		
		Hub = home.OpenHub(HubName);
		Hub.verifyURL(HubURL);
		
		Hub.ClickOnNewsTab(2);
		Hub.ClickOnNewsTab(3);
		Hub.ClickOnNewsTab(1);
		Hub.RelatedVideosScrollRight();
		Hub.RelatedVideosScrollLeft();
		
		
		home = Hub.BackToHomePage();
		
		
		
	}
	
}
