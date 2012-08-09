package com.wikia.webdriver.pageObjects.PageObject.CreateNewWiki;

import org.openqa.selenium.Keys;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.interactions.Actions;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.PageFactory;
import org.openqa.selenium.support.ui.ExpectedCondition;
import org.openqa.selenium.support.ui.ExpectedConditions;

import com.wikia.webdriver.Common.CommonFunctions;
import com.wikia.webdriver.Logging.PageObjectLogging;
import com.wikia.webdriver.pageObjects.PageObject.BasePageObject;

public class CreateNewWikiLogInPageObject extends BasePageObject{

	public CreateNewWikiLogInPageObject(WebDriver driver) {
		super(driver);
		PageFactory.initElements(driver, this);

	}
	
	@FindBy(css="div.UserLoginModal input[name='username']")
	WebElement userNameField;
	@FindBy(css="div.UserLoginModal input[name='password']")
	WebElement passwordField;
	@FindBy(css="div.UserLoginModal input[type='submit']")
	WebElement submitButton;
	@FindBy(css="div.UserLoginModal a.forgot-password")
	WebElement forgotYourPasswordLink;
	@FindBy(css="div.UserLoginModal a[data-id='facebook']")
	WebElement facebookButton;
	@FindBy(css="li#UserAuth input[value='Sign up']")
	WebElement signUpButton;
	@FindBy(css="div.signup-marketing p:nth-of-type(2)")
	WebElement signUpText;
	
	
	public void typeInUserName(String userName)
	{
		userNameField.sendKeys(userName);
	}
	
	public void typeInPassword(String password)
	{
		passwordField.sendKeys(password);
	}
	
	public void submitLogin()
	{
		submitButton.click();
	}
	
	public void verifyUserNameIsBlank()
	{
		String value = userNameField.getAttribute("value");
		if (value.isEmpty())
		{
			PageObjectLogging.log("verifyUserNameIsBlank", "user name is blank", true, driver);
		}
		else
		{
			PageObjectLogging.log("verifyUserNameIsBlank", "user name isn't blank, value: "+value, false, driver);
		}
	}
	
	public void verifyPasswordIsBlank()
	{
		String value = passwordField.getAttribute("value");
		if (value.isEmpty())
		{
			PageObjectLogging.log("verifyUserNameIsBlank", "password is blank", true, driver);
		}
		else
		{
			PageObjectLogging.log("verifyUserNameIsBlank", "password isn't blank, value: "+value, true, driver);
		}
	}
	
	public void verifyTabTransition()
	{
		userNameField.click();
		CommonFunctions.assertString("username", currentlyFocusedGetAttributeValue("name")) ;
		userNameField.sendKeys(Keys.TAB);
		CommonFunctions.assertString("password", currentlyFocusedGetAttributeValue("name")) ;
		getCurrentlyFocused().sendKeys(Keys.TAB);
		CommonFunctions.assertString("forgot-password", currentlyFocusedGetAttributeValue("class")) ;
		getCurrentlyFocused().sendKeys(Keys.TAB);
		CommonFunctions.assertString("submit", currentlyFocusedGetAttributeValue("type")) ;
		getCurrentlyFocused().sendKeys(Keys.TAB);
		CommonFunctions.assertString("facebook", currentlyFocusedGetAttributeValue("data-id")) ;
		getCurrentlyFocused().sendKeys(Keys.TAB);
		CommonFunctions.assertString("Sign up", currentlyFocusedGetAttributeValue("value")) ;
	}

	public void verifyFaceBookToolTip()
	{
		
		CommonFunctions.assertString("Click the button to log in with Facebook", getAttributeValue(facebookButton, "data-original-title"));
	}
	
	public void verifySignUpText()
	{
		CommonFunctions.assertString("You need an account to create a wiki on Wikia. It only takes a minute to sign up!", signUpText.getText());
	}
	
	private String currentlyFocusedGetAttributeValue(String attributeName)
	{
		String currentlyFocusedName = getCurrentlyFocused().getAttribute(attributeName);
		return currentlyFocusedName;
	}
	
	private String getAttributeValue(WebElement element, String attributeName)
	{
		return element.getAttribute(attributeName);
	}
	
	
	private WebElement getCurrentlyFocused()
	{
		return driver.switchTo().activeElement();
	}
	

	
	
	
}