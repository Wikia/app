package com.wikia.selenium.tests;

import java.io.File;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertEquals;
import static org.testng.AssertJUnit.assertTrue;
import static org.testng.AssertJUnit.assertFalse;

import org.testng.annotations.Parameters;
import org.testng.annotations.Test;

public class CategoryExhibitionTest extends BaseTest {

	@Test(groups={"CI"})
	public void testSortTypeAndDisplay() throws Exception {

		// open video page in classic preview
		session().open("/wiki/Category:Videos?display=page&sort=mostvisited");
		session().waitForPageToLoad(TIMEOUT);

		if ( session().isElementPresent("//div[@class='category-gallery-form']") ){

			// open video page ( mostvisited )
			session().open("/wiki/Category:Videos?display=exhibition&sort=mostvisited");
			session().waitForPageToLoad(TIMEOUT);

			Number numberOfMostvisitedPages = session().getXpathCount("//div[@id='mw-images']//div[@class='wikia-paginator']//a");
//			System.out.println("Counted pages for mostvisited video : " + numberOfMostvisitedPages);

			// open video page ( alphabetical )
			session().open("/wiki/Category:Videos?display=exhibition&sort=alphabetical");
			session().waitForPageToLoad(TIMEOUT);

			Number numberOfAlphabeticalPages = session().getXpathCount("//div[@id='mw-images']//div[@class='wikia-paginator']//a");
//			System.out.println("Counted pages for alphabetical video : " + numberOfAlphabeticalPages);

			// open video page ( recent edits )
			session().open("/wiki/Category:Videos?display=exhibition&sort=recentedits");
			session().waitForPageToLoad(TIMEOUT);

			Number numberOfRecentEditsPages = session().getXpathCount("//div[@id='mw-images']//div[@class='wikia-paginator']//a");
//			System.out.println("Counted pages for recetly edited video : " + numberOfRecentEditsPages);

			if ( numberOfMostvisitedPages.equals( 0 )){
//				System.out.println("Category is empty - false positive warning");
				assertTrue( true );
			}

			assertTrue( numberOfAlphabeticalPages.equals( numberOfRecentEditsPages ) );
			assertTrue( numberOfAlphabeticalPages.equals( numberOfMostvisitedPages ) );

			assertTrue( numberOfAlphabeticalPages.equals( numberOfMostvisitedPages ) );
//			System.out.println("Pages number OK.");
		} else {
//			System.out.println("Extension is not enabled on this wiki or Cat page");
			assertTrue( false );
		}
	}

	@Test(groups={"CI"})
	public void testImages() throws Exception {

		// open video page ( most visited edits )
		session().open("/wiki/Category:Images?display=exhibition&sort=recentedits");
		session().waitForPageToLoad(TIMEOUT);

		// System.out.println("Checking Images lightbox.");
		session().click( "//div[@id='mw-images']//a[@class='lightbox']" );
		waitForElement( "//section[@id='lightbox']" );
		assertTrue( session().isElementPresent( "//section[@id='lightbox']" ) );
	}

	@Test(groups={"CI"})
	public void testVideos() throws Exception {

		// open video page ( most visited edits )

		session().open("/wiki/Category:Videos?display=exhibition&sort=recentedits");
		session().waitForPageToLoad(TIMEOUT);

		// System.out.println("Checking video player.");
		session().click("//div[@id='mw-images']//div[@class='category-gallery-item-play']");
		waitForElement("//section[@id='activityfeed-video-player']");
		assertTrue( session().isElementPresent("//section[@id='activityfeed-video-player']") );
	}
}
