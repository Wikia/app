/**
 * ScavengerHunt
 *
 * A ScavengerHunt extension for MediaWiki
 * Alows to create a scavenger hunt game on a wiki
 *
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @date 2011-01-31
 * @copyright Copyright (C) 2010 Maciej Błaszkowski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 *
 */

package com.wikia.selenium.tests;

import java.util.Date;
import java.text.SimpleDateFormat;
import java.text.DateFormat;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.*;

import org.testng.annotations.Test;

public class ScavengerHuntTest extends BaseTest {
	private boolean waitForElementBool(String xpath) throws Exception {
		for (int second = 0;; second++) {
			if (second >= 60) return false;
			try {
				if (session().isElementPresent(xpath)) return true;
			}
			catch (Exception e) {}
			Thread.sleep(500);
		}
	}

	@Test(groups={"oasis", "CI"})
	public void testGame() throws Exception {
		//prepare some data
		DateFormat df = new SimpleDateFormat("yyyyMMDDHHmm");
		String date = df.format(new Date());
		//general
		String generalGameName = "WikiaScavengerHuntGame " + date;
		String generalLanding = "Main Page";	//this title MUST exist
		String generalButton = "Start a game!";
		String imageTop = "150";
		String imageLeft = "-150";
		//starting
		String startingClueTitle = "Starting title " + date;
		String startingClueText = "Starting clue text " + date;
		String startingClueImage = "http://images2.wikia.nocookie.net/__cb20101125134213/lukasztest/pl/images/8/84/Test_picture_1.png";
		String startingButtonText = "Starting clue button " + date;
		String startingButtonTarget = "http://wikia.com/?target=starting&date=" + date;
		//article
		String articleTitle = "Main Page";	//this title MUST exist
		String articleTitle2 = "Test";	//this title MUST exist
		String articleHiddenImage = "http://images2.wikia.nocookie.net/__cb20101125134214/lukasztest/pl/images/f/f6/Test_picture_2.png";
		String articleHiddenImage2 = "http://images3.wikia.nocookie.net/__cb20101125134215/lukasztest/pl/images/4/44/Test_picture_6.png";
		String articleClueTitle = "Article clue title " + date;
		String articleClueText = "Article clue text " + date;
		String articleClueImage = "http://images4.wikia.nocookie.net/__cb20101125134214/lukasztest/pl/images/d/da/Test_picture_3.png";
		String articleButtonText = "Article clue button " + date;
		String articleButtonTarget = "http://wikia.com/?target=article1&date=" + date;
		String articleButtonTarget2 = "http://wikia.com/?target=article2&date=" + date;
		//entry form
		String entryModalTitle = "Entry title " + date;
		String entryModalText = "Entry modal text " + date;
		String entryModalImage = "http://images1.wikia.nocookie.net/__cb20101125134214/lukasztest/pl/images/8/8c/Test_picture_4.png";
		String entryQuestion = "Entry question " + date;
		//entry form data
		String entryFormQuestion = "Entry form question " + date;
		String entryFormName = "Entry form name " + date;
		String entryFormEmail = date + "@EntryFormMail.pl";
		//goodbye
		String goodbyeModalTitle = "Goodbye title " + date;
		String goodbyeModalText = "Goodbye text " + date;
		String goodbyeModalImage = "http://images1.wikia.nocookie.net/__cb20101125134214/lukasztest/pl/images/8/88/Test_picture_5.png";

		loginAsStaff();

		//go to the list
		session().open("index.php?title=Special:ScavengerHunt");
		session().waitForPageToLoad(this.getTimeout());

		//click `add` button
		assertTrue(session().isElementPresent("//header[@id='WikiaPageHeader']//a[contains(@class, 'scavengerhunt-add-button')]"));
		session().click("//header[@id='WikiaPageHeader']//a[contains(@class, 'scavengerhunt-add-button')]");
		session().waitForPageToLoad(this.getTimeout());

		//fill in the form
		//general
		session().type("gameName", generalGameName);
		session().type("//input[@name='landingTitle']", generalLanding);
		session().type("//input[@name='landingButtonText']", generalButton);
		//starting
		session().type("//input[@name='startingClueTitle']", startingClueTitle);
		session().type("//textarea[@name='startingClueText']", startingClueText);
		session().type("//input[@name='startingClueImage']", startingClueImage);
		session().type("//input[@name='startingClueImageTopOffset']", imageTop);
		session().type("//input[@name='startingClueImageLeftOffset']", imageLeft);
		session().type("//input[@name='startingClueButtonText']", startingButtonText);
		session().type("//input[@name='startingClueButtonTarget']", startingButtonTarget);
		//article #1
		session().type("//input[@name='articleTitle[]']", articleTitle);
		session().type("//input[@name='articleHiddenImage[]']", articleHiddenImage);
		session().type("//input[@name='articleClueTitle[]']", articleClueTitle);
		session().type("//textarea[@name='articleClueText[]']", articleClueText);
		session().type("//input[@name='articleClueImage[]']", articleClueImage);
		session().type("//input[@name='articleClueImageTopOffset[]']", imageTop);
		session().type("//input[@name='articleClueImageLeftOffset[]']", imageLeft);
		session().type("//input[@name='articleClueButtonText[]']", articleButtonText);
		session().type("//input[@name='articleClueButtonTarget[]']", articleButtonTarget);
		//add article #2 (invoke onblur() on articleTitle)
		session().getEval("window.$('input[name=\"articleTitle[]\"]').blur()");
		session().type("//fieldset[@class='scavenger-article'][2]//input[@name='articleTitle[]']", articleTitle2);
		session().type("//fieldset[@class='scavenger-article'][2]//input[@name='articleHiddenImage[]']", articleHiddenImage2);
		session().type("//fieldset[@class='scavenger-article'][2]//input[@name='articleClueTitle[]']", articleClueTitle);
		session().type("//fieldset[@class='scavenger-article'][2]//textarea[@name='articleClueText[]']", articleClueText);
		session().type("//fieldset[@class='scavenger-article'][2]//input[@name='articleClueImage[]']", articleClueImage);
		session().type("//fieldset[@class='scavenger-article'][2]//input[@name='articleClueImageTopOffset[]']", imageTop);
		session().type("//fieldset[@class='scavenger-article'][2]//input[@name='articleClueImageLeftOffset[]']", imageLeft);
		session().type("//fieldset[@class='scavenger-article'][2]//input[@name='articleClueButtonText[]']", articleButtonText);
		session().type("//fieldset[@class='scavenger-article'][2]//input[@name='articleClueButtonTarget[]']", articleButtonTarget2);
		//entry
		session().type("//input[@name='entryFormTitle']", entryModalTitle);
		session().type("//textarea[@name='entryFormText']", entryModalText);
		session().type("//input[@name='entryFormImage']", entryModalImage);
		session().type("//input[@name='entryFormImageTopOffset']", imageTop);
		session().type("//input[@name='entryFormImageLeftOffset']", imageLeft);
		session().type("//textarea[@name='entryFormQuestion']", entryQuestion);
		//goodbye
		session().type("//input[@name='goodbyeTitle']", goodbyeModalTitle);
		session().type("//textarea[@name='goodbyeText']", goodbyeModalText);
		session().type("//input[@name='goodbyeImage']", goodbyeModalImage);
		session().type("//input[@name='goodbyeImageTopOffset']", imageTop);
		session().type("//input[@name='goodbyeImageLeftOffset']", imageLeft);
		//finish
		session().click("//form[@class='scavenger-form']//input[@name='save']");
		session().waitForPageToLoad(this.getTimeout());

		//check confirmation (Oasis only)
//		assertTrue(session().isElementPresent("//section[@id='WikiaPage']/div[@class='WikiaConfirmation']"));

		//go to the last page if we have more than one
		if (session().isElementPresent("//div[@id='WikiaArticle']/a[@class='mw-lastlink']")) {
			session().click("//div[@id='WikiaArticle']/a[@class='mw-lastlink']");
			session().waitForPageToLoad(this.getTimeout());
		}

		//check if new game is on the list
		assertTrue(session().isElementPresent("//div[@id='WikiaArticle']/table/tbody/tr/td[contains(text(), '" + generalGameName + "')]"));
		//click edit
		session().click("//div[@id='WikiaArticle']/table/tbody/tr[td[contains(text(), '" + generalGameName + "')]]/td[3]/a");
		session().waitForPageToLoad(this.getTimeout());
		//enable the game
		session().click("//form[@class='scavenger-form']//input[@name='enable']");
		session().waitForPageToLoad(this.getTimeout());

		//go to article with game data (starting point)
		session().open("index.php?title=" + generalLanding);
		session().waitForPageToLoad(this.getTimeout());
		//check presence of start button
		assertTrue(session().isElementPresent("//div[@id='WikiaArticle']//input[@value='" + generalButton + "']"));
		//click it
		session().click("//div[@id='WikiaArticle']//input[@value='" + generalButton + "']");
		//wait for modal and check presence of the button
		assertTrue(waitForElementBool("//div[@class='scavenger-clue-button']/a[@href='" + startingButtonTarget + "']"));

		//go to article with game data (1st article)
		session().open("index.php?title=" + articleTitle);
		session().waitForPageToLoad(this.getTimeout());
		//wait for hidden image
		assertTrue(waitForElementBool("//img[@class='scavenger-hidden-image' and @src='" + articleHiddenImage + "']"));
		//click on it
		session().click("//img[@class='scavenger-hidden-image' and @src='" + articleHiddenImage + "']");
		//wait for modal and check presence of the button
		assertTrue(waitForElementBool("//div[@class='scavenger-clue-button']/a[@href='" + articleButtonTarget + "']"));

		//go to article with game data (2st article)
		session().open("index.php?title=" + articleTitle2);
		session().waitForPageToLoad(this.getTimeout());
		//wait for hidden image
		assertTrue(waitForElementBool("//img[@class='scavenger-hidden-image' and @src='" + articleHiddenImage2 + "']"));
		//click on it
		session().click("//img[@class='scavenger-hidden-image' and @src='" + articleHiddenImage2 + "']");
		//wait for modal - it's the last article so we should get entry form
		assertTrue(waitForElementBool("//form[@class='scavenger-entry-form']"));
		//fill in the form
		session().type("//form[@class='scavenger-entry-form']/textarea[@name='answer']", entryFormQuestion);
		session().type("//form[@class='scavenger-entry-form']/input[@name='name']", entryFormName);
		session().type("//form[@class='scavenger-entry-form']/input[@name='email']", entryFormEmail);
		//unblock submit button
		session().getEval("window.$('#scavengerEntryFormModal').find('.scavenger-clue-button input[type=submit]').attr('disabled', '');");
		//send it
		session().click("//form[@class='scavenger-entry-form']//input[@type='submit']");

		//wait for goodbye form
		assertTrue(waitForElementBool("//section[@id='scavengerGoodbyeModal']"));

		//clear after test - delete the game
		//go to the list
		session().open("index.php?title=Special:ScavengerHunt");
		session().waitForPageToLoad(this.getTimeout());
		//click edit
		session().click("//div[@id='WikiaArticle']/table/tbody/tr[td[contains(text(), '" + generalGameName + "')]]/td[3]/a");
		session().waitForPageToLoad(this.getTimeout());
		//click delete
		session().click("//form[@class='scavenger-form']//input[@name='delete']");
		//wait for confirm modal
		assertTrue(waitForElementBool("//section[@id='WikiaConfirm']"));
		//click ok
		session().click("//a[@id='WikiaConfirmOk']");
		session().waitForPageToLoad(this.getTimeout());
	}
}