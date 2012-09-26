package com.wikia.webdriver.PageObjects.PageObject;

import java.util.List;

import org.openqa.selenium.By;
import org.openqa.selenium.JavascriptExecutor;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.PageFactory;

import com.wikia.webdriver.Common.Core.CommonFunctions;
import com.wikia.webdriver.Common.Core.Global;
import com.wikia.webdriver.Common.Logging.PageObjectLogging;
import com.wikia.webdriver.PageObjects.PageObject.CreateNewWiki.CreateNewWikiPageObjectStep1;
import com.wikia.webdriver.PageObjects.PageObject.WikiPage.SpecialMultipleUploadPageObject;
import com.wikia.webdriver.PageObjects.PageObject.WikiPage.SpecialNewFilesPageObject;
import com.wikia.webdriver.PageObjects.PageObject.WikiPage.SpecialUploadPageObject;
import com.wikia.webdriver.PageObjects.PageObject.WikiPage.WikiArticleEditMode;
import com.wikia.webdriver.PageObjects.PageObject.WikiPage.WikiArticlePageObject;

public class WikiBasePageObject extends BasePageObject {
	protected String Domain;

	@FindBy(css="span.drop")
	private WebElement contributeButton;
	
	@FindBy(css="a.createpage")
	private WebElement createArticleButton;
	
	@FindBy(css="a[class='wikia-button createpage']")
	private WebElement addArticleButton;
	
	@FindBy(id="wpCreatePageDialogTitle")
	private WebElement articleNameField;
	
	@FindBy(css="article span.drop")
	private WebElement editDropDown;
	
	@FindBy(css="a[data-id='delete']")
	private WebElement deleteButton;
	
	@FindBy(css="input#wpConfirmB")
	private WebElement deleteConfirmationButton;
	
	@FindBy(css="a#ca-edit")
	protected WebElement editButton;
	
	@FindBy(css="a[data-canonical='random']")
	private WebElement randomPageButton;
	
	@FindBy(css="div.msg a")
	private WebElement undeleteButton;
	
	@FindBy(css="input#mw-undelete-submit")
	private WebElement restoreButton;
	
	@FindBy(css="input#wpNewTitleMain")
	private WebElement renameArticleField;
	
	@FindBy(css="input[name='wpMove']")
	private WebElement confirmRenamePageButton;
	
	@FindBy(css="input#wpReason")
	private WebElement deleteCommentReasonField;
	
	@FindBy(css="tr.ImageUploadFindLinks td a")
	private WebElement addThisPhotoLink;
	
	@FindBy(css="div.reset[id='ImageUpload']")
	private WebElement imageUploadModal;
	
	@FindBy(css="div.details input")
	private WebElement addPhotoButton;
	
	@FindBy(css="input[id='VideoEmbedUrl']")
	private WebElement videoModalInput;
	
	@FindBy(css="a[id='VideoEmbedUrlSubmit']")
	private WebElement videoNextButton;
	
	@FindBy(css="tr.VideoEmbedNoBorder input.wikia-button")
	private WebElement videoAddVideoButton;
	
	@FindBy(css="div[id='VideoEmbed'] input[value='Return to editing']")
	private WebElement videoReturnToEditing;
	
	private By layoutList = By.cssSelector("ul#CreatePageDialogChoices li");
	
	public WikiBasePageObject(WebDriver driver, String Domain) {
		super(driver);
		this.Domain = Domain;
		PageFactory.initElements(driver, this);
		}

	public String getWikiName() {
		return Domain;
	}
	
	/**
	 * Wait For Succes dialog and click on 'return to editing'
	 *  
	 * @author Michal Nowierski
	 * 	 */
	public void waitForSuccesDialogAndReturnToEditing() {
		waitForElementByElement(videoReturnToEditing);
		waitForElementClickableByElement(videoReturnToEditing);
		videoReturnToEditing.click();
		PageObjectLogging.log("WaitForSuccesDialogAndReturnToEditing", "Wait For Succes dialog and click on 'return to editing'", true, driver);
		
	}
	
	/**
	 * Wait for video dialog
	 *  
	 * @author Michal Nowierski
	 * 	 */
	public void waitForVideoDialog() {
		waitForElementByElement(videoAddVideoButton);
		PageObjectLogging.log("WaitForVideoDialog", "Wait for video dialog", true, driver);
		
	}

	/**
	 * Click 'Add a video'
	 *  
	 * @author Michal Nowierski
	 * 	 */
	public void clickAddAvideo() {
		waitForElementClickableByElement(videoAddVideoButton);
		videoAddVideoButton.click();
		PageObjectLogging.log("ClickAddAvideo", "Click 'Add a video'", true, driver);
		
	}
	
	/**
	 * Video Click Next button
	 *  
	 * @author Michal Nowierski
	 * 	 */
	public void clickVideoNextButton() {
		waitForElementByElement(videoNextButton);
		waitForElementClickableByElement(videoNextButton);
		videoNextButton.click();
		PageObjectLogging.log("ClickVideoNextButton", "Left Click Next button", true, driver);
			
	}

	/**
	 * Wait for Video modal and type in the video URL 
	 *  
	 * @author Michal Nowierski
	 * 	 */
	public void waitForVideoModalAndTypeVideoURL(String videoURL) {
		waitForElementByElement(videoModalInput);
		waitForElementClickableByElement(videoModalInput);
		videoModalInput.clear();
		videoModalInput.sendKeys(videoURL);
		PageObjectLogging.log("WaitForVideoModalAndTypeVideoURL", "Wait for Video modal and type in the video URL: "+videoURL, true, driver);		
	}
	
	/**
	 * Left Click on add 'Photo' button.
	 *  
	 * @author Michal Nowierski
	 */
	public void clickOnAddPhotoButton2() {
		waitForElementByElement(addPhotoButton);
		waitForElementClickableByElement(addPhotoButton);
		addPhotoButton.click();
		PageObjectLogging.log("ClickOnAddPhotoButton2", "Left Click on add 'Photo' button.", true, driver);	
	}
	
	/**
	 * Wait for modal and click on 'add this photo' under the first seen photo
	 *  
	 * @author Michal Nowierski
	 */
	public void waitForModalAndClickAddThisPhoto() {
		waitForElementByElement(imageUploadModal);
		waitForElementClickableByElement(addThisPhotoLink);
		addThisPhotoLink.click();
		PageObjectLogging.log("WaitForModalAndClickAddThisPhoto", "Wait for modal and click on 'add this photo' under the first seen photo", true, driver);
	}
	
	public SpecialNewFilesPageObject OpenSpecialNewFiles() {
		driver.get(Domain+"Special:NewFiles");
		return new SpecialNewFilesPageObject(driver, Domain);
	}


	public SpecialUploadPageObject OpenSpecialUpload() {
		driver.get(Domain+"Special:Upload");
		return new SpecialUploadPageObject(driver, Domain);
	}

	public SpecialMultipleUploadPageObject OpenSpecialMultipleUpload() {
		driver.get(Domain+"Special:MultipleUpload");
		return new SpecialMultipleUploadPageObject(driver, Domain);
		
	}

	public WikiArticlePageObject OpenArticle(String wikiArticle) {
		driver.get(Domain+"wiki/"+wikiArticle);
		return new WikiArticlePageObject(driver, Domain, wikiArticle);
	}
	
	
	public void openWikiPage()
	{
		driver.get(Domain);
		executeScript("$('ul#pagehistory li:nth-child(1) .mw-history-undo')");
	}
	
	public void openRandomArticle()
	{
		randomPageButton.click();
		PageObjectLogging.log("openRandomArticle", "random page button clicked", true);
	}
	
	public void verifyEditDropDownAnonymous()
	{
		List<WebElement> list = driver.findElements(By.cssSelector("header#WikiaPageHeader ul.WikiaMenuElement li"));
		CommonFunctions.assertNumber(1, list.size(), "Edit drop-down number of items for anonymous user");
		CommonFunctions.assertString("history", list.get(0).findElement(By.cssSelector("a")).getAttribute("data-id"));
	}
	public void verifyEditDropDownLoggedInUser()
	{
		List<WebElement> list = driver.findElements(By.cssSelector("header#WikiaPageHeader ul.WikiaMenuElement li"));
		CommonFunctions.assertNumber(2, list.size(), "Edit drop-down number of items for admin user");
		CommonFunctions.assertString("history", list.get(0).findElement(By.cssSelector("a")).getAttribute("data-id"));
		CommonFunctions.assertString("move", list.get(1).findElement(By.cssSelector("a")).getAttribute("data-id"));	
	}
	public void verifyEditDropDownAdmin()
	{
		List<WebElement> list = driver.findElements(By.cssSelector("header#WikiaPageHeader ul.WikiaMenuElement li"));
		CommonFunctions.assertNumber(4, list.size(), "Edit drop-down number of items for admin user");
		CommonFunctions.assertString("history", list.get(0).findElement(By.cssSelector("a")).getAttribute("data-id"));
		CommonFunctions.assertString("move", list.get(1).findElement(By.cssSelector("a")).getAttribute("data-id"));
		CommonFunctions.assertString("protect", list.get(2).findElement(By.cssSelector("a")).getAttribute("data-id"));
		CommonFunctions.assertString("delete", list.get(3).findElement(By.cssSelector("a")).getAttribute("data-id"));	
	}
	
	
	private void clickContributeButton()
	{
		executeScript("document.querySelectorAll(\".wikia-menu-button\")[0].click()");
		executeScript("document.querySelectorAll(\".wikia-menu-button\")[0].click()");
		waitForElementByElement(createArticleButton);
		PageObjectLogging.log("clickOnContributeButton", "contribute button clicked", true);
	}
	
	private void clickCreateArticleButton()
	{
		waitForElementByElement(createArticleButton);
		waitForElementClickableByElement(createArticleButton);
		executeScript("document.querySelectorAll('.createpage')[0].click()");
		waitForElementByElement(driver.findElement(layoutList));
		PageObjectLogging.log("clickCreateArticleButton", "create article button clicked", true);
	}
	
	private void selectPageLayout(int number)
	{
		List<WebElement> list = driver.findElements(layoutList);
		try{
			click(list.get(number));
		}
		catch(Exception e)
		{
			PageObjectLogging.log("createNewArticle", e.toString(), false);
		}
	}
	
	private void typeInArticleName(String name)
	{
		waitForElementByElement(articleNameField);
		try {
			Thread.sleep(500);
		} catch (InterruptedException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		articleNameField.sendKeys(name);
	}
	
	private void clickAddPageButton()
	{
		click(addArticleButton);
	}
	
	public void verifyDeletedArticlePage(String pageName)
	{
		pageName = pageName.replace("_", " ");
		waitForElementByXPath("//h1[contains(text(), '"+pageName+"')]");
		waitForElementByXPath("//p[contains(text(), 'This page has been deleted.')]");
		waitForElementByXPath("//b[contains(text(), 'This page needs content. You can help by adding a sentence or a photo!')]");
		PageObjectLogging.log("verifyDeletedArticlePage", "deleted article page verified", true);
	}
	
	public void clickEditDropDown()
	{
		waitForElementByElement(editDropDown);
//		clickActions(editDropDown);
		editDropDown.click();
		PageObjectLogging.log("clickEditDropDown", "edit drop-down clicked", true);
	}
	
	public WikiArticleEditMode clickEditButton(String pageName)
	{
		editButton.click();
		PageObjectLogging.log("clickEditButton", "edit button clicked", true);
		return new WikiArticleEditMode(driver, Domain, pageName);
	}
	
	protected void clickDeleteButtonInDropDown()
	{
		waitForElementByElement(deleteButton);
		clickActions(deleteButton);
//		deleteButton.click();
		PageObjectLogging.log("clickDeleteButtonInDropDown", "delete button in drop-down clicked", true);
	}
	
	protected void clickDeleteConfirmationButton()
	{
		waitForElementByElement(deleteConfirmationButton);
		waitForElementByElement(deleteCommentReasonField);
		deleteCommentReasonField.clear();
		deleteCommentReasonField.sendKeys("QAReason");
//		executeScript("document.querySelectorAll('#wpConfirmB')[0].click()");
		deleteConfirmationButton.click();
	}
	
	public void deleteArticle()
	{
		driver.get(driver.getCurrentUrl()+"?action=delete");
//		clickDeleteButtonInDropDown();
		clickDeleteConfirmationButton();
		PageObjectLogging.log("deleteArticle", "article has been deleted", true, driver);
	}
	
	public void renameArticle(String articleName, String articleNewName)
	{
		driver.get(Global.DOMAIN+"wiki/Special:MovePage/"+articleName);
		waitForElementByElement(renameArticleField);
		waitForElementByElement(confirmRenamePageButton);
		renameArticleField.clear();
		renameArticleField.sendKeys(articleNewName);
		confirmRenamePageButton.click();
		waitForElementByXPath("//b[contains(text(), '\""+articleName+"\" has been renamed \""+articleNewName+"\"')]");
	}
	
	private void clickUndeleteArticle()
	{
		waitForElementByElement(undeleteButton);
		undeleteButton.click();
		waitForElementByElement(restoreButton);
		PageObjectLogging.log("clickUndeleteArticle", "undelete article button clicked", true, driver);
	}
	
	private void clickRestoreArticleButton()
	{
		waitForElementByElement(restoreButton);
		restoreButton.click();
		waitForElementByXPath("//div[@class='msg' and contains(text(), 'This page has been restored.')]");
		PageObjectLogging.log("clickUndeleteArticle", "undelete article button clicked", true, driver);
	}
	
	public void undeleteArticle()
	{
		clickUndeleteArticle();
		clickRestoreArticleButton();
	}
	
	public WikiArticleEditMode createNewArticle(String pageName, int layoutNumber)
	{
		clickContributeButton();
		clickCreateArticleButton();
		selectPageLayout(layoutNumber);
		typeInArticleName(pageName);
		clickAddPageButton();
		String pageNameEnc = pageName.replace("_", " ");
		waitForElementByElement(driver.findElement(By.cssSelector("a[title='"+pageNameEnc+"']")));
		return new WikiArticleEditMode(driver, Domain, pageName);
	}
	
	public WikiArticlePageObject openArticle(String articleName)
	{
		driver.get(Global.DOMAIN+"wiki/"+articleName);
		PageObjectLogging.log("openArticle", "article "+articleName+" opened", true, driver);
		return new WikiArticlePageObject(driver, Domain, articleName);
	}
	
	public CreateNewWikiPageObjectStep1 startAWiki()
	{
		return null;
		
	}


	
}
