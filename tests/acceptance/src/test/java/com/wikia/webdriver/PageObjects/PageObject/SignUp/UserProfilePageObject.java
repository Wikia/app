package com.wikia.webdriver.PageObjects.PageObject.SignUp;

import org.openqa.selenium.By;
import org.openqa.selenium.NoSuchElementException;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.PageFactory;
import org.openqa.selenium.support.ui.ExpectedConditions;

import com.wikia.webdriver.Common.Core.CommonFunctions;
import com.wikia.webdriver.Common.Core.MailFunctions;
import com.wikia.webdriver.Common.Logging.PageObjectLogging;
import com.wikia.webdriver.Common.Properties.Properties;
import com.wikia.webdriver.PageObjects.PageObject.BasePageObject;

public class UserProfilePageObject extends BasePageObject{

	@FindBy(css="header#WikiaHeader a.ajaxLogin")
	private WebElement logInLink;
	
	public UserProfilePageObject(WebDriver driver) {
		super(driver);
		PageFactory.initElements(driver, this);
	}

	/**
	 * @author Karol Kujawiak
	 * @param userName
	 */
	public void verifyUserLoggedIn(String userName)
	{
		wait.until(ExpectedConditions.presenceOfElementLocated(By.cssSelector("a[href*='/User:"+userName+"']")));
		PageObjectLogging.log("verifyUserLoggedIn ", "Verified user is logged in", true);
	}
	
	/**
	 * @author Karol Kujawiak
	 */
	private void verifyLogInInvisiblity()
	{
		wait.until(ExpectedConditions.stalenessOf(logInLink));	
		PageObjectLogging.log("verifyLogInInvisiblity ", "Log in is not visible", true);			
	}
	
	/**
	 * @author Karol Kujawiak
	 */
	private void verifyRegisterInvisiblity()
	{
		try
		{
			wait.until(ExpectedConditions.invisibilityOfElementLocated(By.cssSelector("header#WikiaHeader a.ajaxRegister")));			
		}
		catch (NoSuchElementException e)
		{
			PageObjectLogging.log("verifyLogInInvisiblity ", "Register in is not visible", true);						
		}
	}
	
	/**
	 * @author Karol Kujawiak
	 */
	public void verifyUserProfilePage()
	{
//		verifyLogInInvisiblity();
//		verifyRegisterInvisiblity();
		verifyUserToolBar();
	}
	
	/**
	 * @author Karol Kujawiak
	 */
	public void verifyWelcomeEmail(String userName)
	{
		PageObjectLogging.log("verifyWelcomeEmail ", "start of email verification", true);
		String[] mailContent = MailFunctions.getWelcomeMailContent(MailFunctions.getFirstMailContent(Properties.email, Properties.emailPassword));
		CommonFunctions.assertString("We're happy to welcome you to Wikia and Wikia! Here are some things you can= do to get started.", mailContent[2]);
		CommonFunctions.assertString("Edit your profile.", mailContent[4]);
		CommonFunctions.assertString("Add a profile photo and a few quick facts about yourself on your Wikia prof=ile.", mailContent[6]);
		CommonFunctions.assertString("Go to http://www.wikia.com/User:"+userName, mailContent[8].replace("=", ""));
		CommonFunctions.assertString("Learn the basics.", mailContent[10]);
		CommonFunctions.assertString("Get a quick tutorial on the basics of Wikia: how to edit a page, your user =profile, change your preferences, and more.", mailContent[12]);
		CommonFunctions.assertString("Check it out (http://community.wikia.com/wiki/Help:Wikia_Basics)", mailContent[14]);
		CommonFunctions.assertString("Explore more wikis.", mailContent[16]);
		CommonFunctions.assertString("There are thousands of wikis on Wikia, find more wikis that interest you by= heading to one of our hubs: Video Games (http://www.wikia.com/Video_Games)=, Entertainment (http://www.wikia.com/Entertainment), or Lifestyle (http://=www.wikia.com/Lifestyle).", mailContent[18]);
		CommonFunctions.assertString("Go to http://www.wikia.com", mailContent[20]);
		CommonFunctions.assertString("Want more information? Find advice, answers, and the Wikia community at Com=munity Central (http://www.community.wikia.com). Happy editing!", mailContent[22]);
		CommonFunctions.assertString("The Wikia Team", mailContent[24]);
		PageObjectLogging.log("verifyWelcomeEmail ", "end of email verification", true);
	}
	
	
	
	
}
