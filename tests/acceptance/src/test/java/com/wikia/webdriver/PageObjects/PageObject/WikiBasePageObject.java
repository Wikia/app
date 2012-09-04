package com.wikia.webdriver.PageObjects.PageObject;

import java.util.List;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.PageFactory;

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
	
	private By layoutList = By.cssSelector("ul#CreatePageDialogChoices li");
	
	public WikiBasePageObject(WebDriver driver, String Domain) {
		super(driver);
		this.Domain = Domain;
		PageFactory.initElements(driver, this);
		}

	public String getWikiName() {
		return Domain;
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
	}
	
	private void clickContributeButton()
	{
		click(contributeButton);
		waitForElementByElement(createArticleButton);
		PageObjectLogging.log("clickOnContributeButton", "contribute button clicked", true);
	}
	
	private void clickCreateArticleButton()
	{
		click(createArticleButton);
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
		articleNameField.sendKeys(name);
	}
	
	private void clickAddPageButton()
	{
		click(addArticleButton);
	}
	
	public void verifyDeletedArticlePage(String pageName)
	{
		waitForElementByXPath("//h1[contains(text(), '"+pageName+"')]");
		waitForElementByXPath("//p[contains(text(), 'This page has been deleted.')]");
		waitForElementByXPath("//b[contains(text(), 'This page needs content. You can help by adding a sentence or a photo!')]");
		PageObjectLogging.log("verifyDeletedArticlePage", "deleted article page verified", true);
	}
	
	private void clickEditDropDown()
	{
		editDropDown.click();
		PageObjectLogging.log("clickEditDropDown", "edit drop-down clicked", true);
	}
	
	private void clickDeleteButtonInDropDown()
	{
		waitForElementByElement(deleteButton);
		deleteButton.click();
		PageObjectLogging.log("clickDeleteButtonInDropDown", "delete button in drop-down clicked", true);
	}
	
	private void clickDeleteConfirmationButton()
	{
		waitForElementByElement(deleteConfirmationButton);
		deleteConfirmationButton.click();
	}
	
	public void deleteArticle()
	{
		clickEditDropDown();
		clickDeleteButtonInDropDown();
		clickDeleteConfirmationButton();
		PageObjectLogging.log("deleteArticle", "article has been deleted", true, driver);
	}
	
	public WikiArticleEditMode createNewArticle(String pageName, int layoutNumber)
	{
		clickContributeButton();
		clickCreateArticleButton();
		typeInArticleName(pageName);
		selectPageLayout(layoutNumber);
		clickAddPageButton();
		waitForElementByElement(driver.findElement(By.cssSelector("a[title='"+pageName+"']")));
		return new WikiArticleEditMode(driver, Domain, pageName);
	}
	
	public WikiArticlePageObject openArticle(String articleName)
	{
		driver.get(Domain+"wiki/"+articleName);
		PageObjectLogging.log("openArticle", "article "+articleName+" opened", true, driver);
		return new WikiArticlePageObject(driver, Domain, articleName);
	}
	
	public CreateNewWikiPageObjectStep1 startAWiki()
	{
		return null;
		
	}


	
}
