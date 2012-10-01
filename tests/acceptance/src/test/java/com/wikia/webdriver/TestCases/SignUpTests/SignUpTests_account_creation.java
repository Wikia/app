package com.wikia.webdriver.TestCases.SignUpTests;

import java.io.IOException;

import org.apache.commons.lang.RandomStringUtils;
import org.testng.annotations.Test;

import com.wikia.webdriver.Common.Properties.Properties;
import com.wikia.webdriver.Common.Templates.TestTemplate;
import com.wikia.webdriver.PageObjects.PageObject.SignUp.AlmostTherePageObject;
import com.wikia.webdriver.PageObjects.PageObject.SignUp.ConfirmationPageObject;
import com.wikia.webdriver.PageObjects.PageObject.SignUp.SignUpPageObject;
import com.wikia.webdriver.PageObjects.PageObject.SignUp.UserProfilePageObject;

public class SignUpTests_account_creation extends TestTemplate
{
	private String timeStamp;
	
	
	/*
	 * 3.30 Test Case 2.3.01 Sign up page: Account creation Non latin username
	 * https://internal.wikia-inc.com/wiki/Global_Log_in_and_Sign_up/Test_Cases:_Sign_up  
	 * */
	@Test(groups = {"SignUp_account_creation_TC_001", "SignUp", "Smoke"})
	public void SignUp_account_creation_TC_001_non_latin_user_name() throws IOException
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
	

	/*
	 * 3.32 Test Case 2.3.03 Sign up page: Account creation Fifty character Username
	 * https://internal.wikia-inc.com/wiki/Global_Log_in_and_Sign_up/Test_Cases:_Sign_up  
	 * */
	@Test(groups = {"SignUp_account_creation_TC_002", "SignUp"})
	public void SignUp_account_creation_TC_002_fifty_character_user_name()
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
	

	/*
	 * 3.33 Test Case 2.3.04 Sign up page: Account creation Username contains a backward slash
	 * https://internal.wikia-inc.com/wiki/Global_Log_in_and_Sign_up/Test_Cases:_Sign_up  
	 * */
	@Test(groups = {"SignUp_account_creation_TC_003", "SignUp"})
	public void SignUp_account_creation_TC_003_backward_slash_user_name()
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
	
	/*
	 * 3.34 Test Case 2.3.05 Sign up page: Account creation Username contains an underscore
	 * 3.36 Test Case 2.3.07 Sign up page: Account creation Password is 1 character
	 * https://internal.wikia-inc.com/wiki/Global_Log_in_and_Sign_up/Test_Cases:_Sign_up  
	 * */
	@Test(groups = {"SignUp_account_creation_TC_004", "SignUp"})
	public void SignUp_account_creation_TC_004_one_char_password()
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
	

	/*
	 * 3.37 Test Case 2.3.08 Sign up page: Account creation Password is 50 characters
	 * https://internal.wikia-inc.com/wiki/Global_Log_in_and_Sign_up/Test_Cases:_Sign_up  
	 * */
	@Test(groups = {"SignUp_account_creation__005", "SignUp", "Smoke"})
	public void SignUp_account_creation_TC_005_fifty_character_password()
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
	
	/*
	 * 3.38 Test Case 2.3.09 Sign up page: Account creation Birthdate 29-Feb and leap year
	 * https://internal.wikia-inc.com/wiki/Global_Log_in_and_Sign_up/Test_Cases:_Sign_up  
	 * */
	@Test(groups = {"SignUp_account_creation_TC_006", "SignUp"})
	public void SignUp_account_creation_TC_006_lap_year()
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
