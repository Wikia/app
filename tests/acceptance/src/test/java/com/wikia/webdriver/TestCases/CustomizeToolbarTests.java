package com.wikia.webdriver.TestCases;

import org.testng.annotations.Test;

import com.wikia.webdriver.Common.Core.CommonFunctions;
import com.wikia.webdriver.Common.Core.Global;
import com.wikia.webdriver.Common.Properties.Properties;
import com.wikia.webdriver.Common.Templates.TestTemplate;
import com.wikia.webdriver.PageObjects.PageObject.WikiBasePageObject;
import com.wikia.webdriver.PageObjects.PageObject.WikiPage.WikiArticlePageObject;

public class CustomizeToolbarTests extends TestTemplate{
	private String wikiArticle = "QAautoPage";
	
	@Test(groups = {"CustomizeToolbar001", "Toolbar"}) 
//	https://internal.wikia-inc.com/wiki/QA/Core_Features_and_Testing/Manual_Regression_Tests/Customize_Toolbar_Adding
	public void CustomizeToolbar001_Adding()
	{
		WikiBasePageObject wiki = new WikiBasePageObject(driver, Global.DOMAIN);
		WikiArticlePageObject article = wiki.OpenArticle(wikiArticle);
		CommonFunctions.logIn(Properties.userName2, Properties.password2);
		article.executeScript("$('div#WikiaBarWrapper').attr('class', 'WikiaBarWrapper')");
		article.customizeToolbar_ClickCustomize();
		article.customizeToolbar_ClickOnResetDefaults();
		article.customizeToolbar_TypeIntoFindATool("e");
		article.customizeToolbar_ClickOnFoundTool("Edit");
		article.customizeToolbar_VerifyToolOnToolbarList("Edit");
		article.customizeToolbar_ClickOnSaveButton();
		article.customizeToolbar_VerifyToolOnToolbar("Edit");
		
	}
	
	@Test(groups = {"CustomizeToolbar002", "Toolbar"}) 
//	https://internal.wikia-inc.com/wiki/QA/Core_Features_and_Testing/Manual_Regression_Tests/Customize_Toolbar_Editing
	public void CustomizeToolbar002_Editing()
	{
		WikiBasePageObject wiki = new WikiBasePageObject(driver, Global.DOMAIN);
		WikiArticlePageObject article = wiki.OpenArticle(wikiArticle);
		CommonFunctions.logIn(Properties.userName2, Properties.password2);
		article.executeScript("$('div#WikiaBarWrapper').attr('class', 'WikiaBarWrapper')");
		article.customizeToolbar_ClickCustomize();
		article.customizeToolbar_ClickOnResetDefaults();
		article.customizeToolbar_TypeIntoFindATool("e");
		article.customizeToolbar_ClickOnFoundTool("Edit");
		article.customizeToolbar_VerifyToolOnToolbarList("Edit");
		article.customizeToolbar_ClickOnToolRenameButton("Edit");
		article.customizeToolbar_TypeIntoRenameItemDialog("Edit123");
		article.customizeToolbar_saveInRenameItemDialog();
		article.customizeToolbar_VerifyToolOnToolbarList("Edit123");
		article.customizeToolbar_ClickOnSaveButton();
		article.customizeToolbar_VerifyToolOnToolbar("Edit123");
				
	}
	
//	@Test(groups = {"CustomizeToolbar003"}) 
////	https://internal.wikia-inc.com/wiki/QA/Core_Features_and_Testing/Manual_Regression_Tests/Customize_Toolbar_Moving
//	public void CustomizeToolbar003_Moving()
//	{
//		WikiBasePageObject wiki = new WikiBasePageObject(driver, Global.DOMAIN);
//		WikiArticlePageObject article = wiki.OpenArticle(wikiArticle);
//		CommonFunctions.logIn(Properties.userName2, Properties.password2);
//		article.customizeToolbar_ClickCustomize();
//		article.customizeToolbar_ClickOnResetDefaults();
//		article.customizeToolbar_ClickOnSaveButton();
//		article.customizeToolbar_VerifyMyToolsOrder("History", "What links here");
//		article.customizeToolbar_ClickCustomize();
//		article.customizeToolbar_DragElemAndDrop("History", 1);
//		article.customizeToolbar_ClickOnSaveButton();
//		article.customizeToolbar_VerifyMyToolsOrder("What links here", "History");
//		CommonFunctions.MoveCursorTo(0, 0);		
//	}
	
	@Test(groups = {"CustomizeToolbar004", "Toolbar"}) 
//	https://internal.wikia-inc.com/wiki/QA/Core_Features_and_Testing/Manual_Regression_Tests/Customize_Toolbar_Deleting
	public void CustomizeToolbar004_Deleteing()
	{
		WikiBasePageObject wiki = new WikiBasePageObject(driver, Global.DOMAIN);
		WikiArticlePageObject article = wiki.OpenArticle(wikiArticle);
		CommonFunctions.logIn(Properties.userName2, Properties.password2);
		article.executeScript("$('div#WikiaBarWrapper').attr('class', 'WikiaBarWrapper')");
		article.customizeToolbar_ClickCustomize();
		article.customizeToolbar_ClickOnResetDefaults();
		article.customizeToolbar_TypeIntoFindATool("e");
		article.customizeToolbar_ClickOnFoundTool("Edit");
		article.customizeToolbar_VerifyToolOnToolbarList("Edit");
		article.customizeToolbar_ClickOnToolRemoveButton("Edit");
//		article.customizeToolbar_VerifyToolNotOnToolbarList("Edit");
		article.customizeToolbar_ClickOnSaveButton();
		article.customizeToolbar_VerifyToolNotOnToolbar("Edit");
	}
	
	@Test(groups = {"CustomizeToolbar005", "Toolbar"}) 
//	https://internal.wikia-inc.com/wiki/QA/Core_Features_and_Testing/Manual_Regression_Tests/Customize_Toolbar_Finding
	public void CustomizeToolbar005_Finding()
	{
		WikiBasePageObject wiki = new WikiBasePageObject(driver, Global.DOMAIN);
		WikiArticlePageObject article = wiki.OpenArticle(wikiArticle);
		CommonFunctions.logIn(Properties.userName2, Properties.password2);
		article.executeScript("$('div#WikiaBarWrapper').attr('class', 'WikiaBarWrapper')");
		article.customizeToolbar_ClickCustomize();
		article.customizeToolbar_ClickOnResetDefaults();
		article.customizeToolbar_TypeIntoFindATool("Up");
		article.customizeToolbar_ClickOnFoundTool("Upload photo");
		article.customizeToolbar_VerifyToolOnToolbarList("Upload photo");
		article.customizeToolbar_ClickOnSaveButton();
		article.customizeToolbar_VerifyToolOnToolbar("Upload photo");
	}
	
	@Test(groups = {"CustomizeToolbar006", "Toolbar"}) 
//	https://internal.wikia-inc.com/wiki/QA/Core_Features_and_Testing/Manual_Regression_Tests/Customize_Toolbar_Reset_Defaults
	public void CustomizeToolbar006_ResetDefaults()
	{
		WikiBasePageObject wiki = new WikiBasePageObject(driver, Global.DOMAIN);
		WikiArticlePageObject article = wiki.OpenArticle(wikiArticle);
		CommonFunctions.logIn(Properties.userName2, Properties.password2);
		article.executeScript("$('div#WikiaBarWrapper').attr('class', 'WikiaBarWrapper')");
		article.customizeToolbar_ClickCustomize();
		article.customizeToolbar_ClickOnResetDefaults();
		article.customizeToolbar_TypeIntoFindATool("Up");
		article.customizeToolbar_ClickOnFoundTool("Upload photo");
		article.customizeToolbar_VerifyToolOnToolbarList("Upload photo");
		article.customizeToolbar_ClickOnSaveButton();
		article.customizeToolbar_VerifyToolOnToolbar("Upload photo");
		article.customizeToolbar_ClickCustomize();
		article.customizeToolbar_ClickOnResetDefaults();
//		article.customizeToolbar_VerifyToolNotOnToolbarList("Upload photo");
		article.customizeToolbar_ClickOnSaveButton();
		article.customizeToolbar_VerifyToolNotOnToolbar("Upload photo");
	}
	
	@Test(groups = {"CustomizeToolbar007", "Toolbar"}) 
//	https://internal.wikia-inc.com/wiki/QA/Core_Features_and_Testing/Manual_Regression_Tests/Customize_Toolbar_Buttons_actions
	public void CustomizeToolbar007_ButtonsActions()
	{
		WikiBasePageObject wiki = new WikiBasePageObject(driver, Global.DOMAIN);
		WikiArticlePageObject article = wiki.OpenArticle(wikiArticle);
		CommonFunctions.logIn(Properties.userName2, Properties.password2);
		article.executeScript("$('div#WikiaBarWrapper').attr('class', 'WikiaBarWrapper')");
		article.customizeToolbar_UnfollowIfPageIsFollowed();
		article.customizeToolbar_VerifyToolOnToolbar("Follow");
		article.customizeToolbar_ClickOnTool("follow");
		article.customizeToolbar_VerifyPageWatchlistStatusMessage();
		article.customizeToolbar_VerifyPageFollowed();
		article.customizeToolbar_VerifyToolOnToolbar("Following");
		article.customizeToolbar_ClickOnTool("follow");
		article.customizeToolbar_VerifyPageWatchlistStatusMessage();
		article.customizeToolbar_VerifyPageUnfollowed();
		article.customizeToolbar_VerifyToolOnToolbar("Follow");
		article.customizeToolbar_ClickCustomize();
		article.customizeToolbar_ClickOnResetDefaults();
		article.customizeToolbar_ClickOnSaveButton();
	}
	
}
