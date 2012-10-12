package com.wikia.webdriver.TestCases.ArticleCRUDTests;

import org.testng.annotations.Test;

import com.wikia.webdriver.Common.Core.CommonFunctions;
import com.wikia.webdriver.Common.Core.Global;
import com.wikia.webdriver.Common.Properties.Properties;
import com.wikia.webdriver.Common.Templates.TestTemplate;
import com.wikia.webdriver.PageObjects.PageObject.WikiBasePageObject;
import com.wikia.webdriver.PageObjects.PageObject.WikiPage.WikiArticleEditMode;
import com.wikia.webdriver.PageObjects.PageObject.WikiPage.WikiArticlePageObject;
import com.wikia.webdriver.PageObjects.PageObject.WikiPage.WikiArticleRevisionEditMode;
import com.wikia.webdriver.PageObjects.PageObject.WikiPage.WikiHistoryPageObject;

public class ArticleHistoryTests extends TestTemplate
{
	private String pageName;
	private String articleText = "Lorem ipsum dolor sit amet, consectetur adipiscing elit.";
	private String articleTextEdit = "Brand new content";
	
	@Test(groups={"ArticleHistoryTests_001", "ArticleCRUDAdmin"})
	public void RecoverPreviousVersion()
	{
		CommonFunctions.logOut(Properties.userName, driver);
		CommonFunctions.logIn(Properties.userNameStaff, Properties.passwordStaff);
		WikiBasePageObject wiki = new WikiBasePageObject(driver, Global.DOMAIN);
		pageName = "QAarticle"+wiki.getTimeStamp();
		wiki.openWikiPage();
		WikiArticleEditMode edit = wiki.createNewArticle(pageName, 1);
		edit.deleteArticleContent();
		edit.clickOnVisualButton();
		edit.typeInContent(articleText);
		WikiArticlePageObject article = edit.clickOnPublishButton();
		article.verifyPageTitle(pageName);
		article.verifyArticleText(articleText);
		edit = article.edit();
		edit.deleteArticleContent();
		edit.clickOnVisualButton();
		edit.typeInContent(articleTextEdit);
		article = edit.clickOnPublishButton();
		article.verifyPageTitle(pageName);
		article.verifyArticleText(articleTextEdit);
		WikiHistoryPageObject history = article.openHistoryPage();
		WikiArticleRevisionEditMode revision = history.clickUndoRevision(1);
		article = revision.clickOnPublishButton();
		article.verifyTitle(pageName);
		article.verifyArticleText(articleText);
		article.deleteArticle(pageName);
		article.openArticle(pageName);
		article.verifyDeletedArticlePage(pageName);
		CommonFunctions.logOut(Properties.userNameStaff, driver);
	}
	
	@Test(groups={"ArticleHistoryTests_002", "ArticleCRUDAdmin"})
	public void RollbackVersion()
	{
		CommonFunctions.logOut(Properties.userName, driver);
		CommonFunctions.logIn(Properties.userNameStaff, Properties.passwordStaff);
		WikiBasePageObject wiki = new WikiBasePageObject(driver, Global.DOMAIN);
		pageName = "QAarticle"+wiki.getTimeStamp();
		wiki.openWikiPage();
		WikiArticleEditMode edit = wiki.createNewArticle(pageName, 1);
		edit.deleteArticleContent();
		edit.clickOnVisualButton();
		edit.typeInContent(articleText);
		WikiArticlePageObject article = edit.clickOnPublishButton();
		article.verifyPageTitle(pageName);
		article.verifyArticleText(articleText);
		CommonFunctions.logOut(Properties.userName, driver);
		CommonFunctions.logIn(Properties.userName, Properties.password);
		article.openArticle(pageName);
		edit = article.edit();
		edit.deleteArticleContent();
		edit.clickOnVisualButton();
		edit.typeInContent(articleTextEdit);
		article = edit.clickOnPublishButton();
		article.verifyPageTitle(pageName);
		article.verifyArticleText(articleTextEdit);
		CommonFunctions.logOut(Properties.userName, driver);
		CommonFunctions.logIn(Properties.userNameStaff, Properties.passwordStaff);
		article.openArticle(pageName);
		WikiHistoryPageObject history = article.openHistoryPage();
		history.rollbackPage();
		article = history.enterPageAfterRollback();
		article.verifyTitle(pageName);
		article.verifyArticleText(articleText);
		article.deleteArticle(pageName);
		article.openArticle(pageName);
		article.verifyDeletedArticlePage(pageName);
		CommonFunctions.logOut(Properties.userNameStaff, driver);
	}
}
