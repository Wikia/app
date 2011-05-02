package com.wikia.selenium.tests.EditPageReskin;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;
import static org.testng.AssertJUnit.assertFalse;
import static org.testng.AssertJUnit.assertEquals;
import static org.testng.AssertJUnit.assertNotNull;

import org.testng.SkipException;

import org.testng.annotations.Test;

public class EditPageLayoutTest extends EditPageBaseTest {

	private static final String articleName = "EditPageLayoutTest";

	/**
	 * Prepare an article to edit
	 */
	@Test(groups={"oasis", "CI"})
	public void prepareEditPage() throws Exception {
		loginAsRegular();

		editArticle(this.articleName, "Test --~~~~");
	}

	/**
	 * Open an edit page (log in as WikiaUser by default)
	 */
	private void openEditPage() throws Exception {
		this.openEditPage(true /* logIn */);
	}

	private void openEditPage(boolean logIn) throws Exception {
		if (logIn) {
			loginAsRegular();
		}

		session().open("index.php?action=edit&useeditor=wysiwyg&title=" + this.articleName);
		session().waitForPageToLoad(this.getTimeout());

		// check if edit page is read-only
		if (session().getEval("window.wgEditPageIsReadOnly").equals("true")) {
			throw new SkipException("Edit page is read-only");
		}
	}

	@Test(groups={"oasis", "CI"},dependsOnMethods={"prepareEditPage"})
	public void testEditPageLayout() throws Exception {
		this.openEditPage();

		assertTrue(session().isElementPresent("//form[@id='editform']"));
		assertTrue(session().isElementPresent("//*[@id='cke_wpTextbox1']"));

		assertTrue(session().isElementPresent("//span[contains(@class,'wordmark')]"));
		assertTrue(session().isElementPresent("//header[@id='EditPageHeader']//h1[contains(text(), 'Editing')]"));
		assertTrue(session().isElementPresent("//header[@id='EditPageHeader']//h1/a[contains(text(), '" + this.articleName + "')]"));

		// JS code
		assertEquals(session().getEval("window.wgIsEditPage"), "true");
		assertEquals(session().getEval("window.$.msg('editpagelayout-less')"), "less");

		// some elements should not be visible on edit page
		assertFalse(session().isElementPresent("//header[@id='WikiHeader']/nav"));
		assertFalse(session().isElementPresent("//header[@id='WikiHeader']/div[@class='buttons']"));
		assertFalse(session().isElementPresent("//div[@id='WikiaRail']"));
		assertFalse(session().isElementPresent("//footer[@id='WikiaFooter']"));

		// spaces
		assertTrue(session().isElementPresent("//div[@id='EditPageToolbar']"));
		assertTrue(session().isElementPresent("//div[@id='EditPageRail']"));
		assertTrue(session().isElementPresent("//div[@id='EditPageEditorWrapper']"));
		assertTrue(session().isElementPresent("//nav[@id='EditPageTabs']"));

		// tabs
		assertTrue(session().isElementPresent("//nav[@id='EditPageTabs']//span[contains(@class, 'cke_button_ModeSource')]"));
		assertTrue(session().isElementPresent("//nav[@id='EditPageTabs']//span[contains(@class, 'cke_button_ModeWysiwyg')]"));

		// help link
		assertTrue(session().isElementPresent("//aside[@id='HelpLink']/a[contains(@href, 'Help:Editing')]"));

		// toolbars
		assertTrue(session().isElementPresent("//div[@id='EditPageToolbar']/div[contains(@class, 'cke_toolbar_source')]"));
		assertTrue(session().isElementPresent("//div[@id='EditPageToolbar']/div[contains(@class, 'cke_toolbar_format')]"));
		assertTrue(session().isElementPresent("//div[@id='EditPageToolbar']/div[contains(@class, 'cke_toolbar_format_expanded')]"));
		assertTrue(session().isElementPresent("//div[@id='EditPageToolbar']/div[contains(@class, 'cke_toolbar_expand')]"));

		// toolbar buttons
		assertTrue(session().isElementPresent("//div[@id='EditPageToolbar']/div[contains(@class, 'cke_buttons')]"));
		assertTrue(session().isElementPresent("//div[@id='EditPageToolbar']//span[contains(@class, 'cke_button_bold')]"));

		// right rail modules
		assertTrue(session().isElementPresent("//div[@id='EditPageRail']/div[contains(@class, 'module_page_controls')]"));
		assertTrue(session().isElementPresent("//div[@id='EditPageRail']/div[contains(@class, 'module_insert')]"));
		assertTrue(session().isElementPresent("//div[@id='EditPageRail']/div[contains(@class, 'module_categories')]"));
		assertTrue(session().isElementPresent("//div[@id='EditPageRail']/div[contains(@class, 'module_templates')]"));
		assertTrue(session().isElementPresent("//div[@id='EditPageRail']/div[contains(@class, 'module_license')]"));

		// page controls
		assertTrue(session().isElementPresent("//div[@id='EditPageRail']/div[contains(@class, 'module_page_controls')]//textarea[@id='wpSummary']"));
		assertTrue(session().isElementPresent("//div[@id='EditPageRail']/div[contains(@class, 'module_page_controls')]//input[@name='wpMinoredit']"));
		assertTrue(session().isElementPresent("//div[@id='EditPageRail']/div[contains(@class, 'module_page_controls')]//input[@id='wpSave']"));
		assertTrue(session().isElementPresent("//div[@id='EditPageRail']/div[contains(@class, 'module_page_controls')]//ul//a[@id='wpPreview']"));
		assertTrue(session().isElementPresent("//div[@id='EditPageRail']/div[contains(@class, 'module_page_controls')]//ul//a[@id='wpDiff']"));

		// hidden form fields
		assertTrue(session().isElementPresent("//form[@id='editform']//input[@name='wpWatchthis' and @type='hidden']"));
	}

	@Test(groups={"oasis", "CI"},dependsOnMethods={"prepareEditPage"})
	public void testCollapsibleModulesState() throws Exception {
		this.openEditPage();

		// get current state of "Add features and media" module
		boolean addFeaturesModuleState = this.getRailModuleState("insert");

		// click on the module
		this.toggleRailModule("insert");

		// compare current state with the previous one
		assertFalse(this.getRailModuleState("insert") == addFeaturesModuleState);

		// reload the edit page
		reload();

		// compare current state with the previous one (should be maintained)
		assertFalse(this.getRailModuleState("insert") == addFeaturesModuleState);

		// click on the module
		this.toggleRailModule("insert");

		// compare current state with the previous one (should be maintained)
		assertTrue(this.getRailModuleState("insert") == addFeaturesModuleState);
	}

	@Test(groups={"oasis", "CI"},dependsOnMethods={"prepareEditPage"})
	public void testModesSwitchAndToolbars() throws Exception {
		this.openEditPage();

		boolean isWysiwyg = this.isWysiwygMode();

		// switch mode
		this.toggleMode();
		assertFalse(this.isWysiwygMode() == isWysiwyg);

		// switch mode
		this.toggleMode();
		assertTrue(this.isWysiwygMode() == isWysiwyg);

		// test source mode toolbar
		if (this.isWysiwygMode()) {
			this.toggleMode();
		}

		assertTrue(session().isVisible("//div[@id='EditPageToolbar']/div[contains(@class, 'cke_toolbar_source')]/img[@id='mw-editbutton-bold']"));
		assertFalse(session().isVisible("//div[@id='EditPageToolbar']/div[contains(@class, 'cke_toolbar_format')]"));

		this.toggleMode();

		assertFalse(session().isVisible("//div[@id='EditPageToolbar']/div[contains(@class, 'cke_toolbar_source')]/img[@id='mw-editbutton-bold']"));
		assertTrue(session().isVisible("//div[@id='EditPageToolbar']/div[contains(@class, 'cke_toolbar_format')]"));
	}

	@Test(groups={"oasis", "CI"},dependsOnMethods={"prepareEditPage"})
	public void testToolbarExpand() throws Exception {
		this.openEditPage();

		boolean isExpanded = this.isFormatToolbarExpanded();

		// toggle it
		this.toggleFormatToolbar();
		assertFalse(this.isFormatToolbarExpanded() == isExpanded);

		this.toggleFormatToolbar();
		assertTrue(this.isFormatToolbarExpanded() == isExpanded);
	}

	@Test(groups={"oasis", "CI"},dependsOnMethods={"prepareEditPage"})
	public void testPreviewAndDiff() throws Exception {
		this.openEditPage();

		this.checkPreviewModal(this.articleName, "Test --~~~~");
		this.checkDiffModal(this.articleName, "Test --~~~~");
	}

	@Test(groups={"oasis", "CI"},dependsOnMethods={"prepareEditPage"})
	public void testUndoRevision() throws Exception {
		loginAsRegular();

		// go to page history
		session().open("index.php?action=history&title=" + this.articleName);
		session().waitForPageToLoad(this.getTimeout());

		// click the first "undo" link
		clickAndWait("//ul[@id='pagehistory']/li/span[@class='mw-history-undo']/a");

		// page should have vertical scroll
		assertTrue(session().isElementPresent("//body[contains(@class, 'EditPageScrollable')]"));

		// notice bar
		assertTrue(session().isElementPresent("//section[@id='EditPage']//div[@class='editpage-notices']/ul/li"));
		assertFalse(session().isVisible("//section[@id='EditPage']//div[@class='editpage-notices-html']/div[@class='mw-undo-success']"));

		// dismiss notice(s)
		session().click("//section[@id='EditPage']//div[@class='editpage-notices']/span[contains(@class, 'close')]");
		assertFalse(session().isVisible("//section[@id='EditPage']//div[@class='editpage-notices']"));

		// diff
		assertTrue(session().isElementPresent("//section[@id='EditPage']//div[@id='diff']//table[@class='diff']"));
	}

	@Test(groups={"oasis", "CI"},dependsOnMethods={"prepareEditPage"})
	public void testConflict() throws Exception {
		// use anon "account" to trigger edit conflict
		this.openEditPage(false /* logIn */);

		// trigger conflict by changing hidden timestamp fields
		session().type("wpStarttime", "");
		session().type("wpEdittime", "");

		// try to save the page
		clickAndWait("wpSave");

		// JS should tell us it's a conflict
		assertEquals(session().getEval("window.wgEditPageIsConflict"), "true");

		// page should have vertical scroll
		assertTrue(session().isElementPresent("//body[contains(@class, 'EditPageScrollable')]"));

		// notice bar
		assertTrue(session().isElementPresent("//section[@id='EditPage']//div[@class='editpage-notices']/ul/li"));
		assertFalse(session().isVisible("//section[@id='EditPage']//div[@class='editpage-notices-html']/div[@class='mw-explainconflict']"));

		// dismiss notice(s)
		session().click("//section[@id='EditPage']//div[@class='editpage-notices']/span[contains(@class, 'close')]");
		assertFalse(session().isVisible("//section[@id='EditPage']//div[@class='editpage-notices']"));

		// diff
		assertTrue(session().isElementPresent("//section[@id='EditPage']//div[@id='diff']//table[@class='diff']"));

		// my edit
		assertTrue(session().isElementPresent("//section[@id='EditPage']//div[@id='myedit']/textarea[@id='wpTextbox2']"));
	}

	@Test(groups={"oasis", "CI"},dependsOnMethods={"prepareEditPage"})
	public void testAnonEditingWithCaptcha() throws Exception {
		this.openEditPage(false /* logIn */);

		this.checkCaptcha();
	}

	@Test(groups={"oasis", "CI"})
	public void testSourceMode() throws Exception {
		this.openEditPage(false /* logIn */);

		// switch to source mode
		if (this.isWysiwygMode()) {
			this.toggleMode();
		}

		// source mode toolbar
		assertTrue(session().isVisible("//section[@id='EditPage']//div[@class='cke_toolbar_source']"));

		// interact with source mode toolbar
		this.setContent("");
		session().runScript("window.RTE.instance.focus()");
		session().click("//img[@id='mw-editbutton-link']");
		assertEquals("[[Link title]]", session().getEval("window.RTE.instance.getData()"));

		// widescreen toggle
		boolean wideSourceModeState = this.isWideSourceMode();

		this.toggleWideSourceMode();
		assertFalse(wideSourceModeState == this.isWideSourceMode());

		// reload edit page and switch to source mode
		reload();
		if (this.isWysiwygMode()) {
			this.toggleMode();
		}

		// widescreen state should be maintained
		assertFalse(wideSourceModeState == this.isWideSourceMode());

		this.toggleWideSourceMode();
		assertTrue(wideSourceModeState == this.isWideSourceMode());

		// check widescreen mode
		if (!this.isWideSourceMode()) {
			this.toggleWideSourceMode();
		}

		// "Insert" module should be hidden
		assertFalse(session().isVisible("//div[@id='EditPageRail']//div[contains(@class,'module_insert')]"));
		this.toggleWideSourceMode();
		assertTrue(session().isVisible("//div[@id='EditPageRail']//div[contains(@class,'module_insert')]"));
	}

	@Test(groups={"oasis", "CI"})
	public void testTalkPage() throws Exception {
		loginAsRegular();

		session().open("index.php?action=edit&useeditor=wysiwyg&title=Talk:" + this.articleName);
		session().waitForPageToLoad(this.getTimeout());

		boolean isExpanded = this.isFormatToolbarExpanded();

		// format toolbar should be initially expanded on talk pages
		assertTrue(isExpanded);

		// toggle it
		this.toggleFormatToolbar();
		assertFalse(this.isFormatToolbarExpanded() == isExpanded);

		this.toggleFormatToolbar();
		assertTrue(this.isFormatToolbarExpanded() == isExpanded);

		// edit it
		session().runScript("window.RTE.instance.setData('talk page test')");
		session().runScript("window.RTE.instance.focus()");
		session().click("//a[contains(@class,'cke_button_signature')]");

		clickAndWait("wpSave");

		assertTrue(session().isTextPresent("talk page test"));
		assertTrue(session().isTextPresent("WikiaUser"));
	}
}
