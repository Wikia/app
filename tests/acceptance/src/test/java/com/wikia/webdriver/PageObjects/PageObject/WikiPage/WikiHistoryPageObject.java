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

	
	public WikiHistoryPageObject(WebDriver driver, String Domain, String articlename) {
		super(driver, Domain);
		this.articlename = articlename;
		PageFactory.initElements(driver, this);
	}
	
	public WikiArticleRevisionEditMode clickUndoRevision(int revision)
	{
		WebElement undo = driver.findElement(By.cssSelector("span.mw-history-undo:nth("+revision+")"));
		click(undo);
		return new WikiArticleRevisionEditMode(driver, Domain, articlename);
	}
	
	
	
	
	
	

}
