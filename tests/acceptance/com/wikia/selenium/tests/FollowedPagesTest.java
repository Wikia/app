package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.closeSeleniumSession;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.startSeleniumSession;
import static org.testng.AssertJUnit.assertFalse;
import static org.testng.AssertJUnit.assertTrue;

import java.io.BufferedReader;
import java.io.FileReader;
import java.io.IOException;
import java.io.InputStream;
import java.math.BigInteger;
import java.net.URL;
import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;
import java.util.Date;

import org.testng.annotations.AfterMethod;
import org.testng.annotations.BeforeMethod;
import org.testng.annotations.Parameters;

import com.thoughtworks.selenium.SeleniumException;

import org.testng.annotations.Test;

public class FollowedPagesTest extends BaseTest {
	@Test(groups={"oasis", "CI"})
	public void testSpecialPreferences() throws Exception {
		loginAsStaff();
		session().open("index.php?title=Special:Preferences");
		session().waitForPageToLoad(TIMEOUT);
		session().click("//ul[@id='preftoc']/li[6]");
		waitForElement("//input[@id='watchlisthidebots']");
		waitForElement("//li[@class='selected']");

		session().uncheck( "//input[@id='enotiffollowedminoredits']" );
		session().check( "//input[@id='enotiffollowedminoredits']" );
		waitForElement("//input[@id='enotifminoredits' and contains(@checked, 'checked')]");

		session().uncheck( "//input[@id='enotifwatchlistpages']" );
		session().check( "//input[@id='enotifwatchlistpages']" );

		waitForElement("//input[@id='enotifminoredits' and contains(@checked, 'checked')]");
		session().check( "//input[@id='hidefollowedpages']" );

		session().click( "//input[@id='wpSaveprefs']" );
		session().waitForPageToLoad(TIMEOUT);
		session().open( "index.php?title=Special:Following/" + getTestConfig().getString("ci.user.wikiastaff.username"));
		session().waitForPageToLoad(TIMEOUT);

		assertTrue( session().isTextPresent("chosen to hide"));

		session().click("link=Log out");
		session().waitForPageToLoad(TIMEOUT);
		session().open( "index.php?title=Special:Following/" + getTestConfig().getString("ci.user.wikiastaff.username"));
		session().waitForPageToLoad(TIMEOUT);
		assertFalse( session().isTextPresent("chosen to hide"));
		assertTrue( session().isTextPresent("Please log in to create or view your followed pages list."));
	}

	@Test(groups={"oasis", "CI"})
	public void testFollowUnFollow() throws Exception {
		session().open("index.php");
		login();
		session().open("index.php?title=TESTFOLLOW&action=edit&useeditor=mediawiki");
		session().type("wpTextbox1", "test123");
		session().click("wpSave");
		session().waitForPageToLoad(TIMEOUT);
		session().open("index.php?title=Special:Following&show_followed=1");
		session().open("index.php?title=TESTFOLLOW&action=unwatch");
		session().open( "index.php?title=Special:Following/" + getTestConfig().getString("ci.user.wikiabot.username"));
		session().waitForPageToLoad(TIMEOUT);
		assertTrue( !session().isTextPresent("TESTFOLLOW") );

		//a[@class='title-link' and contains(text(), 'TESTFOLLOW') ]

		session().open("index.php?title=TESTFOLLOW&action=watch");
		session().waitForPageToLoad(TIMEOUT);
		session().open( "index.php?title=Special:Following/" + getTestConfig().getString("ci.user.wikiabot.username"));
		session().waitForPageToLoad(TIMEOUT);
		assertTrue(session().isElementPresent("//a[@class='title-link' and contains(text(), 'TESTFOLLOW') ]"));

		session().open("index.php?title=User:" + getTestConfig().getString("ci.user.wikiabot.username") + "&action=edit&useeditor=mediawiki&useeditor=mediawiki");
		session().type("wpTextbox1", "test123");
		session().click("wpSave");
		session().waitForPageToLoad(TIMEOUT);
		session().open( "index.php?title=User:" + getTestConfig().getString("ci.user.wikiabot.username"));
		session().waitForPageToLoad(TIMEOUT);
		assertTrue(session().isElementPresent("//a[contains(text(), 'TESTFOLLOW')]"));
	}

	// Follow a random page, assert followed, unfollow, assert unfollowed
	@Test(groups={"oasis", "CI"})
	public void testFollowedPages() throws Exception {
		login();
		session().click("link=Random Page");
		session().waitForPageToLoad(TIMEOUT);
		String ArticleTitle = session().getText("//header[@id='WikiaPageHeader']/h1");
		session().click("ca-watch");
		session().click("link=Followed pages");
		session().waitForPageToLoad(TIMEOUT);
		assertTrue(session().isElementPresent("link=" + ArticleTitle));
		session().click("link=" + ArticleTitle);
		session().waitForPageToLoad(TIMEOUT);
		session().click("ca-unwatch");
		session().click("link=Followed pages");
		assertFalse(session().isElementPresent("link=" + ArticleTitle));
	}
}
