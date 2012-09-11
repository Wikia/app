package com.wikia.webdriver.PageObjects.PageObject.CreateNewWiki;

import org.openqa.selenium.By;
import org.openqa.selenium.Keys;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.PageFactory;
import org.openqa.selenium.support.ui.ExpectedConditions;

import com.wikia.webdriver.Common.Core.CommonFunctions;
import com.wikia.webdriver.Common.Logging.PageObjectLogging;
import com.wikia.webdriver.PageObjects.PageObject.BasePageObject;


/**
 * 
 * @author Karol
 *
 */
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
	@FindBy(css="div.UserLoginModal a[data-id='facebook'] img")
	WebElement facebookButton;
	@FindBy(css="li#UserAuth input[value='Sign up']")
	WebElement signUpButton;
	@FindBy(css="div.signup-marketing p:nth-of-type(2)")
	WebElement signUpText;
	@FindBy(css="div.UserLoginModal div.error-msg")
	WebElement usernameValidationText;
	
	
	public void typeInUserName(String userName)
	{
		waitForElementByElement(userNameField);
		userNameField.sendKeys(userName);
		PageObjectLogging.log("typeInUserName", "user name was typed", true, driver);
	}
	
	public void typeInPassword(String password)
	{
		waitForElementByElement(passwordField);
		passwordField.sendKeys(password);
		PageObjectLogging.log("typeInPassword", "password name was typed", true, driver);
	}
	
	public CreateNewWikiPageObjectStep2 submitLogin()
	{
		waitForElementByElement(submitButton);
		submitButton.click();
		PageObjectLogging.log("submitLogin", "submit button was clicked", true, driver);
		return new CreateNewWikiPageObjectStep2(driver);
	}
	
	public void verifyUserNameIsBlank()
	{
		waitForElementByElement(userNameField);
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
		waitForElementByElement(passwordField);
		String value = passwordField.getAttribute("value");
		if (value.isEmpty())
		{
			PageObjectLogging.log("verifyUserNameIsBlank", "password is blank", true, driver);
		}
		else
		{
			PageObjectLogging.log("verifyUserNameIsBlank", "password isn't blank, value: "+value, false, driver);
		}
	}
	
	public void verifyTabTransition()
	{
		waitForElementByElement(userNameField);
		userNameField.click();
		CommonFunctions.assertString("username", CommonFunctions.currentlyFocusedGetAttributeValue("name")) ;
		userNameField.sendKeys(Keys.TAB);
		CommonFunctions.assertString("password", CommonFunctions.currentlyFocusedGetAttributeValue("name")) ;
		CommonFunctions.getCurrentlyFocused().sendKeys(Keys.TAB);
		CommonFunctions.assertString("forgot-password", CommonFunctions.currentlyFocusedGetAttributeValue("class")) ;
		CommonFunctions.getCurrentlyFocused().sendKeys(Keys.TAB);
		CommonFunctions.assertString("submit", CommonFunctions.currentlyFocusedGetAttributeValue("type")) ;
		CommonFunctions.getCurrentlyFocused().sendKeys(Keys.TAB);
		CommonFunctions.assertString("facebook", CommonFunctions.currentlyFocusedGetAttributeValue("data-id")) ;
		CommonFunctions.getCurrentlyFocused().sendKeys(Keys.TAB);
		CommonFunctions.assertString("Sign up", CommonFunctions.currentlyFocusedGetAttributeValue("value")) ;
	}

	public void verifyFaceBookToolTip()
	{
		
		CommonFunctions.assertString("Click the button to log in with Facebook", CommonFunctions.getAttributeValue(facebookButton, "data-original-title"));
	}
	
	public void verifySignUpText()
	{
		CommonFunctions.assertString("You need an account to create a wiki on Wikia. It only takes a minute to sign up!", signUpText.getText());
	}
	
	
	public void verifyEmptyUserNameValidation()
	{
		waitForElementByBy(By.cssSelector("div.UserLoginModal div.input-group div.error-msg"));
		waitForElementByElement(usernameValidationText);
		String text = usernameValidationText.getText();
		CommonFunctions.assertString("Oops, please fill in the username field.", text);
		userNameField.clear();
	}
	
	public void verifyInvalidUserNameValidation()
	{
		wait.until(ExpectedConditions.visibilityOfElementLocated(By.cssSelector("div.UserLoginModal div.input-group div.error-msg")));
		CommonFunctions.assertString("Hm, we don't recognize this name. Don't forget usernames are case sensitive.", usernameValidationText.getText());
		userNameField.clear();
	}
	
	public void verifyBlankPasswordValidation()
	{
		wait.until(ExpectedConditions.visibilityOfElementLocated(By.cssSelector("div.UserLoginModal div.input-group div.error-msg")));
		CommonFunctions.assertString("Oops, please fill in the password field.", usernameValidationText.getText());
		userNameField.clear();
	}
	
	public void verifyInvalidPasswordValidation()
	{
		wait.until(ExpectedConditions.visibilityOfElementLocated(By.cssSelector("div.UserLoginModal div.input-group div.error-msg")));
		CommonFunctions.assertString("Oops, wrong password. Make sure caps lock is off and try again.", usernameValidationText.getText());
		userNameField.clear();
		passwordField.clear();
	}
	
	public void facebookConnectButtonClick()
	{
		userNameField.click();
		CommonFunctions.assertString("username", CommonFunctions.currentlyFocusedGetAttributeValue("name")) ;
		userNameField.sendKeys(Keys.TAB);
		CommonFunctions.assertString("password", CommonFunctions.currentlyFocusedGetAttributeValue("name")) ;
		CommonFunctions.getCurrentlyFocused().sendKeys(Keys.TAB);
		CommonFunctions.assertString("forgot-password", CommonFunctions.currentlyFocusedGetAttributeValue("class")) ;
		CommonFunctions.getCurrentlyFocused().sendKeys(Keys.TAB);
		CommonFunctions.assertString("submit", CommonFunctions.currentlyFocusedGetAttributeValue("type")) ;
		CommonFunctions.getCurrentlyFocused().sendKeys(Keys.TAB);
		CommonFunctions.assertString("facebook", CommonFunctions.currentlyFocusedGetAttributeValue("data-id")) ;
		CommonFunctions.getCurrentlyFocused().sendKeys(Keys.ENTER);
//		
//		Actions builder = new Actions(driver);
//		builder.moveToElement(facebookButton).click().click().click().click().build().perform();
//		Point point = facebookButton.getLocation();
//		builder.moveByOffset(point.y, point.x).click().build().perform();
		
		
	}
	
	

	
	
	
}