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

public class ArticleTests extends TestTemplate{
	
	private String pageName;
	private String articleText = "Lorem ipsum dolor sit amet, consectetur adipiscing elit.";
	private String articleTextEdit = "Brand new content";
	private String commentText = "Lorem ipsum dolor sit amet, comment";
	private String commentTextEdit = "Brand new comment";
	
//	
//	/*
//	 * TestCase001
//	 * Open random wiki page as anonymous user
//	 * Click edit drop-down
//	 * Verify available edit options for anonymous user (history item)
//	 */
//	@Test(groups={"ArticleCRUD_001", "ArticleCRUD"})
//	public void ArticleCRUD_001_VerifyEditDropDown_AnonymousUser()
//	{
//		CommonFunctions.logOut(Properties.userName, driver);
//		WikiBasePageObject wiki = new WikiBasePageObject(driver, Global.DOMAIN);
//		wiki.openWikiPage();
//		wiki.openRandomArticle();
//		wiki.clickEditDropDown();
//		wiki.verifyEditDropDownAnonymous();
//	}
//	
//	/*
//	 * TestCase002
//	 * Open random wiki page as logged in user
//	 * Click edit drop-down
//	 * Verify available edit options for logged in user (history and rename)
//	 */
//	@Test(groups={"ArticleCRUD_002", "ArticleCRUD"})
//	public void ArticleCRUD_002_VerifyEditDropDown_LoggedInUser()
//	{
//		CommonFunctions.logOut(Properties.userName, driver);
//		CommonFunctions.logIn(Properties.userName, Properties.password);
//		WikiBasePageObject wiki = new WikiBasePageObject(driver, Global.DOMAIN);
//		wiki.openWikiPage();
//		wiki.openRandomArticle();
//		wiki.clickEditDropDown();
//		wiki.verifyEditDropDownLoggedInUser();
//		CommonFunctions.logOut(Properties.userName, driver);
//	}
//	
//	/*
//	 * TestCase003
//	 * Open random wiki page as admin user
//	 * Click edit drop-down
//	 * Verify available edit options for admin user (history, rename, protect, delete)
//	 */
//	@Test(groups={"ArticleCRUD_003", "ArticleCRUD"})
//	public void ArticleCRUD_003_VerifyEditDropDown_AdminUser()
//	{
//		CommonFunctions.logOut(Properties.userNameStaff, driver);
//		CommonFunctions.logIn(Properties.userNameStaff, Properties.passwordStaff);
//		WikiBasePageObject wiki = new WikiBasePageObject(driver, Global.DOMAIN);
//		wiki.openWikiPage();
//		wiki.openRandomArticle();
//		wiki.clickEditDropDown();
//		wiki.verifyEditDropDownAdmin();
//		CommonFunctions.logOut(Properties.userNameStaff, driver);
//	}
//	
//	
//	/*
//	 * TestCase004
//	 * Create article as admin user with following names:
//	 * 	normal: QAarticle
//	 * 	non-latin: 這是文章的名字在中國
//	 * 	long: QAVeryLongArticleNameQAVeryLongArticleNameQAVeryLongArticleNameQAVeryLongArticleNameQAVeryLongArticleNameQAVeryLongArticleName
//	 * 	with slash: QA/article
//	 * 	with underscore: QA_article
//	 * 	made from digits:123123123123
//	 * Delete article
//	 */
//		
//	@Test(groups={"ArticleCRUD_004", "ArticleCRUD"})
//	public void ArticleCRUD_004_CreateArticle_Admin(String articleName)
//	{
//		CommonFunctions.logOut(Properties.userName, driver);
//		CommonFunctions.logIn(Properties.userNameStaff, Properties.passwordStaff);
//		WikiBasePageObject wiki = new WikiBasePageObject(driver, Global.DOMAIN);
//		pageName = articleName+wiki.getTimeStamp();
//		wiki.openWikiPage();
//		WikiArticleEditMode edit = wiki.createNewArticle(pageName, 1);
//		edit.deleteArticleContent();
//		edit.clickOnVisualButton();
//		edit.typeInContent(articleText);
//		WikiArticlePageObject article = edit.clickOnPublishButton();
//		article.verifyPageTitle(pageName);
//		article.verifyArticleText(articleText);
//		article.deleteArticle();
//		article.openArticle(pageName);
//		article.verifyDeletedArticlePage(pageName);
//		CommonFunctions.logOut(Properties.userNameStaff, driver);
//	}
//	/*
//	 * TestCase005
//	 * Create article as admin user
//	 * Edit article
//	 * Delete article
//	 */
//	@Test(groups={"ArticleCRUD_005", "ArticleCRUD"})
//	public void ArticleCRUD_005_CreateEditArticle_Admin()
//	{
//		CommonFunctions.logOut(Properties.userName, driver);
//		CommonFunctions.logIn(Properties.userNameStaff, Properties.passwordStaff);
//		WikiBasePageObject wiki = new WikiBasePageObject(driver, Global.DOMAIN);
//		pageName = "QAarticle"+wiki.getTimeStamp();
//		wiki.openWikiPage();
//		WikiArticleEditMode edit = wiki.createNewArticle(pageName, 1);
//		edit.deleteArticleContent();
//		edit.clickOnVisualButton();
//		edit.typeInContent(articleText);
//		WikiArticlePageObject article = edit.clickOnPublishButton();
//		article.verifyPageTitle(pageName);
//		article.verifyArticleText(articleText);
//		edit = article.clickEditButton(pageName);
//		edit.deleteArticleContent();
//		edit.clickOnVisualButton();
//		edit.typeInContent(articleTextEdit);
//		article = edit.clickOnPublishButton();
//		article.verifyPageTitle(pageName);
//		article.verifyArticleText(articleTextEdit);
//		article.deleteArticle();
//		article = article.openArticle(pageName);
//		article.verifyDeletedArticlePage(pageName);
//		CommonFunctions.logOut(Properties.userNameStaff, driver);
//	}
//	
//	/* 
//	 * TestCase006
//	 * Add article as admin
//	 * Add comment
//	 * Delete comment
//	 * Delete article
//	 */
//	@Test(groups={"ArticleCRUD_006", "ArticleCRUD"})
//	public void ArticleCRUD_006_CreateArticleComment_Admin()
//	{
//		CommonFunctions.logOut(Properties.userName, driver);
//		CommonFunctions.logIn(Properties.userNameStaff, Properties.passwordStaff);
//		WikiBasePageObject wiki = new WikiBasePageObject(driver, Global.DOMAIN);
//		pageName = "QAarticle"+wiki.getTimeStamp();
//		wiki.openWikiPage();
//		WikiArticleEditMode edit = wiki.createNewArticle(pageName, 1);
//		edit.deleteArticleContent();
//		edit.clickOnVisualButton();
//		edit.typeInContent(articleText);
//		WikiArticlePageObject article = edit.clickOnPublishButton();
//		edit.verifyPageTitle(pageName);
//		article.triggerCommentArea();
//		article.writeOnCommentArea(commentText);
//		article.clickSubmitButton();
//		article.verifyComment(commentText, Properties.userNameStaff);
//		article.deleteComment(commentText);
//		edit.deleteArticle();
//		edit.openArticle(pageName);
//		edit.verifyDeletedArticlePage(pageName);
//		CommonFunctions.logOut(Properties.userNameStaff, driver);
//	}
	/*
	 * TestCase007
	 * Add article
	 * Add comment
	 * Edit comment
	 * Delete comment
	 * Delete article
	 */
	@Test(groups={"ArticleCRUD_007", "ArticleCRUD"})
	public void ArticleCRUD_007_CreateArticleEditComment_007()
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
		edit.verifyPageTitle(pageName);
		article.triggerCommentArea();
		article.writeOnCommentArea(commentText);
		article.clickSubmitButton();
		article.verifyComment(commentText, Properties.userNameStaff);
		article.editComment(commentText);
		article.writeOnCommentArea(commentTextEdit);
		article.clickSubmitButton(Properties.userNameStaff);
		article.verifyComment(commentTextEdit, Properties.userNameStaff);
		article.deleteComment(commentTextEdit);
		edit.deleteArticle();
		edit.openArticle(pageName);
		edit.verifyDeletedArticlePage(pageName);
		CommonFunctions.logOut(Properties.userNameStaff, driver);
	}
	
	/*
	 * TestCase005
	 * Add article
	 * Delete article
	 * Undelete article
	 */
	/*
	 * TestCase006
	 * Add article
	 * Move-rename article
	 * Delete article
	 */
	/*
	 * verification of available options in edit drop-down for logged in user
	 */
	/*
	 * verification of available options in edit drop-down for logged out user
	 */
	
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
