package com.wikia.webdriver.PageObjects.PageObject.WikiPage;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.PageFactory;
import org.openqa.selenium.support.ui.Select;

import com.wikia.webdriver.PageObjects.PageObject.WikiBasePageObject;

public class WikiHistoryPageObject extends WikiBasePageObject{

	protected String articlename;
	
	@FindBy(css="//strong[contains(text(), 'History')]")
	protected static WebElement historyHeadLine;
	@FindBy(css=".historysubmit:first")
	private WebElement compareRevisionsTopButton;
	@FindBy(css=".historysubmit:last")
	private WebElement compareRevisionsBottomButton;
	@FindBy(css="input[value='Go']")
	private WebElement goButton;
	@FindBy(css="input#year")
	private WebElement fromYearField;
	@FindBy(css="select#month")
	private Select fromMonthDropDown;
	@FindBy(css="input#mw-show-deleted-only")
	private WebElement deletedOnlyCheckBox;
	@FindBy(xpath="//a[contains(text(), 'Back to page')]")
	private WebElement backToPageLink;
	@FindBy(css="span.mw-rollback-link a")
	private WebElement rollbackButton;
	@FindBy(xpath="//h1[contains(text(), 'Action complete')]")
	private WebElement rollbackCompleteMessage;
	@FindBy(css="p#mw-returnto a")
	private WebElement backToPageLinkOnRollbackPage;

	
	public WikiHistoryPageObject(WebDriver driver, String Domain, String articlename) {
		super(driver, Domain);
		this.articlename = articlename;
		PageFactory.initElements(driver, this);
	}
	
	public WikiArticleRevisionEditMode clickUndoRevision(int revision)
	{
		WebElement undo = driver.findElement(By.xpath("//ul[@id='pagehistory']/li["+revision+"]//span[@class='mw-history-undo']/a"));
//		WebElement undo = driver.findElement(By.cssSelector("ul#pagehistory li:nth-child("+revision+") .mw-history-undo"));
		click(undo);
		return new WikiArticleRevisionEditMode(driver, Domain, articlename);
	}
	
	public void rollbackPage()
	{
		waitForElementByElement(rollbackButton);
		click(rollbackButton);
		waitForElementByElement(rollbackCompleteMessage);
	}
	
	public WikiArticlePageObject enterPageAfterRollback()
	{
		waitForElementByElement(backToPageLinkOnRollbackPage);
		click(backToPageLinkOnRollbackPage);
		return new WikiArticlePageObject(driver, Domain, articlename);
	}
	
	
	
	
	
	

}
