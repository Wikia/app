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
	@Test(groups={"CI", "legacy"})
	public void testSpecialPreferences() throws Exception {
		loginAsStaff();
		session().open("index.php?title=Special:Preferences");
		session().waitForPageToLoad(this.getTimeout());
		session().click("//ul[@id='preftoc']/li[2]");
		waitForElement("//input[@id='mw-input-enotiffollowedminoredits']");

		session().uncheck( "//input[@id='mw-input-enotiffollowedminoredits']" );
		session().check( "//input[@id='mw-input-enotiffollowedminoredits']" );
		waitForElement("//input[@id='mw-input-enotifminoredits' and contains(@checked, 'checked')]");

		session().uncheck( "//input[@id='mw-input-enotifwatchlistpages']" );
		session().check( "//input[@id='mw-input-enotifwatchlistpages']" );

		waitForElement("//input[@id='mw-input-enotifminoredits' and contains(@checked, 'checked')]");
		session().check( "//input[@id='mw-input-hidefollowedpages']" );

		session().click( "//input[@id='prefcontrol']" );
		session().waitForPageToLoad(this.getTimeout());
		session().open( "index.php?title=Special:Following/" + getTestConfig().getString("ci.user.wikiastaff.username"));
		session().waitForPageToLoad(this.getTimeout());

		assertTrue( session().isTextPresent("chosen to hide"));

		session().click("link=Log out");
		session().waitForPageToLoad(this.getTimeout());
		session().open( "index.php?title=Special:Following/" + getTestConfig().getString("ci.user.wikiastaff.username"));
		session().waitForPageToLoad(this.getTimeout());
		assertFalse( session().isTextPresent("chosen to hide"));
		assertTrue( session().isTextPresent("Please log in to create or view your followed pages list."));
	}

	@Test(groups={"CI", "legacy"})
	public void testFollowUnFollow() throws Exception {
		session().open("index.php");
		login();
		session().open("index.php?title=TESTFOLLOW&action=edit&useeditor=mediawiki");
		session().type("wpTextbox1", "test123");
		session().click("wpSave");
		session().waitForPageToLoad(this.getTimeout());
		session().open("index.php?title=Special:Following&show_followed=1");
		session().open("index.php?title=TESTFOLLOW&action=unwatch");
		session().open( "index.php?title=Special:Following/" + getTestConfig().getString("ci.user.wikiabot.username"));
		session().waitForPageToLoad(this.getTimeout());
		assertTrue( !session().isTextPresent("TESTFOLLOW") );

		//a[@class='title-link' and contains(text(), 'TESTFOLLOW') ]

		session().open("index.php?title=TESTFOLLOW&action=watch");
		session().waitForPageToLoad(this.getTimeout());
		session().open( "index.php?title=Special:Following/" + getTestConfig().getString("ci.user.wikiabot.username"));
		session().waitForPageToLoad(this.getTimeout());
		assertTrue(session().isElementPresent("//a[@class='title-link' and contains(text(), 'TESTFOLLOW') ]"));

		session().open("index.php?title=User:" + getTestConfig().getString("ci.user.wikiabot.username") + "&action=edit&useeditor=mediawiki&useeditor=mediawiki");
		session().type("wpTextbox1", "test123");
		session().click("wpSave");
		session().waitForPageToLoad(this.getTimeout());
		session().open( "index.php?title=User:" + getTestConfig().getString("ci.user.wikiabot.username"));
		session().waitForPageToLoad(this.getTimeout());
		assertTrue(session().isElementPresent("//a[contains(text(), 'TESTFOLLOW')]"));
	}

	// Follow a random page, assert followed, unfollow, assert unfollowed
	@Test(groups={"CI", "legacy"})
	public void testFollowedPages() throws Exception {
		login();
		String ArticleTitle = "Test following pages " + (new Date()).toString();
		String ArticleUrlTitle = ArticleTitle.replace(" ", "_");
		editArticle(ArticleTitle, "Lorem ipsum");
		session().click("ca-watch");
		waitForElement("ca-unwatch");
		openAndWait("wiki/Special:Following");
		assertTrue(session().isElementPresent("link=" + ArticleTitle));
		clickAndWait("link=" + ArticleTitle);
		session().click("ca-unwatch");
		waitForElement("ca-watch");
		openAndWait("wiki/Special:Following");
		assertFalse(session().isElementPresent("link=" + ArticleTitle));
	}
}
