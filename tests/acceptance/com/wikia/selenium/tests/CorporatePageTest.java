package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertEquals;

import java.util.UUID;

import org.testng.annotations.Test;

public class CorporatePageTest extends BaseTest {
	private void initTrackerTest(){
		session().runScript("$('body').append('<input id=\'selenium_tracker\' id=\'hidden\' />');");
		session().runScript("jQuery.tracker.track = function(msg) { $('#selenium_tracker').val(msg); };");
	};

	private void clearAllLinks(){
		session().runScript("$('A').attr('href','#');");
	};

	private void assertLastTracker(String track){
		assertEquals("1", session().getText("//input[@id='selenium_tracker']"));
	};

	@Test(groups={"central","CI"})
	public void testAjaxLoginImagePlaceholder() throws Exception {
		initTrackerTest();
		clearAllLinks();
		session().click("//li[@id='wikia-international-0']");
		assertLastTracker("footer/left_column/Deutsch");
	};

	private void corporateLogin() throws Exception {
		session().open("index.php?title=Special:Signup");
		session().type("wpName2Ajax", getTestConfig().getString("ci.user.wikiastaff.username"));
		session().type("wpPassword2Ajax", getTestConfig().getString("ci.user.wikiastaff.password"));
		session().click("wpLoginattempt");
		session().waitForPageToLoad(TIMEOUT);
		waitForElement("//p[@id='wikia-account-tools']/strong[text() = '" + getTestConfig().getString("ci.user.wikiastaff.username") + "']");
	}

	@Test(groups={"central","CI"})
	public void testNavigationMenu() throws Exception {
		corporateLogin();
		String item = "Test item " + UUID.randomUUID();
		editArticle("MediaWiki:Corporatepage-sidebar", "*http://header.wikia.com/|Test header\n**http://item.wikia.com/|" + item);
		session().open("index.php?title=Main_Page&action=purge");
		session().waitForPageToLoad(TIMEOUT);
		// move mouse to first menu item to show items (doesn't work?)
//		session().mouseOver("//nav[@id='GlobalNav']//ul[@class='nav-top-level']/li[@class='last']/a");

		String result = session().getText("nav_sub_link_1_1");
		undoLastEdit("MediaWiki:Corporatepage-sidebar", "");
		assertEquals(item, result);
	}

	@Test(groups={"central","CI"})
	public void testSlider() throws Exception {
		corporateLogin();
		String text = "Test description " + UUID.randomUUID();
		editArticle("MediaWiki:Corporatepage-slider", "*http://test.wikia.com/|Test Wiki|" + text + "|File:Homepage.feature.0.jpg|File:Homepage.feature.thumb.0.jpg");
		session().open("index.php?title=Main_Page&action=purge");
		session().waitForPageToLoad(TIMEOUT);

		String result = session().getText("//div[@id='homepage-feature-box']/section[@id='homepage-feature-spotlight']/ul/li[@id='homepage-feature-spotlight-0']/div/p");
		undoLastEdit("MediaWiki:Corporatepage-slider", "");
		assertEquals(text, result);
	}

	@Test(groups={"central","CI"})
	public void testWhatsUp() throws Exception {
		corporateLogin();
		String text = "Test what's up text " + UUID.randomUUID();
		editArticle("MediaWiki:Corporatepage-wikia-whats-up", text);
		session().open("index.php?title=Main_Page&action=purge");
		session().waitForPageToLoad(TIMEOUT);

		String result = session().getText("//section[@id='wikia-whats-up']/div");
		undoLastEdit("MediaWiki:Corporatepage-wikia-whats-up", "");
		assertEquals(text, result);
	}

	@Test(groups={"central","CI"})
	public void testFooter() throws Exception {
		corporateLogin();
		//set random prefix
		String text = UUID.randomUUID().toString();

		//set result string
		String leftContentHTML = "left column: content " + text;
		String middleContentHTML = "middle column: content " + text;
		String rightContentHTML = "right column: content " + text;

		//set source string
		String leftHeader = "left column: header " + text;
		String leftContent = "* left column|" + leftContentHTML;
		String middleHeader = "middle column: header " + text;
		String middleContent = "* middle column|" + middleContentHTML + "|File:Icon.footer.facebook.32x32.png|new-window";
		String rightHeader = "right column: header " + text;
		String rightContent = "* right column|" + rightContentHTML;

		//edit messages
		editArticle("MediaWiki:Corporatepage-wikia-international", leftHeader);
		editArticle("MediaWiki:Corporatepage-footer-leftcolumn", leftContent);
		editArticle("MediaWiki:Corporatepage-in-the-know", middleHeader);
		editArticle("MediaWiki:Corporatepage-footer-middlecolumn", middleContent);
		editArticle("MediaWiki:Corporatepage-more-link", rightHeader);
		editArticle("MediaWiki:Corporatepage-footer-rightcolumn", rightContent);

		//visit main page
		session().open("index.php?title=Main_Page&action=purge");
		session().waitForPageToLoad(TIMEOUT);

		//store values for tests
		String leftHeaderValue = session().getText("//section[@id='wikia-international']/h1");
		String leftContentHTMLValue = session().getText("//section[@id='wikia-international']/ul/li[@id='wikia-international-0']/a");
		String middleHeaderValue = session().getText("//section[@id='wikia-in-the-know']/h1");
		String middleContentHTMLValue = session().getText("//section[@id='wikia-in-the-know']/ul/li[@id='wikia-in-the-know-0']/a");
		String rightHeaderValue = session().getText("//section[@id='wikia-more-links']/h1");
		String rightContentHTMLValue = session().getText("//section[@id='wikia-more-links']/ul/li[@id='wikia-more-links-0']/a");

		//undo our changes
		undoLastEdit("MediaWiki:Corporatepage-wikia-international", "");
		undoLastEdit("MediaWiki:Corporatepage-footer-leftcolumn", "");
		undoLastEdit("MediaWiki:Corporatepage-in-the-know", "");
		undoLastEdit("MediaWiki:Corporatepage-footer-middlecolumn", "");
		undoLastEdit("MediaWiki:Corporatepage-more-link", "");
		undoLastEdit("MediaWiki:Corporatepage-footer-rightcolumn", "");

		//do tests
		assertEquals(leftHeader, leftHeaderValue);
		assertEquals(leftContentHTML, leftContentHTMLValue);
		assertEquals(middleHeader, middleHeaderValue);
		assertEquals(middleContentHTML, middleContentHTMLValue);
		assertEquals(rightHeader, rightHeaderValue);
		assertEquals(rightContentHTML, rightContentHTMLValue);
	}
}
