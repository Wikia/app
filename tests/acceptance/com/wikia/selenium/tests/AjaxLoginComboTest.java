package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;

import org.testng.annotations.Test;
import static org.testng.AssertJUnit.assertTrue;

/**
 * NOTE: This test assumes that the wiki is editable (eg: wgDisableAnonEditing = false)
 * but that the use has to log in to add a picture.
 */
public class AjaxLoginComboTest extends BaseTest {

	@Test(groups={"oasis", "CI"})
	public void testEnsureThatAnonymousUserCanEditArticlesButCanNotUploadPhotos() throws Exception {
		session().open("index.php?title=comboPlaceholder&action=edit&useeditor=mediawiki");
		session().type("wpTextbox1", "[[image:placeholder]]");
		session().click("wpSave");
		session().waitForPageToLoad(TIMEOUT);

		session().click("//a[@class='ajaxLogin']");
		waitForElement("AjaxLoginButtons");
		closeAjaxPopup();

		session().click("WikiaImagePlaceholderInner0");
		waitForElement("AjaxLoginButtons");
		session().click("wpGoLogin");
		session().type("wpName2Ajax", getTestConfig().getString("ci.user.wikiabot.username"));
		session().type("wpPassword2Ajax", getTestConfig().getString("ci.user.wikiabot.password"));
		session().click("wpLoginattempt");
	    session().waitForPageToLoad(TIMEOUT);
		waitForWikiabotLoggedIn();

		assertTrue(session().isElementPresent("ImageUpload"));
	}

	@Test(groups={"oasis", "RTE", "CI"})
	public void testEnsureThatAnonymousUserCanNotInsertPhotosUsingRTE() throws Exception {
		session().open("index.php?title=combotext&action=edit&useeditor=mediawiki");
		waitForElement("mw-editbutton-wmu");
		session().click("mw-editbutton-wmu");
		waitForElement("AjaxLoginButtons");
		closeAjaxPopup();

		session().click("//a[@class='ajaxLogin']");
		waitForElement("AjaxLoginButtons");
		closeAjaxPopup();

		session().type("wpTextbox1", "Test Text wikieditor");
		session().click("mw-editbutton-vet");
		waitForElement("AjaxLoginButtons");

		session().click("wpGoLogin");
		session().type("wpName2Ajax", getTestConfig().getString("ci.user.wikiabot.username"));
		session().type("wpPassword2Ajax", getTestConfig().getString("ci.user.wikiabot.password"));
		session().click("wpLoginattempt");
	    session().waitForPageToLoad(TIMEOUT);

		waitForWikiabotLoggedIn();
		session().click("wpPreview");
	    session().waitForPageToLoad(TIMEOUT);
		waitForWikiabotLoggedIn();

		session().isTextPresent("Test Text wikieditor");
	}

	private void closeAjaxPopup() throws Exception{
		if(isOasis()){
			session().click("//section[@id='AjaxLoginBoxWrapper']/button[contains(@class, 'close')]");
		} else {
			session().click("//div[@id='AjaxLoginBoxWrapper']/h1/img");
		}
	}

	private void waitForWikiabotLoggedIn() throws Exception {
		if(isOasis()) {
			waitForElement("//ul[@id='AccountNavigation']/li/a[contains(., '" + getTestConfig().getString("ci.user.wikiabot.username") + "')]");
		} else {
			waitForElement("//span[@id=\"header_username\"]/a[text() = \"" + getTestConfig().getString("ci.user.wikiabot.username") + "\"]");
		}
	}
}
