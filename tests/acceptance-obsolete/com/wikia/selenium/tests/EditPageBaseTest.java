package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;
import static org.testng.AssertJUnit.assertFalse;
import static org.testng.AssertJUnit.assertEquals;
import static org.testng.AssertJUnit.assertNotNull;

import java.util.Random;

/**
 * This is a base class for Edit Page Reskin tests 
 *
 * @author macbre
 */

public class EditPageBaseTest extends BaseTest {
	/**
	 * Returns true if given rail module is expanded
	 */
	protected boolean getRailModuleState(String id) throws Exception {
		return session().isVisible("//div[@id='EditPageRail']/div[@data-id='" + id + "']/div[@class='module_content']");
	}

	/**
	 * Toggle given rail module
	 */
	protected void toggleRailModule(String id) throws Exception {
		session().click("//div[@id='EditPageRail']/div[@data-id='" + id + "']/h3");
	}

	/**
	 * Is wysiwyg the currently used mode
	 */
	protected boolean isWysiwygMode() throws Exception {
		return session().getEval("window.RTE && (window.RTE.instance || window.RTE.getInstance()).mode").equals("wysiwyg");
	}

	/**
	 * Toggle current editor's mode (using tabs)
	 */
	protected void toggleMode() throws Exception {
		boolean isWysiwyg = this.isWysiwygMode();

		session().click("//nav[@id='EditPageTabs']//span[contains(@class, '" + (isWysiwyg ? "ModeSource" : "ModeWysiwyg") +  "')]/a");
		session().waitForCondition("window.RTE && (window.RTE.instance || window.RTE.getInstance()).mode == '" + (isWysiwyg ? "source" : "wysiwyg") + "'", this.getTimeout());
	}

	/**
	 * Get captcha from given ID
	 */
	protected String resolveCaptcha(String captchaId) throws Exception {
		String captchaWord = getWordFromCaptchaId(captchaId);
		assertNotNull("No captcha word for " + captchaId, captchaWord);

		return captchaWord;
	}

	/**
	 * Returns true if second format toolbar is expanded
	 */
	protected boolean isFormatToolbarExpanded() throws Exception {
		return session().isVisible("//div[contains(@class, 'cke_toolbar_format_expanded')]");
	}

	/**
	 * Toggle given rail module
	 */
	protected void toggleFormatToolbar() throws Exception {
		String xPath = "//div[@class='cke_toolbar_expand']/a[@class='" + (this.isFormatToolbarExpanded() ? "collapse" : "expand") + "']";
		session().click(xPath);

		assertFalse(session().isVisible(xPath));
	}

	/**
	 * Returns true if wide source mode is enabled
	 */
	protected boolean isWideSourceMode() throws Exception {
		return session().isElementPresent("//section[@id='EditPage' and contains(@class,'editpage-sourcewidemode-on')]");
	}

	/**
	 * Toggle wide source mode
	 */
	protected void toggleWideSourceMode() throws Exception {
		session().click("//section[@id='EditPage']//div[contains(@class,'editpage-widemode-trigger')]");
	}

	/**
	 * Set wikitext content
	 */
	protected void setContent(String wikitext) throws Exception {
		// switch to source mode
		if (this.isWysiwygMode()) {
			this.toggleMode();
		}

		// set text in source mode
		session().runScript("window.RTE.instance.setData(\"" + wikitext.replace("\n", "\\n").replace("\"", "\\\"") + "\");");
	}

	protected void checkPreviewModal(String pageTitle, String content) throws Exception {
		this.checkPreviewModal(pageTitle, content, true);
	}
	/**
	 * Test preview functionality
	 */
	protected void checkPreviewModal(String pageTitle, String content, boolean hasPageTitle) throws Exception {
		// remove signature syntax
		content = content.replace("--~~~~", "--");

		session().click("//a[@id='wpPreview']");

		// wait for modal to show up
		waitForElement("//section[@id='EditPageDialog']");
		waitForElement("//section[@id='EditPageDialog']//div[contains(@class,'WikiaArticle')]");

		// check its content
		if (hasPageTitle) {
			assertTrue(session().getText("//section[@id='EditPageDialog']//h1[@class='pagetitle']").contains(pageTitle));
		}
		assertTrue(session().getText("//section[@id='EditPageDialog']//p").contains(content));

		// check for "Publish" button
		assertTrue(session().isElementPresent("//section[@id='EditPageDialog']//a[@id='publish']"));

		// close it
		session().click("//a[@id='close']");
		assertFalse(session().isElementPresent("//section[@id='EditPageDialog']"));
	}

	/**
	 * Test diff functionality
	 */
	protected void checkDiffModal(String pageTitle, String content) throws Exception {
		// remove signature syntax
		content = content.replace("--~~~~", "");

		// modify editable content to actually get a diff
		doEdit("foo");

		session().click("//a[@id='wpDiff']");

		// wait for modal to show up
		waitForElement("//section[@id='EditPageDialog']");
		waitForElement("//section[@id='EditPageDialog']//div[contains(@class,'WikiaArticle')]");

		// check its content
		assertTrue(session().isElementPresent("//section[@id='EditPageDialog']//h1[@class='pagetitle' and contains(text(),'" + pageTitle + "')]"));
		assertTrue(session().isElementPresent("//section[@id='EditPageDialog']//table[@class='diff']"));

		// check diff
		String diffContent = session().getText("//section[@id='EditPageDialog']//table[@class='diff']" +
				"//td[@class='diff-deletedline']/div/span");
		assertTrue(diffContent.contains(content));
		assertTrue(diffContent.contains("QATests") || diffContent.contains("Wikia"));
		assertTrue(session().isElementPresent("//section[@id='EditPageDialog']//table[@class='diff']" +
			"//td[@class='diff-addedline']/div/span[text()='foo']"));

		// close it
		session().click("//section[@id='EditPageDialog']/button[contains(@class, 'close')]");
		assertFalse(session().isElementPresent("//section[@id='EditPageDialog']"));
	}

	/**
	 * Test captcha (shown to anon user when adding external link)
	 *
	 * TODO: https://wikia.fogbugz.com/default.asp?4261
	 */
	protected void checkCaptcha() throws Exception {
		// trigger the captcha by trying to add an external link
		String externalLink = "http://foo" + Integer.toString(new Random().nextInt(42)) + ".net";

		// try to save the page
		doEdit(externalLink);
		clickAndWait("wpSave");

		// captcha modal
		waitForElement("//section[@id='HiddenFieldsDialog']//img[contains(@src,'Captcha')]");
		assertTrue(session().isVisible("//section[@id='HiddenFieldsDialog']//img[contains(@src,'Captcha')]"));
		assertTrue(session().isElementPresent("//section[@id='HiddenFieldsDialog']//input[@name='wpCaptchaId']"));
		assertTrue(session().isVisible("//section[@id='HiddenFieldsDialog']//input[@name='wpCaptchaWord']"));

		// resolve captcha (type word with a typo)
		session().type("wpCaptchaWord", this.resolveCaptcha(session().getValue("wpCaptchaId")) + "foo");

		// (try to) save the page (click "Publish" button at the bottom of captcha modal)
		clickAndWait("//section[@id='HiddenFieldsDialog']//*[@id='ok']");

		// captcha modal
		assertTrue(session().isElementPresent("//section[@id='EditPage']"));

		// resolve captcha
		// may fail (see BugId:4261)
		session().type("wpCaptchaWord", this.resolveCaptcha(session().getValue("wpCaptchaId")));

		// save the page (click "Publish" button at the bottom of captcha modal)
		clickAndWait("//section[@id='HiddenFieldsDialog']//*[@id='ok']");

		// link should be added to the page
		assertTrue(session().isTextPresent(externalLink));
	}
}
