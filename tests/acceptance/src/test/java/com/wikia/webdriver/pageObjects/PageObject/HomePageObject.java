package com.wikia.webdriver.pageObjects.PageObject;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.interactions.Actions;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.PageFactory;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.support.ui.WebDriverWait;


import com.wikia.webdriver.pageObjects.PageObject.Hubs.EntertainmentHub;
import com.wikia.webdriver.pageObjects.PageObject.Hubs.LifestyleHub;
import com.wikia.webdriver.pageObjects.PageObject.CreateNewWiki.CreateNewWikiPageObjectStep1;
import com.wikia.webdriver.pageObjects.PageObject.Hubs.VideoGamesHub;

public class HomePageObject extends BasePageObject{

	@FindBy(className="create-wiki") 
	private WebElement startWikiButton;
	@FindBy(css="section.grid-2.videogames a img") 
	private WebElement OpenVideoGamesHub;
	@FindBy(css="section.grid-2.entertainment a img") 
	private WebElement OpenEntertainmentHub;
	@FindBy(css="section.grid-2.lifestyle a img") 
	private WebElement OpenLifestyleHub;
	@FindBy(className="ajaxLogin")
	public WebElement logInAjax;
	@FindBy (xpath="//div[@class='input-group required   ']/input[@name='username']")
	public WebElement userNameField;
	@FindBy (xpath="//div[@class='input-group required   ']/input[@name='password']")
	public WebElement passwordField;
	@FindBy (css="input[type='submit']")
	public WebElement submitButton;
	
	
	public HomePageObject(WebDriver driver) 
	{
		super(driver);
		driver.get(liveDomain);
		PageFactory.initElements(driver, this);
	}
	
	public CreateNewWikiPageObjectStep1 StartAWikia()
	{
		click(startWikiButton);
		return new CreateNewWikiPageObjectStep1(driver);
	}
	
	public void logIn(String userName, String password)
	{
		Actions builder = new Actions(driver);
		builder.click(logInAjax).build().perform();
		WebDriverWait wait = new WebDriverWait(driver, timeOut);
		wait.until(ExpectedConditions.presenceOfElementLocated(By.cssSelector("input[name='username']")));
		userNameField.sendKeys(userName);
		passwordField.sendKeys(password);
		submitButton.click();
		wait.until(ExpectedConditions.presenceOfElementLocated(By.cssSelector("a[href='/User:"+userName+"']")));
		
	}
	
	public VideoGamesHub OpenVideoGamesHub() {
	
		click(OpenVideoGamesHub);
		return new VideoGamesHub(driver);		
	}
	public EntertainmentHub OpenEntertainmentHub() {
		
		click(OpenEntertainmentHub);
		return new EntertainmentHub(driver);		
	}
	public LifestyleHub OpenLifestyleHub() {
		
		click(OpenLifestyleHub);
		return new LifestyleHub(driver);		
	}

}
