package com.wikia.selenium.tests;

import java.io.File;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertEquals;
import static org.testng.AssertJUnit.assertTrue;
import static org.testng.AssertJUnit.assertFalse;

import org.testng.annotations.Parameters;
import org.testng.annotations.Test;

public class CategoryExhibitionTest extends BaseTest {

	@Test(groups={"CI", "legacy", "fileUpload"})
	public void testSortTypeAndDisplay() throws Exception {

		// prepare

		loginAsStaff();
		for (int i = 1; i <= 41; i++) {
			editArticle( "categoryExhibitionTest" + i, "[[category:CategoryExhibitionTest]]" + i );
		}

		for (int i = 1; i <= 21; i++) {
			editArticle( "category:categoryExhibitionTest" + i, "[[category:CategoryExhibitionTest]]" + i );
		}

		session().open("index.php?title=File:CategoryExhibition1.jpg");
		session().waitForPageToLoad(this.getTimeout());
		doDeleteIfAllowed("Other reason", "SeleniumTest");
		uploadImage( "http://www.google.com/logos/2011/sayeddarwish11-hp.jpg", "CategoryExhibition1.jpg");
		editArticle( "File:CategoryExhibition1.jpg" , "[[category:CategoryExhibitionTest]]" );

		session().open("index.php?title=File:CategoryExhibition2.jpg");
		session().waitForPageToLoad(this.getTimeout());
		doDeleteIfAllowed("Other reason", "SeleniumTest");
		uploadImage( "http://www.google.com/logos/2011/st_patricks11-hp.jpg", "CategoryExhibition2.jpg");
		editArticle( "File:CategoryExhibition2.jpg" , "[[category:CategoryExhibitionTest]]" );

		session().open("index.php?title=File:CategoryExhibition3.jpg");
		session().waitForPageToLoad(this.getTimeout());
		doDeleteIfAllowed("Other reason", "SeleniumTest");
		uploadImage( "http://www.google.com/logos/2011/italybday11-HP.jpg", "CategoryExhibition3.jpg");
		editArticle( "File:CategoryExhibition3.jpg" , "[[category:CategoryExhibitionTest]]" );

		session().open("index.php?title=Video:CategoryExhibitionVideo1");
		session().waitForPageToLoad(this.getTimeout());
		
		// load video if no video page
		if ( !session().isElementPresent( "//div[@id='file']" ) ){
			session().open("index.php?title=categoryExhibitionTest1&action=edit&useeditor=wyswig");
			session().waitForPageToLoad(this.getTimeout());

			// clear wikitext
			session().runScript("window.RTE.instance.setData('');");
			session().waitForCondition("window.RTE.instance.mode == 'wysiwyg'", this.getTimeout());

			// load modal
			session().runScript("CKEDITOR.tools.callFunction(19, this);");
			waitForElement( "//input[@name='wpVideoEmbedUrl']" );

			session().type("wpVideoEmbedUrl", "http://www.youtube.com/watch?v=LQjkDW3UPVk");
			session().click( "//input[@id='VideoEmbedUrlSubmit']" );
			waitForElement( "//input[@name='wpVideoEmbedName']" );
			session().type("wpVideoEmbedName", "CategoryExhibitionVideo1");
			session().click( "//tr[@class='VideoEmbedNoBorder']//input[@type='submit']" );
			waitForElement( "//div[@id='VideoEmbedPageSuccess']//input[@type='button']" );
			session().click( "//div[@id='VideoEmbedPageSuccess']//input[@type='button']" );
			waitForElement( "//input[@id='wpSave']" );
			session().click( "//input[@id='wpSave']" );
			session().waitForPageToLoad(this.getTimeout());

		}

		editArticle( "Video:CategoryExhibitionVideo1" , "[[category:CategoryExhibitionTest]]" );

		// open category page in classic preview
		session().open("wiki/Category:CategoryExhibitionTest?display=page&sort=mostvisited");
		session().waitForPageToLoad(this.getTimeout());

		// open category page ( mostvisited )
		session().open("wiki/Category:CategoryExhibitionTest?display=exhibition&sort=mostvisited");
		session().waitForPageToLoad(this.getTimeout());

		Number numberOfMostvisitedPages = session().getXpathCount("//div[@id='mw-images']//div[@class='wikia-paginator']//a");

		// open category page ( alphabetical )
		session().open("wiki/Category:CategoryExhibitionTest?display=exhibition&sort=alphabetical");
		session().waitForPageToLoad(this.getTimeout());

		Number numberOfAlphabeticalPages = session().getXpathCount("//div[@id='mw-images']//div[@class='wikia-paginator']//a");

		// open category page ( recent edits )
		session().open("wiki/Category:CategoryExhibitionTest?display=exhibition&sort=recentedits");
		session().waitForPageToLoad(this.getTimeout());

		Number numberOfRecentEditsPages = session().getXpathCount("//div[@id='mw-images']//div[@class='wikia-paginator']//a");

		if ( numberOfMostvisitedPages.equals( 0 )){
			assertTrue( true );
		}

		assertTrue( numberOfAlphabeticalPages.equals( numberOfRecentEditsPages ) );
		assertTrue( numberOfAlphabeticalPages.equals( numberOfMostvisitedPages ) );

		assertTrue( numberOfAlphabeticalPages.equals( numberOfMostvisitedPages ) );

		// open category page ( most visited edits )

		session().open("/wiki/Category:CategoryExhibitionTest?display=exhibition&sort=recentedits");
		session().waitForPageToLoad(this.getTimeout());

		// System.out.println("Checking Images lightbox.");
		session().click( "//div[@id='mw-images']//a[@class='lightbox']" );
		waitForElement( "//section[@id='lightbox']" );
		assertTrue( session().isElementPresent( "//section[@id='lightbox']" ) );

		// open video page ( most visited edits )

		session().open("/wiki/Category:CategoryExhibitionTest?display=exhibition&sort=recentedits");
		session().waitForPageToLoad(this.getTimeout());

		// System.out.println("Checking video player.");
		session().click("//div[@id='mw-images']//div[@class='category-gallery-item-play']");
		waitForElement("//section[@id='activityfeed-video-player']");
		assertTrue( session().isElementPresent("//section[@id='activityfeed-video-player']") );
	}
}
