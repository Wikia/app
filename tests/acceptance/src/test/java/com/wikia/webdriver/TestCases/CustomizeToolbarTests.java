package com.wikia.webdriver.TestCases;

import org.testng.annotations.Test;

import com.wikia.webdriver.Common.Core.CommonFunctions;
import com.wikia.webdriver.Common.Core.Global;
import com.wikia.webdriver.Common.Properties.Properties;
import com.wikia.webdriver.Common.Templates.TestTemplate;
import com.wikia.webdriver.pageObjects.PageObject.WikiBasePageObject;
import com.wikia.webdriver.pageObjects.PageObject.WikiPage.SpecialUploadPageObject;
import com.wikia.webdriver.pageObjects.PageObject.WikiPage.WikiArticlePageObject;

public class CustomizeToolbarTests extends TestTemplate{

	private String file = "Image001.jpg";
	private String[] ListOfFiles = {"Image001.jpg","Image002.jpg", "Image003.jpg", "Image004.jpg", "Image005.jpg", "Image006.jpg", "Image007.jpg", "Image008.jpg", "Image009.jpg", "Image010.jpg"};
	private String wikiArticle = "QAautoPage";
	private String Caption = "QAcaption1";
	private String Caption2 = "QAcaption2";
	private String videoURL = "http://www.youtube.com/watch?v=pZB6Dg1RJ_o";
	private String videoURL2 = "http://www.youtube.com/watch?v=TTchckhECwE";
	private String videoURL2name = "What is love (?) - on piano (Haddway)";
	
	
	@Test(groups = {"CustomizeToolbar001"}) 
//	https://internal.wikia-inc.com/wiki/QA/Core_Features_and_Testing/Manual_Regression_Tests/Customize_Toolbar_Adding
	public void CustomizeToolbar001_Adding()
	{
		WikiBasePageObject wiki = new WikiBasePageObject(driver, Global.DOMAIN);
		WikiArticlePageObject article = wiki.OpenArticle(wikiArticle);
		CommonFunctions.logIn(Properties.userName2, Properties.password2);
		article.customizeToolbar_ClickCustomize();
		article.customizeToolbar_ClickOnResetDefaults();
		article.customizeToolbar_TypeIntoFindATool("e");
		article.customizeToolbar_ClickOnFoundTool("Edit");
		article.customizeToolbar_VerifyToolOnToolbarList("Edit");
		article.customizeToolbar_ClickOnSaveButton();
		article.customizeToolbar_VerifyToolOnToolbar("Edit");
		
	}
	
	@Test(groups = {"CustomizeToolbar002"}) 
//	https://internal.wikia-inc.com/wiki/QA/Core_Features_and_Testing/Manual_Regression_Tests/Customize_Toolbar_Editing
	public void CustomizeToolbar002_Editing()
	{
		WikiBasePageObject wiki = new WikiBasePageObject(driver, Global.DOMAIN);
		WikiArticlePageObject article = wiki.OpenArticle(wikiArticle);
		CommonFunctions.logIn(Properties.userName2, Properties.password2);
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
//	https://internal.wikia-inc.com/wiki/QA/Core_Features_and_Testing/Manual_Regression_Tests/Customize_Toolbar_Moving
	public void CustomizeToolbar003_Moving()
	{
		WikiBasePageObject wiki = new WikiBasePageObject(driver, Global.DOMAIN);
		WikiArticlePageObject article = wiki.OpenArticle(wikiArticle);
		CommonFunctions.logIn(Properties.userName2, Properties.password2);
		article.customizeToolbar_ClickCustomize();
		article.customizeToolbar_ClickOnResetDefaults();
		
		
	}
	
	@Test(groups = {"CustomizeToolbar004"}) 
//	https://internal.wikia-inc.com/wiki/QA/Core_Features_and_Testing/Manual_Regression_Tests/Customize_Toolbar_Deleting
	public void CustomizeToolbar004_Deleteing()
	{
		WikiBasePageObject wiki = new WikiBasePageObject(driver, Global.DOMAIN);
		WikiArticlePageObject article = wiki.OpenArticle(wikiArticle);
		CommonFunctions.logIn(Properties.userName2, Properties.password2);
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
	
	@Test(groups = {"CustomizeToolbar005"}) 
//	https://internal.wikia-inc.com/wiki/QA/Core_Features_and_Testing/Manual_Regression_Tests/Customize_Toolbar_Finding
	public void CustomizeToolbar005_Finding()
	{
		WikiBasePageObject wiki = new WikiBasePageObject(driver, Global.DOMAIN);
		WikiArticlePageObject article = wiki.OpenArticle(wikiArticle);
		CommonFunctions.logIn(Properties.userName2, Properties.password2);
		article.customizeToolbar_ClickCustomize();
		article.customizeToolbar_ClickOnResetDefaults();
		article.customizeToolbar_TypeIntoFindATool("Up");
		article.customizeToolbar_ClickOnFoundTool("Upload photo");
		article.customizeToolbar_VerifyToolOnToolbarList("Upload photo");
		article.customizeToolbar_ClickOnSaveButton();
		article.customizeToolbar_VerifyToolOnToolbar("Upload photo");
	}
	
	@Test(groups = {"CustomizeToolbar006"}) 
//	https://internal.wikia-inc.com/wiki/QA/Core_Features_and_Testing/Manual_Regression_Tests/Customize_Toolbar_Reset_Defaults
	public void CustomizeToolbar006_ResetDefaults()
	{
		WikiBasePageObject wiki = new WikiBasePageObject(driver, Global.DOMAIN);
		WikiArticlePageObject article = wiki.OpenArticle(wikiArticle);
		CommonFunctions.logIn(Properties.userName2, Properties.password2);
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
	
	@Test(groups = {"CustomizeToolbar007"}) 
//	https://internal.wikia-inc.com/wiki/QA/Core_Features_and_Testing/Manual_Regression_Tests/Customize_Toolbar_Buttons_actions
	public void CustomizeToolbar007_ButtonsActions()
	{
		WikiBasePageObject wiki = new WikiBasePageObject(driver, Global.DOMAIN);
		WikiArticlePageObject article = wiki.OpenArticle(wikiArticle);
		CommonFunctions.logIn(Properties.userName2, Properties.password2);
		article.customizeToolbar_ClickCustomize();
		article.customizeToolbar_ClickOnResetDefaults();
		article.customizeToolbar_TypeIntoFindATool("Fo");
		article.customizeToolbar_ClickOnFoundTool("Follow");
		article.customizeToolbar_VerifyToolOnToolbarList("Follow");
		article.customizeToolbar_ClickOnSaveButton();
		article.customizeToolbar_VerifyToolOnToolbar("Follow");
		article.customizeToolbar_ClickOnTool("follow");
		article.customizeToolbar_VerifyToolOnToolbar("Following");
		article.customizeToolbar_ClickOnTool("follow");
		article.customizeToolbar_VerifyToolOnToolbar("Follow");
		
	}
	
}
