package com.wikia.selenium.tests;

import org.testng.annotations.Test;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;

public class MonacoSidebarTest extends BaseTest {

	@Test(groups={"monaco"})
	public void testNavigationMenu() throws Exception {
		// go to main page
		session().open("index.php?useskin=monaco");

		// navigation menu wrapper and first item
		assertTrue(session().isElementPresent("navigation"));
		assertTrue(session().isElementPresent("menu-item_1"));

		// move mouse to first menu item and check it's hover class
		session().mouseOver("//div[@id=\"menu-item_1\"]");
		assertTrue(session()
				.isElementPresent(
						"//div[@id=\"menu-item_1\" and contains(@class, \"navigation-hover\")]"));
	}

	@Test(groups={"monaco"})
	public void testSearchSuggest() throws Exception {
		// go to main page
		session().open("index.php?useskin=monaco");

		// search field
		waitForElement("search_field");

		// type search term and wait for suggestion box
		session().type("search_field", "Main");

		session().waitForCondition(
				"!!window.document.getElementsByClassName(\"autocomplete\")",
				TIMEOUT);
	}

	@Test(groups={"monaco"})
	public void testCreateWikiLink() throws Exception {
		// go to main page
		session().open("index.php?useskin=monaco");

		// check element presence
		assertTrue(session().isElementPresent("request_wiki"));

		// check URL
		assertTrue(session().isElementPresent(
				"//a[@href=\"http://www.wikia.com/Special:CreateWiki\"]"));
	}

	@Test(groups={"monaco"})
	public void testCommunityWidget() throws Exception {
		// go to main page
		session().open("index.php?useskin=monaco");

		// check widget presence
		assertTrue(session().isElementPresent(
				"//dl[@class=\"widget WidgetCommunity\"]"));

		// check presence of items in widget - at least one
		assertTrue(session().isElementPresent("//dl[@class='widget WidgetCommunity']//div[@class='community_body']/ul[count(li[@class='activity-type-edit'])>0]"));

	}

	@Test(groups={"monaco"})
	public void testToolbox() throws Exception {
		// go to main page
		session().open("index.php?useskin=monaco");

		// assert presence of any toolbox link
		assertTrue(session().isElementPresent( "//tbody[@id='link_box']//a" ) );
	}
}
