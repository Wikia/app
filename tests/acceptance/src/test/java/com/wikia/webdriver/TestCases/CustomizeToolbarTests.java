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
	
	
//	@Test(groups = {"CustomizeToolbar001"}) 
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
		article.customizeToolbar_VerifyToolOnToolbarList("PageAction:Edit");
		article.customizeToolbar_ClickOnSaveButton();
		article.customizeToolbar_VerifyToolOnToolbar("Edit");
		
	}
	
	@Test(groups = {"CustomizeToolbar002"}) 
//	https://internal.wikia-inc.com/wiki/QA/Core_Features_and_Testing/Manual_Regression_Tests/Customize_Toolbar_Adding
	public void CustomizeToolbar001_Editing()
	{
		WikiBasePageObject wiki = new WikiBasePageObject(driver, Global.DOMAIN);
		WikiArticlePageObject article = wiki.OpenArticle(wikiArticle);
		CommonFunctions.logIn(Properties.userName2, Properties.password2);
		article.customizeToolbar_ClickCustomize();
		article.customizeToolbar_ClickOnResetDefaults();
		article.customizeToolbar_TypeIntoFindATool("e");
		article.customizeToolbar_ClickOnFoundTool("Edit");
		article.customizeToolbar_VerifyToolOnToolbarList("PageAction:Edit");
		article.customizeToolbar_ClickOnToolRemoveButton("PageAction:Edit");
//		article.customizeToolbar_VerifyToolNotOnToolbarList("PageAction:Edit");
		article.customizeToolbar_ClickOnSaveButton();
		article.customizeToolbar_VerifyToolNotOnToolbar("Edit");
				
	}
}
