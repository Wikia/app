//@author Marooned
//test changeset t:r14920
package com.wikia.selenium.tests;

import org.testng.annotations.Test;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;

public class ReturnToTest extends BaseTest {
	@Test(groups={"oasis", "CI"})
	public void testBlogListingPage() throws Exception {
		// go to Special:CreateBlogListingPage
		session().open("index.php?title=Special:CreateBlogListingPage");

		// check link with returnto
		if(isOasis()){
			assertTrue(session().isElementPresent("//section[@id='WikiaPage']//a[contains(@href, 'title=Special:Signup&returnto=Special:CreateBlogListingPage')]"));
		} else {
			assertTrue(session().isElementPresent("//div[@id='bodyContent']//a[contains(@href, 'title=Special:Signup&returnto=Special:CreateBlogListingPage')]"));
		}
	}

	@Test(groups={"oasis", "CI"})
	public void testBlogPage() throws Exception {
		// go to Special:CreateBlogPage
		session().open("index.php?title=Special:CreateBlogPage");

		// check link with returnto\
		if(isOasis()){
			assertTrue(session().isElementPresent("//section[@id='WikiaPage']//a[contains(@href, 'title=Special:Signup&returnto=Special:CreateBlogPage')]"));
		} else {
			assertTrue(session().isElementPresent("//div[@id='bodyContent']//a[contains(@href, 'title=Special:Signup&returnto=Special:CreateBlogPage')]"));
		}
	}

	@Test(groups={"oasis", "CI"})
	public void testMyHome() throws Exception {
		// Oasis uses Special:WikiActivity instead of MyHome and you don't need to be logged in to see it.
		session().open("index.php?title=Special:MyHome");

		// NOTE: isOasis() doesn't work until after you've loaded a page (it uses window.skin).
		if(isOasis()){
			assertTrue(true);
		} else {
			// check link with returnto
			assertTrue(session().isElementPresent("//div[@id='myhome-log-in']//a[contains(@href, 'title=Special:Signup&returnto=Special:MyHome')]"));
		}
	}

	@Test(groups={"oasis", "CI"})
	public void testUpload() throws Exception {
		// go to Special:Upload
		session().open("index.php?title=Special:Upload");

		// check link with returnto
		if(isOasis()){
			assertTrue(session().isElementPresent("//section[@id='WikiaPage']//a[contains(@href, 'title=Special:Signup&returnto=Special:Upload')]"));
		} else {
			assertTrue(session().isElementPresent("//div[@id='bodyContent']//a[contains(@href, 'title=Special:Signup&returnto=Special:Upload')]"));
		}
	}

	@Test(groups={"oasis", "CI"})
	//works ONLY when $wgGroupPermissions['*']['edit'] = false;
	public void testEditPermission() throws Exception {
		// go to Special:Upload
		session().open("index.php?title=Main_Page&action=edit");

		// check link with returnto
		if(isOasis()){
			assertTrue(session().isElementPresent("//section[@id='WikiaPage']//a[contains(@href, 'title=Special:Signup&returnto=Main_Page')]"));
		} else {
			assertTrue(session().isElementPresent("//div[@id='bodyContent']//a[contains(@href, 'title=Special:Signup&returnto=Main_Page')]"));
		}
	}

	@Test(groups={"oasis", "CI"})
	public void testSpecialPages() throws Exception {
		// go to Special:SpecialPages
		session().open("index.php?title=Special:SpecialPages");

		// check link in monaco toolbar ???
		//assertTrue(session().isElementPresent("//a[@id='dynamic-links-add-image-link' and contains(@href, 'title=Special:SignUp&returnto=Special:Upload')]"));

		String rootElement = "div[@id='bodyContent']";
		if(isOasis()){
			rootElement = "section[@id='WikiaPage']";
		}
		// check link for selected special page
		assertTrue(session().isElementPresent("//" + rootElement + "//a[contains(@href,'title=Special:Signup&returnto=Special%3AChangePassword')]"));

		// check link for selected special page
		assertTrue(session().isElementPresent("//" + rootElement + "//a[contains(@href, 'title=Special:Signup&returnto=Special%3AMyHome')]"));

		// check link for selected special page
		assertTrue(session().isElementPresent("//" + rootElement + "//a[contains(@href, 'title=Special:Signup&returnto=Special%3APreferences')]"));

		// check link for selected special page
		assertTrue(session().isElementPresent("//" + rootElement + "//a[contains(@href, 'title=Special:Signup&returnto=Special%3AWatchlist')]"));

		// check link for selected special page
		assertTrue(session().isElementPresent("//" + rootElement + "//a[contains(@href, 'title=Special:Signup&returnto=Special%3AUpload')]"));

		// check link for selected special page
		assertTrue(session().isElementPresent("//" + rootElement + "//a[contains(@href, 'title=Special:Signup&returnto=Special%3ACreateBlogPage')]"));

		// check link for selected special page
		assertTrue(session().isElementPresent("//" + rootElement + "//a[contains(@href, 'title=Special:Signup&returnto=Special%3ACreateBlogListingPage')]"));
	}
}
