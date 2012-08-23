package com.wikia.webdriver.TestCases;

import org.testng.annotations.Test;

import com.wikia.webdriver.Common.Templates.TestTemplate;
import com.wikia.webdriver.pageObjects.PageObject.CreateNewWiki.CreateNewWikiLogInPageObject;
import com.wikia.webdriver.pageObjects.PageObject.CreateNewWiki.CreateNewWikiPageObjectStep1;

public class TestCaseTemplate extends TestTemplate
{
	
	@Test
	public void TestCaseTemplate_001()
	{
		
		CreateNewWikiPageObjectStep1 newWikiPage = new CreateNewWikiPageObjectStep1(driver);
		newWikiPage.openCreateNewWikiPage();
		newWikiPage.typeInWikiName("new_wiki_name");
		newWikiPage.typeInWikiDomain("new_wiki_domain");
		newWikiPage.waitForSuccessIcon();
		CreateNewWikiLogInPageObject newWikiPageLogIn = newWikiPage.submitToLogIn();
	}
}