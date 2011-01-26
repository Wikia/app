package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;

import org.testng.annotations.Test;
import static org.testng.AssertJUnit.assertTrue;

public class AutoHubsTest extends BaseTest {

	@Test(groups={"CI","central"})
	public void testFeeds() throws Exception {
		String baseurl = "/wiki/TV";
		session().open( baseurl );

		/* check count of feeds on the lists */
		waitForElement( "//ul[@id=\"top-wikis-list-1\"]/li[10]" );

		if ( !isOasis() ) {
			assertTrue(session().isElementPresent( "//ul[@id=\"hub-blog-articles\"]/li[3]" ));
		}
		assertTrue(session().isElementPresent( "//section[@id=\"hub-top-contributors\"]/ul/li[5]" ));
		assertTrue(session().isElementPresent( "//section[@id=\"wikia-global-hot-spots\"]/ol/li[5]" ));

		assertTrue(!session().isElementPresent( "//ul[@id=\"top-wikis-list-1\"]/li[11]" ));
		if ( !isOasis() ) {		
			assertTrue(!session().isElementPresent( "//ul[@id=\"hub-blog-articles\"]/li[4]" ));
		}
		assertTrue(!session().isElementPresent( "//section[@id=\"hub-top-contributors\"]/ul/li[6]" ));
		assertTrue(!session().isElementPresent( "//section[@id=\"wikia-global-hot-spots\"]/ol/li[6]" ));

		assertTrue(!session().isElementPresent( "//a[contains(@class,\"head-hide-link\")]" ));
	}

	@Test(groups={"CI","central"})
	public void testStaffTools() throws Exception {
		String baseurl = "/wiki/TV";
		loginAsStaff();

		session().open( baseurl );

		waitForElement( "//a[contains(@class,\"head-hide-link\")]" );
		Boolean Status = session().isElementPresent( "//ul[@id=\"top-wikis-list-1\"]/li[position()=1 and contains(@class,\"hide-blog\")]" );
		if ( Status ) {
			session().click("//ul[@id=\"top-wikis-list-1\"]/li[1]/div/a");
			session().waitForPageToLoad(this.getTimeout());
		}
	}
}
