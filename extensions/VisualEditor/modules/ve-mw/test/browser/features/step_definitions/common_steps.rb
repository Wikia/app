Given(/^I am logged in$/) do
  visit(LoginPage).login_with(@mediawiki_username, @mediawiki_password)
end
