Given(/^I create a new user (.+) with password (.+)$/) do |username, password|
  create_user username, password
end

Given (/^I create a new wiki article (.+) with content (.+)$/) do |title, content|
  create_article "Selenium_user", "test1234", title, content
end

When(/^I login with username (.+) and password (.+)$/) do |name, pwd|
  visit(LoginPage).login_with(name, pwd)
end

When(/^I visit (.+) via the UI$/) do |page_title|
  visit(UserPage, :using_params => {:page => page_title})
end
