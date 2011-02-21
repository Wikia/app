package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;
import static org.testng.AssertJUnit.assertEquals;

import org.testng.annotations.Test;

public class LatestPhotosTest extends BaseTest {
	@Test(groups={"oasis","CI"})
	public void testLatestPhotos() throws Exception {
		loginAsStaff();
		
		session().open("index.php?title=File:LatestPhotos1.gif");
		session().waitForPageToLoad(this.getTimeout());
		doDeleteIfAllowed("Other reason", "SeleniumTest");
		uploadImage( "http://www.google.com/logos/pl_independence08.gif", "LatestPhotos1.gif");
		
		session().open("index.php?title=File:LatestPhotos2.gif");
		session().waitForPageToLoad(this.getTimeout());
		doDeleteIfAllowed("Other reason", "SeleniumTest");
		uploadImage( "http://www.google.com/logos/polishind09.gif", "LatestPhotos2.gif");
		
		session().open("index.php?title=File:LatestPhotos3.gif");
		session().waitForPageToLoad(this.getTimeout());
		doDeleteIfAllowed("Other reason", "SeleniumTest");
		uploadImage( "http://www.google.com/logos/2010/firstdayofschool10-hp.gif", "LatestPhotos3.gif");
		
		session().open("index.php?title=File:LatestPhotos4.gif");
		session().waitForPageToLoad(this.getTimeout());
		doDeleteIfAllowed("Other reason", "SeleniumTest");
		uploadImage( "http://www.google.com/logos/childrens_day08_2.gif", "LatestPhotos4.gif");
		
		session().open("index.php?title=File:LatestPhotos5.gif");
		session().waitForPageToLoad(this.getTimeout());
		doDeleteIfAllowed("Other reason", "SeleniumTest");
		uploadImage( "http://www.google.com/logos/grandparents09.gif", "LatestPhotos5.gif");
		
		session().open("index.php?title=Special:Random");
		session().waitForPageToLoad(this.getTimeout());

		// Latest Photos Module
		assertTrue(session().isElementPresent("//section[contains(@class,'LatestPhotosModule')]"));
		assertTrue(session().isElementPresent("link=Add a Photo"));

		// Interatction Part
		// add a photo button
		session().click("link=Add a Photo");
		waitForElement("//section[@id='UploadPhotosWrapper']");
		session().click("//section[@id='UploadPhotosWrapper']//button[contains(@class, 'close')]");

		session().open("index.php?title=Special:Random");
		session().waitForPageToLoad(this.getTimeout());

		// browse through gallery
		String firstPhotoSrc = session().getAttribute("//section[contains(@class,'LatestPhotosModule')]//ul[@class='carousel']/li/a@href");
		session().click("//div[@id='WikiaRail']/section[contains(@class,'LatestPhotosModule')]/a[@class='next']/img");
		String secondPhotoSrc = session().getAttribute("//section[contains(@class,'LatestPhotosModule')]//ul[@class='carousel']/li/a@href");
		
		assertTrue ( firstPhotoSrc != secondPhotoSrc );

		//view all photos
		session().click("//section[contains(@class,'LatestPhotosModule')]/a[@class='more']");
		session().waitForPageToLoad(this.getTimeout());
		assertEquals(session().getText("//header[@id='WikiaPageHeader']/h1"), "New photos on this wiki");

		session().open("index.php?title=Special:Random");
	 	session().waitForPageToLoad(this.getTimeout());

		// open a photo in the lightbox
		session().click("//section[contains(@class,'LatestPhotosModule')]//ul[@class='carousel']/li/a");
		waitForElement("//section[@id='lightbox']");
	}
}
