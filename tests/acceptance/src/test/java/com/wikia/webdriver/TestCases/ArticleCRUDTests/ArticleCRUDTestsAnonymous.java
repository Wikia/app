package com.wikia.webdriver.TestCases.ArticleCRUDTests;

import org.testng.annotations.DataProvider;
import org.testng.annotations.Test;

import com.wikia.webdriver.Common.Core.CommonFunctions;
import com.wikia.webdriver.Common.Core.Global;
import com.wikia.webdriver.Common.Properties.Properties;
import com.wikia.webdriver.Common.Templates.TestTemplate;
import com.wikia.webdriver.PageObjects.PageObject.WikiBasePageObject;
import com.wikia.webdriver.PageObjects.PageObject.WikiPage.WikiArticleEditMode;
import com.wikia.webdriver.PageObjects.PageObject.WikiPage.WikiArticlePageObject;

public class ArticleCRUDTestsAnonymous extends TestTemplate{
	
	private String pageName;
	private String articleText = "Lorem ipsum dolor sit amet, consectetur adipiscing elit.";
	private String articleTextEdit = "Brand new content";
	private String commentText = "Lorem ipsum dolor sit amet, comment";
	private String replyText = "Brand new reply";
	
	
	/*
	 * TestCase001
	 * Open random wiki page as anonymous user
	 * Click edit drop-down
	 * Verify available edit options for anonymous user (history item)
	 */
	@Test(groups={"ArticleCRUDAnon_001", "ArticleCRUDAnonymous"})
	public void ArticleCRUDAnon_001_VerifyEditDropDown()
	{
		CommonFunctions.logOut(Properties.userName, driver);
		WikiBasePageObject wiki = new WikiBasePageObject(driver, Global.DOMAIN);
		wiki.openWikiPage();
		wiki.openRandomArticle();
		wiki.clickEditDropDown();
		wiki.verifyEditDropDownAnonymous();
	}
	
	
	/*
	 * TestCase002
	 * Create article as admin user with following names:
	 * 	normal: QAarticle
	 * 	non-latin: 這是文章的名字在中國
	 * 	long: QAVeryLongArticleNameQAVeryLongArticleNameQAVeryLongArticleNameQAVeryLongArticleNameQAVeryLongArticleNameQAVeryLongArticleName
	 * 	with slash: QA/article
	 * 	with underscore: QA_article
	 * 	made from digits:123123123123
	 * Delete article
	 */
			
	@Test(dataProvider="getArticleName", groups={"ArticleCRUDAnon_002", "ArticleCRUDAnonymous"})
	public void ArticleCRUDAnon_002_CreateArticle(String articleName)
	{
		CommonFunctions.logOut(Properties.userName, driver);
		WikiBasePageObject wiki = new WikiBasePageObject(driver, Global.DOMAIN);
		pageName = articleName+wiki.getTimeStamp();
		wiki.openWikiPage();
		WikiArticleEditMode edit = wiki.createNewArticle(pageName, 1);
		edit.deleteArticleContent();
		edit.clickOnVisualButton();
		edit.typeInContent(articleText);
		WikiArticlePageObject article = edit.clickOnPublishButton();
		article.verifyPageTitle(pageName);
		article.verifyArticleText(articleText);
		CommonFunctions.logIn(Properties.userNameStaff, Properties.passwordStaff);
		article.openArticle(pageName);
		article.deleteArticle();
		article.openArticle(pageName);
		article.verifyDeletedArticlePage(pageName);
		CommonFunctions.logOut(Properties.userNameStaff, driver);
	}
	/*
	 * TestCase005
	 * Create article as admin user
	 * Edit article
	 * Delete article
	 */
	@Test(groups={"ArticleCRUDAnon_003", "ArticleCRUDAnonymous"})
	public void ArticleCRUDAnon_003_CreateEditArticle()
	{
		CommonFunctions.logOut(Properties.userName, driver);
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
		edit = article.clickEditButton(pageName);
		edit.deleteArticleContent();
		edit.clickOnVisualButton();
		edit.typeInContent(articleTextEdit);
		article = edit.clickOnPublishButton();
		article.verifyPageTitle(pageName);
		article.verifyArticleText(articleTextEdit);
		CommonFunctions.logIn(Properties.userNameStaff, Properties.passwordStaff);
		article.openArticle(pageName);
		article.deleteArticle();
		article.openArticle(pageName);
		article.verifyDeletedArticlePage(pageName);
		CommonFunctions.logOut(Properties.userNameStaff, driver);
	}
	
	/* 
	 * TestCase006
	 * Add article as admin
	 * Add comment
	 * Delete comment
	 * Delete article
	 */
	@Test(groups={"ArticleCRUDAnon_004", "ArticleCRUDAnonymous"})
	public void ArticleCRUDAnon_004_CreateArticleComment()
	{
		CommonFunctions.logOut(Properties.userName, driver);
		WikiBasePageObject wiki = new WikiBasePageObject(driver, Global.DOMAIN);
		pageName = "QAarticle"+wiki.getTimeStamp();
		wiki.openWikiPage();
		WikiArticleEditMode edit = wiki.createNewArticle(pageName, 1);
		edit.deleteArticleContent();
		edit.clickOnVisualButton();
		edit.typeInContent(articleText);
		WikiArticlePageObject article = edit.clickOnPublishButton();
		article.verifyPageTitle(pageName);
		article.triggerCommentArea();
		article.writeOnCommentArea(commentText);
		article.clickSubmitButton();
		article.verifyComment(commentText, "A Wikia contributor");
		CommonFunctions.logIn(Properties.userNameStaff, Properties.passwordStaff);
		article.openArticle(pageName);
		article.deleteArticle();
		article.openArticle(pageName);
		article.verifyDeletedArticlePage(pageName);
		CommonFunctions.logOut(Properties.userNameStaff, driver);
	}
	
	/* 
	 * TestCase006
	 * Add article as admin
	 * Add comment
	 * Delete comment
	 * Delete article
	 */
	@Test(groups={"ArticleCRUDAnon_005", "ArticleCRUDAnonymous"})
	public void ArticleCRUDAnon_005_CreateArticleCommentReply()
	{
		CommonFunctions.logOut(Properties.userName, driver);
		WikiBasePageObject wiki = new WikiBasePageObject(driver, Global.DOMAIN);
		pageName = "QAarticle"+wiki.getTimeStamp();
		wiki.openWikiPage();
		WikiArticleEditMode edit = wiki.createNewArticle(pageName, 1);
		edit.deleteArticleContent();
		edit.clickOnVisualButton();
		edit.typeInContent(articleText);
		WikiArticlePageObject article = edit.clickOnPublishButton();
		article.verifyPageTitle(pageName);
		article.triggerCommentArea();
		article.writeOnCommentArea(commentText);
		article.clickSubmitButton();
		article.verifyComment(commentText, "A Wikia contributor");
		article.replyComment(commentText, replyText);
		CommonFunctions.logIn(Properties.userNameStaff, Properties.passwordStaff);
		article.openArticle(pageName);
		article.deleteArticle();
		article.openArticle(pageName);
		article.verifyDeletedArticlePage(pageName);
		CommonFunctions.logOut(Properties.userNameStaff, driver);
	}	
	
	@DataProvider
	private static final Object[][] getArticleName()
	{
		return new Object[][]
				{
					{"QAarticle"},
					{"這是文章的名字在中國"},
					{"QAVeryLongArticleNameQAVeryLongArticleNameQAVeryLongArticleNameQAVeryLongArticleNameQAVeryLongArticleNameQAVeryLongArticleName"},
					{"QA/article"},
					{"QA_article"},
					{"123123123123"}
				};
	}
}
