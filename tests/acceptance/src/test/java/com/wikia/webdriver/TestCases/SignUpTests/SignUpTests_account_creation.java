package com.wikia.webdriver.TestCases.SignUpTests;

import org.apache.commons.lang.RandomStringUtils;
import org.testng.annotations.Test;

import com.wikia.webdriver.Common.Properties.Properties;
import com.wikia.webdriver.Common.Templates.TestTemplate;
import com.wikia.webdriver.pageObjects.PageObject.SignUp.AlmostTherePageObject;
import com.wikia.webdriver.pageObjects.PageObject.SignUp.ConfirmationPageObject;
import com.wikia.webdriver.pageObjects.PageObject.SignUp.SignUpPageObject;
import com.wikia.webdriver.pageObjects.PageObject.SignUp.UserProfilePageObject;

public class SignUpTests_account_creation extends TestTemplate
{
	private String timeStamp;
	
	@Test
	public void SignUpTC_001_non_latin_user_name()
	{
		SignUpPageObject signUp = new SignUpPageObject(driver);
		timeStamp = signUp.getTimeStamp(); 
		String userName = Properties.userNameNonLatin+timeStamp;
		String userNameEnc = Properties.userNameNonLatinEncoded+timeStamp;
		String password = "QAPassword"+timeStamp;
		signUp.openSignUpPage();
		signUp.typeInEmail();
		signUp.typeInUserName(userName);
		signUp.typeInPassword(password);
		signUp.enterBirthDate("11", "11", "1954");
		signUp.enterBlurryWord();
		AlmostTherePageObject almostTherePage = signUp.submit();
		almostTherePage.verifyAlmostTherePage();
		ConfirmationPageObject confirmPageAlmostThere = almostTherePage.enterActivationLink();
		confirmPageAlmostThere.typeInUserName(userName);
		confirmPageAlmostThere.typeInPassword(password);
		UserProfilePageObject userProfile = confirmPageAlmostThere.clickSubmitButton();
		userProfile.verifyUserLoggedIn(userNameEnc);
		userProfile.verifyUserToolBar();	
		userProfile.verifyWelcomeEmail(userNameEnc);
	}
	
	@Test
	public void SignUpTC_002_fifty_character_user_name()
	{
		SignUpPageObject signUp = new SignUpPageObject(driver);
		timeStamp = signUp.getTimeStamp(); 
		String userName = "Qweasdzxcvqweasdzxcvqweasdzxcvqweasdz"+timeStamp;
		String password = "QAPassword"+timeStamp;
		signUp.openSignUpPage();
		signUp.typeInEmail();
		signUp.typeInUserName(userName);
		signUp.typeInPassword(password);
		signUp.enterBirthDate("11", "11", "1954");
		signUp.enterBlurryWord();
		AlmostTherePageObject almostTherePage = signUp.submit();
		almostTherePage.verifyAlmostTherePage();
		ConfirmationPageObject confirmPageAlmostThere = almostTherePage.enterActivationLink();
		confirmPageAlmostThere.typeInUserName(userName);
		confirmPageAlmostThere.typeInPassword(password);
		UserProfilePageObject userProfile = confirmPageAlmostThere.clickSubmitButton();
		userProfile.verifyUserLoggedIn(userName);
		userProfile.verifyUserToolBar();	
		userProfile.verifyWelcomeEmail(userName);
	}
	
	@Test
	public void SignUpTC_003_backward_slash_user_name()
	{
		SignUpPageObject signUp = new SignUpPageObject(driver);
		timeStamp = signUp.getTimeStamp(); 
		String userName = Properties.userNameWithBackwardSlash+timeStamp;
		String userNameEnc = Properties.userNameWithBackwardSlashEncoded+timeStamp;
		String password = "QAPassword"+timeStamp;
		signUp.openSignUpPage();
		signUp.typeInEmail();
		signUp.typeInUserName(userName);
		signUp.typeInPassword(password);
		signUp.enterBirthDate("11", "11", "1954");
		signUp.enterBlurryWord();
		AlmostTherePageObject almostTherePage = signUp.submit();
		almostTherePage.verifyAlmostTherePage();
		ConfirmationPageObject confirmPageAlmostThere = almostTherePage.enterActivationLink();
		confirmPageAlmostThere.typeInUserName(userName);
		confirmPageAlmostThere.typeInPassword(password);
		UserProfilePageObject userProfile = confirmPageAlmostThere.clickSubmitButton();
		userProfile.verifyUserLoggedIn(userNameEnc);
		userProfile.verifyUserToolBar();	
		userProfile.verifyWelcomeEmail(userNameEnc);
	}
	
	
	@Test
	public void SignUpTC_004_one_char_password()
	{
		SignUpPageObject signUp = new SignUpPageObject(driver);
		timeStamp = signUp.getTimeStamp(); 
		String userName = Properties.userNameWithUnderScore+timeStamp;
		String password = RandomStringUtils.randomAscii(1);
		signUp.openSignUpPage();
		signUp.typeInEmail();
		signUp.typeInUserName(userName);
		signUp.typeInPassword(password);
		signUp.enterBirthDate("11", "11", "1954");
		signUp.enterBlurryWord();
		AlmostTherePageObject almostTherePage = signUp.submit();
		almostTherePage.verifyAlmostTherePage();
		ConfirmationPageObject confirmPageAlmostThere = almostTherePage.enterActivationLink();
		confirmPageAlmostThere.typeInUserName(userName);
		confirmPageAlmostThere.typeInPassword(password);
		UserProfilePageObject userProfile = confirmPageAlmostThere.clickSubmitButton();
		userProfile.verifyUserLoggedIn(userName);
		userProfile.verifyUserToolBar();	
		userProfile.verifyWelcomeEmail(userName);
	}
	
	@Test
	public void SignUpTC_005_fifty_character_password()
	{
		SignUpPageObject signUp = new SignUpPageObject(driver);
		timeStamp = signUp.getTimeStamp(); 
		String userName = Properties.userName+timeStamp;
		String password = RandomStringUtils.randomAscii(50);
		signUp.openSignUpPage();
		signUp.typeInEmail();
		signUp.typeInUserName(userName);
		signUp.typeInPassword(password);
		signUp.enterBirthDate("11", "11", "1954");
		signUp.enterBlurryWord();
		AlmostTherePageObject almostTherePage = signUp.submit();
		almostTherePage.verifyAlmostTherePage();
		ConfirmationPageObject confirmPageAlmostThere = almostTherePage.enterActivationLink();
		confirmPageAlmostThere.typeInUserName(userName);
		confirmPageAlmostThere.typeInPassword(password);
		UserProfilePageObject userProfile = confirmPageAlmostThere.clickSubmitButton();
		userProfile.verifyUserLoggedIn(userName);
		userProfile.verifyUserToolBar();	
		userProfile.verifyWelcomeEmail(userName);
	}
	
	
	@Test
	public void SignUpTC_006_lap_year()
	{
		SignUpPageObject signUp = new SignUpPageObject(driver);
		timeStamp = signUp.getTimeStamp(); 
		String userName = Properties.userName+timeStamp;
		String password = Properties.password+timeStamp;
		signUp.openSignUpPage();
		signUp.typeInEmail();
		signUp.typeInUserName(userName);
		signUp.typeInPassword(password);
		signUp.enterBirthDate("2", "29", "1988");
		signUp.enterBlurryWord();
		AlmostTherePageObject almostTherePage = signUp.submit();
		almostTherePage.verifyAlmostTherePage();
		ConfirmationPageObject confirmPageAlmostThere = almostTherePage.enterActivationLink();
		confirmPageAlmostThere.typeInUserName(userName);
		confirmPageAlmostThere.typeInPassword(password);
		UserProfilePageObject userProfile = confirmPageAlmostThere.clickSubmitButton();
		userProfile.verifyUserLoggedIn(userName);
		userProfile.verifyUserToolBar();	
		userProfile.verifyWelcomeEmail(userName);
	}
}
