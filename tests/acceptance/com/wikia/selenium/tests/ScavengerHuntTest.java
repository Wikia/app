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

import org.testng.annotations.*;

public class ScavengerHuntTest extends BaseTest {
	private static final String GAME_SPRITE_URL = "http://img215.imageshack.us/img215/2686/shsprite3.png";
	private static final String LANDING_PAGE    = "Scavenger Test Landing Page";
	private static final String START_PAGE      = "Scavenger Test Start";
	private static final String TARGET_PAGE_ONE = "Scavenger Test Page One";
	private static final String TARGET_PAGE_TWO = "Scavenger test Page Two";
	
	private boolean isDataPrepared = false;
	private String createdGameName = null;
	
	@BeforeMethod(alwaysRun = true)
	public void prepareData() throws Exception {
		loginAsStaff();
		
		if (!isDataPrepared) {
			String content = "Lorem ipsum " + (new Date()).toString();
			editArticle(LANDING_PAGE, content);
			editArticle(START_PAGE, content);
			editArticle(TARGET_PAGE_ONE, content);
			editArticle(TARGET_PAGE_TWO, content);
			isDataPrepared = true;
		}
	}
	
	@AfterMethod(alwaysRun = true)
	public void deleteArtifacts() throws Exception {
		session().open("wiki/Special:ScavengerHunt");
		session().waitForPageToLoad(this.getTimeout());
		
		if (createdGameName != null) {
			int index = findGamePosition(createdGameName);
			
			if (index > 0) {
				session().click("//table[contains(@class, 'scavengerhunt-list-table')]//tr[" + index + "]/td[3]/a");
				session().waitForPageToLoad(this.getTimeout());
				session().click("delete");
				waitForElement("//section[@id='WikiaConfirm']");
				session().click("//a[@id='WikiaConfirmOk']");
				session().waitForPageToLoad(this.getTimeout());
				assertTrue("Game has not been deleted", session().isTextPresent("Hunt game has been deleted"));
			}
		}
	}
	
	private int findGamePosition(String name) {
		int index = 1;
		boolean found = false;
		
		while (!found && session().isElementPresent("//table[contains(@class, 'scavengerhunt-list-table')]//tr[" + index + "]/td")) {
			if (session().getText("//table[contains(@class, 'scavengerhunt-list-table')]//tr[" + index + "]/td").equals(name)) {
				found = true;
			} else {
				index++;
			}
		}
		
		if (!found) {
			index = -1;
		}
		
		return index;
	}

	/**
	 * Smoke test for creating a hunt
	 * Verify user is redirected to list of hunts
	 * Verify it is visible on the list of hunts
	 * Verify it is disabled
	 */
	@Test(groups={"CI"})
	public void testCreatingAHunt() throws Exception {
		session().open("wiki/Special:ScavengerHunt");
		session().waitForPageToLoad(this.getTimeout());
		waitForElement("//a[contains(@class, 'scavengerhunt-add-button')]");
		session().click("//a[contains(@class, 'scavengerhunt-add-button')]");
		session().waitForPageToLoad(this.getTimeout());
		
		// save empty form
		session().click("save");
		session().waitForPageToLoad(this.getTimeout());
		assertTrue("Game without name has been created", session().isTextPresent("Please correct the following errors"));
		assertTrue("Game without name has been created", session().isTextPresent("Please enter the hunt name"));
		
		// fill in form, save
		String gameName = "Test game " + (new Date()).toString();
		session().type("gameName", gameName);
		session().click("save");
		session().waitForPageToLoad(this.getTimeout());
		
		// verify messages
		assertTrue("After creating game user should be redirected to list of games", session().getLocation().contains("wiki/Special:ScavengerHunt"));
		assertFalse("After creating game user should be redirected to list of games", session().getLocation().contains("wiki/Special:ScavengerHunt/add"));
		assertFalse("After creating game user should be redirected to list of games", session().getLocation().contains("wiki/Special:ScavengerHunt/edit"));
		assertTrue("Could not find newly created game on list of games", session().isTextPresent(gameName));
		assertTrue("Created hunt  message not displayed", session().isTextPresent("New Scavenger Hunt game has been created."));
		
		this.createdGameName = gameName;
		
		// check status
		int index = findGamePosition(gameName);
		
		assertEquals("Created game is not disabled", session().getText("//table[contains(@class, 'scavengerhunt-list-table')]//tr[" + index + "]/td[2]/a"), "Disabled");
		
		// edit and try to enable the game
		session().click("//table[contains(@class, 'scavengerhunt-list-table')]//tr[" + index + "]/td[3]/a");
		session().waitForPageToLoad(this.getTimeout());
		session().click("enable");
		session().waitForPageToLoad(this.getTimeout());

		assertTrue("Game missing data has been enabled", session().isTextPresent("Please correct the following errors"));
	}
	
	/**
	 * Fully featured hunt test
	 * 
	 * Covers creation, enabling/disabling, playing/quiting/completing the game
	 */
	@Test(groups={"CI"})
	public void testCreateAnExampleHunt() throws Exception {
		session().open("wiki/Special:ScavengerHunt");
		session().waitForPageToLoad(this.getTimeout());
		waitForElement("//a[contains(@class, 'scavengerhunt-add-button')]");
		session().click("//a[contains(@class, 'scavengerhunt-add-button')]");
		session().waitForPageToLoad(this.getTimeout());
		
		String gameName = "Test game " + (new Date()).toString();

		//General
		//Name
		session().type("gameName", gameName);
		
		//Landing page 
		session().type("landingTitle", (this.webSite + "/wiki/" + LANDING_PAGE.replace(" ", "_")).replace("//wiki", "/wiki"));
		String landingButton = "landing button" +(gameName);
		session().type("landingButtonText", landingButton);
		session().type("landingButtonX", "10");
		session().type("landingButtonY", "20");
		
		//Sprite Image path
		session().type("spriteImg", GAME_SPRITE_URL);
		
		//Progress Bar
		//Progress bar background sprite 
		//Element Position
		session().type("progressBarBackgroundSpriteX", "-350");
		session().type("progressBarBackgroundSpriteY", "-200");
		//Sprite top-left
		session().type("progressBarBackgroundSpriteX1", "0");
		session().type("progressBarBackgroundSpriteY1", "462");
		//Sprite bottom-right
		session().type("progressBarBackgroundSpriteX2", "317");
		session().type("progressBarBackgroundSpriteY2", "601");
	
		//Exit button sprite coordinates 
		//Element Position
		session().type("progressBarExitSpriteX", "-60");
		session().type("progressBarExitSpriteY", "-190");
		//Sprite top-left
		session().type("progressBarExitSpriteX1", "304");
		session().type("progressBarExitSpriteY1", "356");
		//Sprite bottom-right
		session().type("progressBarExitSpriteX2", "324");
		session().type("progressBarExitSpriteY2", "376");

	
		//Clue label coordinates 
		//Element Position
		session().type("progressBarHintLabelX", "-350");
		session().type("progressBarHintLabelY", "-100");
		//Sprite top-left
		session().type("progressBarHintLabelX1", "0");
		session().type("progressBarHintLabelY1", "716");		
		//Sprite bottom-right
		session().type("progressBarHintLabelX2", "317");
		session().type("progressBarHintLabelY2", "754");

		//Starting Clue popup
		//Popup title: 
		//String popuptitle = ("Start clue title " + gamename);
		String startingClueTitle = "starting Clue Title " +(gameName);
		session().type("startingClueTitle", startingClueTitle);
		//Popup text: (text in <div> will have link color) 
		String startingClueText = "starting Clue Text " +(gameName);
		session().type("startingClueText", startingClueText);
		//Popup button text 
		String startingClueButtonText = "starting Clue Button Text " +(gameName);
		session().type("startingClueButtonText", startingClueButtonText);
		//Popup button target (URL address)
		session().type("startingClueButtonTarget", (this.webSite + "/wiki/" + START_PAGE.replace(" ", "_")).replace("//wiki", "/wiki"));
		//Popup image sprite coordinates 
		//Element Position
		session().type("startPopupSpriteX", "0");
		session().type("startPopupSpriteY", "0");
		
		//Sprite top-left
		session().type("startPopupSpriteX1", "0");
		session().type("startPopupSpriteY1", "0");
		//Sprite bottom-right
		session().type("startPopupSpriteX2", "2");
		session().type("startPopupSpriteY2", "2");
		
		//Article (in-game page) #1
		//Page title (article URL on any wiki) 
		session().type("articleTitle[0]", (this.webSite + "/wiki/" + TARGET_PAGE_ONE.replace(" ", "_")).replace("//wiki", "/wiki"));
		//Hunt item sprite coordinates 
		//Element Position
		session().type("spriteNotFoundX[0]", "400");
		session().type("spriteNotFoundY[0]", "400");
		//Sprite top-left
		session().type("spriteNotFoundX1[0]", "0");
		session().type("spriteNotFoundY1[0]", "7");
		
		//Sprite bottom-right
		session().type("spriteNotFoundX2[0]", "85");
		session().type("spriteNotFoundY2[0]", "247");
		
		//Progress bar item sprite coordinates 
		//Element Position
		session().type("spriteInProgressBarX[0]", "-330");
		session().type("spriteInProgressBarY[0]", "-170");
		//Sprite top-left
		session().type("spriteInProgressBarX1[0]", "0");
		session().type("spriteInProgressBarY1[0]", "258");
		//Sprite bottom-right
		session().type("spriteInProgressBarX2[0]", "59");
		session().type("spriteInProgressBarY2[0]", "365");
		
		//Progress bar item on hover sprite coordinates 
		//Element Position
		session().type("spriteInProgressBarHoverX[0]", "-335");
		session().type("spriteInProgressBarHoverY[0]", "-175");
		//Sprite top-left
		session().type("spriteInProgressBarHoverX1[0]", "0");
		session().type("spriteInProgressBarHoverY1[0]", "604");
		//Sprite bottom-right
		session().type("spriteInProgressBarHoverX2[0]", "59");
		session().type("spriteInProgressBarHoverY2[0]", "706");
		
		//Progress bar item not found 
		//Element Position
		session().type("spriteInProgressBarNotFoundX[0]", "-330");
		session().type("spriteInProgressBarNotFoundY[0]", "-170");
		//Sprite top-left
		session().type("spriteInProgressBarNotFoundX1[0]", "0");
		session().type("spriteInProgressBarNotFoundY1[0]", "361");
		//Sprite bottom-right
		session().type("spriteInProgressBarNotFoundX2[0]", "60");
		session().type("spriteInProgressBarNotFoundY2[0]", "463");
		
		//Clue popup text 
		String articleFirstClueText = "Article first clue test " +(gameName);
		session().type("clueText[0]", articleFirstClueText);
		
		
		//Congratulations message 
		String CongratsFirstClueText = "Congrats first clue " +(gameName);
		session().type("congrats[0]", CongratsFirstClueText);

		
		//Article (in-game page) #2
		session().click("addSection");
		//Page title (article URL on any wiki) 
		session().type("articleTitle[1]", (this.webSite + "/wiki/" + TARGET_PAGE_TWO.replace(" ", "_")).replace("//wiki", "/wiki"));
		//Hunt item sprite coordinates 
		//Element Position
		session().type("spriteNotFoundX[1]", "400");
		session().type("spriteNotFoundY[1]", "400");
		//Sprite top-left
		session().type("spriteNotFoundX1[1]", "85");
		session().type("spriteNotFoundY1[1]", "18");
		
		//Sprite bottom-right
		session().type("spriteNotFoundX2[1]", "154");
		session().type("spriteNotFoundY2[1]", "244");
		
		//Progress bar item sprite coordinates 
		//Element Position
		session().type("spriteInProgressBarX[1]", "-250");
		session().type("spriteInProgressBarY[1]", "-170");
		//Sprite top-left
		session().type("spriteInProgressBarX1[1]", "59");
		session().type("spriteInProgressBarY1[1]", "261");
		//Sprite bottom-right
		session().type("spriteInProgressBarX2[1]", "107");
		session().type("spriteInProgressBarY2[1]", "716");
		
		//Progress bar item on hover sprite coordinates 
		//Element Position
		session().type("spriteInProgressBarHoverX[1]", "-255");
		session().type("spriteInProgressBarHoverY[1]", "-168");
		//Sprite top-left
		session().type("spriteInProgressBarHoverX1[1]", "70");
		session().type("spriteInProgressBarHoverY1[1]", "612");
		//Sprite bottom-right
		session().type("spriteInProgressBarHoverX2[1]", "127");
		session().type("spriteInProgressBarHoverY2[1]", "716");
		
		//Progress bar item not found 
		//Element Position
		session().type("spriteInProgressBarNotFoundX[1]", "-250");
		session().type("spriteInProgressBarNotFoundY[1]", "-170");
		//Sprite top-left
		session().type("spriteInProgressBarNotFoundX1[1]", "59");
		session().type("spriteInProgressBarNotFoundY1[1]", "361");
		//Sprite bottom-right
		session().type("spriteInProgressBarNotFoundX2[1]", "107");
		session().type("spriteInProgressBarNotFoundY2[1]", "462");
		
		//Clue popup text 
		String articleSecondClueText = "Article Second clue test " +(gameName);
		session().type("clueText[1]", articleSecondClueText);
		
		//Congratulations message 
		String CongratsSecondClueText = "Congrats Second clue " +(gameName);
		session().type("congrats[1]", CongratsSecondClueText);
		
		//Entry form
		//Popup title 
		String entryFormTitle = "Entry form title " +(gameName);
		session().type("entryFormTitle", entryFormTitle);
		
		//Popup text
		String entryFormText = "Entry form title " +(gameName);
		session().type("entryFormText", entryFormText);
		
		String entryFormButtonText = "Entry form button " + (gameName);
		session().type("entryFormButtonText", entryFormButtonText);

		//Popup question
		String entryFormQuestion = "Entry form question " +(gameName);
		session().type("entryFormQuestion", entryFormQuestion);
		
		//User email
		session().type("entryFormEmail", "p_archbold@hotmail.com");
		// Uaer Name
		session().type("entryFormUsername", "User name 123");
		
		//Goodbye popup
		//Popup title
	
		String goodbyeTitle = "Good bye title " +(gameName);
		session().type("goodbyeTitle", goodbyeTitle);
		
		//Popup message
		String goodbyeText = "Good bye Text " +(gameName);
		session().type("goodbyeText", goodbyeText);
	
		//Popup image sprite coordinates 
		//Element Position
		session().type("finishPopupSpriteX", "0");
		session().type("finishPopupSpriteY", "0");
		//Sprite top-left
		session().type("finishPopupSpriteX1", "0");
		session().type("finishPopupSpriteY1", "0");
		//Sprite bottom-right
		session().type("finishPopupSpriteX2", "2");
		session().type("finishPopupSpriteY2", "2");
		session().click("save");
		session().waitForPageToLoad(this.getTimeout());
		
		assertTrue("After creating game user should be redirected to list of games", session().getLocation().contains("wiki/Special:ScavengerHunt"));
		assertFalse("After creating game user should be redirected to list of games", session().getLocation().contains("wiki/Special:ScavengerHunt/add"));
		assertFalse("After creating game user should be redirected to list of games", session().getLocation().contains("wiki/Special:ScavengerHunt/edit"));
		assertTrue("Could not find newly created game on list of games", session().isTextPresent(gameName));
		
		this.createdGameName = gameName;
		
		// landing page (disabled)
		session().open((this.webSite + "/wiki/" + LANDING_PAGE.replace(" ", "_")).replace("//wiki", "/wiki"));
		session().waitForPageToLoad(this.getTimeout());
		
		assertFalse("Start button of disabled game is present", session().isElementPresent("//input[@value='" + landingButton + "']"));
		
		// enable game
		session().open("wiki/Special:ScavengerHunt");
		session().waitForPageToLoad(this.getTimeout());
		
		int index = findGamePosition(gameName);
		
		// edit and try to enable the game
		session().click("//table[contains(@class, 'scavengerhunt-list-table')]//tr[" + index + "]/td[3]/a");
		session().waitForPageToLoad(this.getTimeout());
		session().click("enable");
		session().waitForPageToLoad(this.getTimeout());

		assertTrue("Valid game hasn't been enabled", session().isTextPresent("Selected Scavenger Hunt game has been enabled."));
		
		// landing page (enabled)
		session().open((this.webSite + "/wiki/" + LANDING_PAGE.replace(" ", "_")).replace("//wiki", "/wiki"));
		session().waitForPageToLoad(this.getTimeout());
		
		assertTrue("Start button of enabled game is not present", session().isElementPresent("//input[@value='" + landingButton + "']"));
		
		// disable game
		session().open("wiki/Special:ScavengerHunt");
		session().waitForPageToLoad(this.getTimeout());
		
		index = findGamePosition(gameName);
		
		// edit and try to disable the game
		session().click("//table[contains(@class, 'scavengerhunt-list-table')]//tr[" + index + "]/td[3]/a");
		session().waitForPageToLoad(this.getTimeout());

		// "disable" button is called "enable"
		session().click("enable");
		session().waitForPageToLoad(this.getTimeout());

		assertTrue("Game hasn't been disabled", session().isTextPresent("Selected Scavenger Hunt game has been disabled."));
		
		// landing page (disabled)
		session().open((this.webSite + "/wiki/" + LANDING_PAGE.replace(" ", "_")).replace("//wiki", "/wiki"));
		session().waitForPageToLoad(this.getTimeout());
		
		assertFalse("Start button of disabled game is present", session().isElementPresent("//input[@value='" + landingButton + "']"));
		
		// enable game
		session().open("wiki/Special:ScavengerHunt");
		session().waitForPageToLoad(this.getTimeout());
		
		index = findGamePosition(gameName);
		
		// edit and try to enable the game
		session().click("//table[contains(@class, 'scavengerhunt-list-table')]//tr[" + index + "]/td[3]/a");
		session().waitForPageToLoad(this.getTimeout());
		session().click("enable");
		session().waitForPageToLoad(this.getTimeout());

		assertTrue("Valid game hasn't been enabled", session().isTextPresent("Selected Scavenger Hunt game has been enabled."));
		
		// landing page (enabled)
		session().open((this.webSite + "/wiki/" + LANDING_PAGE.replace(" ", "_")).replace("//wiki", "/wiki"));
		session().waitForPageToLoad(this.getTimeout());
		
		assertTrue("Start button of enabled game is not present", session().isElementPresent("//input[@value='" + landingButton + "']"));
		
		// play the game
		session().click("//input[@value='" + landingButton + "']");
		waitForElement("//section[@id='scavengerClueModal']");
		
		session().click("//a[@id='ScavengerHuntModalConfirmButton']");
		session().waitForPageToLoad(this.getTimeout());
		
		// url and progress bar
		assertTrue("Starting the game redirects to wrong page", session().getLocation().contains(START_PAGE.replace(" ", "_")));
		assertTrue("Progress bar is missing", session().isElementPresent("//div[@id='scavenger-hunt-progress-bar']"));
		
		// quit game
		session().click("//div[@id='scavenger-hunt-progress-bar']/div[2]");
		waitForElement("//section[@id='scavemger-hunt-quit-dialog']");
		session().click("//section[@id='scavemger-hunt-quit-dialog']//a[@id='stay']");
		waitForElementNotPresent("//section[@id='scavemger-hunt-quit-dialog']");
		session().click("//div[@id='scavenger-hunt-progress-bar']/div[2]");
		waitForElement("//section[@id='scavemger-hunt-quit-dialog']");
		session().click("//section[@id='scavemger-hunt-quit-dialog']//a[@id='quit']");
		waitForElementNotPresent("//section[@id='scavemger-hunt-quit-dialog']");
		assertFalse("Progress bar is present after quiting a game", session().isElementPresent("//div[@id='scavenger-hunt-progress-bar']"));
		
		// play the game again
		session().open((this.webSite + "/wiki/" + LANDING_PAGE.replace(" ", "_")).replace("//wiki", "/wiki"));
		session().waitForPageToLoad(this.getTimeout());
		session().click("//input[@value='" + landingButton + "']");
		waitForElement("//section[@id='scavengerClueModal']");
		
		session().click("//a[@id='ScavengerHuntModalConfirmButton']");
		session().waitForPageToLoad(this.getTimeout());
		
		// first clue
		session().click("//div[@id='scavenger-hunt-progress-bar']/div[3]");
		session().waitForPageToLoad(this.getTimeout());
		assertTrue("First clue page is incorrect", session().getLocation().contains(TARGET_PAGE_ONE.replace(" ", "_")));
		assertTrue("In game clue image is missing", session().isElementPresent("//div[@id='scavenger-ingame-image']"));
		
		session().click("//div[@id='scavenger-ingame-image']");
		waitForElementNotPresent("//div[@id='scavenger-ingame-image']");
		
		// second clue
		session().click("//div[@id='scavenger-hunt-progress-bar']/div[4]");
		session().waitForPageToLoad(this.getTimeout());
		assertTrue("First clue page is incorrect", session().getLocation().contains(TARGET_PAGE_TWO.replace(" ", "_")));
		assertTrue("In game clue image is missing", session().isElementPresent("//div[@id='scavenger-ingame-image']"));
		
		session().click("//div[@id='scavenger-ingame-image']");
		waitForElementNotPresent("//div[@id='scavenger-ingame-image']");
		
		// end game dialog
		waitForElement("//section[@id='scavengerEntryFormModal']");
		session().type("name=answer", "answer");
		session().type("name=name", "name");
		session().type("name=email", "email@example.com");
		session().focus("name=answer");
		session().keyDown("name=answer", "w");
		session().keyUp("name=answer", "w");
		session().click("//section[@id='scavengerEntryFormModal']//input[@type='submit']");
		
		waitForElementNotPresent("//section[@id='scavengerEntryFormModal']");
		waitForElement("//section[@id='scavengerGoodbyeModal']");
		
		session().click("//section[@id='scavengerGoodbyeModal']//button[contains(@class, 'close wikia-chiclet-button')]");
		waitForElementNotPresent("//section[@id='scavengerGoodbyeModal']");
	}
}