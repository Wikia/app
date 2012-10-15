package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;
import static org.testng.AssertJUnit.assertFalse;

import org.testng.annotations.Test;

public class ContentDisplayTest extends BaseTest {

	@Test(groups={"CI", "legacy"})
	public void testContentDisplay() throws Exception {
		// find an image to use in wikitext
		session().open("index.php?title=Special:NewFiles");
		session().waitForPageToLoad(this.getTimeout());

		String fileName = session().getEval("window.jQuery('.wikia-gallery').find('img').eq(0).attr('title')");
		fileName = fileName.substring(0, fileName.lastIndexOf("(") - 1);
		String fileUploader = session().getEval("window.jQuery('.wikia-gallery').find('.wikia-gallery-item-user').eq(0).text()");

		// create test page
		loginAsStaff();

		String page = "WikiaStaffContentDisplayTest";
		editArticle(page, "== Foo ==\n\n[[File:" + fileName + "|thumb]]\n\ntest --~~~~\n\n[[Category:Foo]][[Category:Bar]]");

		// edit section chicklet button
		assertTrue(session().isElementPresent("//div[@id='WikiaArticle']//h2//span[@class='editsection']/a"));

		// picture attribution
		assertTrue(session().isElementPresent("//article//figure[contains(@class,'thumbinner')]//div[@class='picture-attribution']//a[text()='" + fileUploader + "']"));

		// categories
		assertTrue(session().isElementPresent("//div[@id='catlinks']//a[text()='Foo']"));
		assertTrue(session().isElementPresent("//div[@id='catlinks']//a[text()='Bar']"));

		// cleanup
		//doDelete("label=regexp:.*Author request", "Wikia PageTypes test");
	}
}
