Given(/^I go to the browser specific edit page page$/) do
  page_title = "Edit page for " + ENV['BROWSER']
  page_content = "Edit page for " + ENV['BROWSER']
  on(APIPage).create page_title, page_content
  step "I am on the #{page_title} page"
end

Given(/^I am on the (.+) page$/) do |article|
  article = article.gsub(/ /, '_')
  visit(ZtargetPage, :using_params => {:article_name => article})
end

Given(/^I go to the "(.+)" page with content "(.+)"$/) do |page_title, page_content|
  @wikitext = page_content
  on(APIPage).create page_title, page_content
  step "I am on the #{page_title} page"
end

Given(/^I click in the editable part$/) do
  on(VisualEditorPage).content_element.when_present.send_keys("")
end

Given(/^I make the text "(.*?)" be selected$/) do |select_text|
  on(VisualEditorPage).content_element.when_present.click
  require "watir-webdriver/extensions/select_text"
  on(VisualEditorPage).content_element.when_present.select_text select_text
  sleep 1 # turn the sleep on if this test fails with bullet/number in front of string NOT "This is.."
end

When(/^I click Review and Save$/) do
  on(VisualEditorPage) do |page|
    page.container_disabled_element.when_not_visible.should_not exist
    page.review_and_save_element.when_visible.click
  end
end

When(/^I click Looks good to me$/) do
  on(VisualEditorPage) do |page|
    page.diff_view_element.when_visible.should be_visible
    page.looks_good_element.click
  end
end

When(/^I click This is a minor edit$/) do
  #FIXME TEMPORARILY COMMENT THIS OUT WHILE WE FIGURE OUT WHY USERS GET LOGGED OUT
  #on(VisualEditorPage).minor_edit_element.when_present(10).click
end

When(/^I click Save page$/) do
  on(VisualEditorPage) do |page|
    sleep 2 # blame Chris for this!
    page.save_page_element.when_present.click
  end
end

When(/^I click Save page the second time$/) do
    on(VisualEditorPage).second_save_page_element.when_present.click
end

When(/^I do not see This is a minor edit$/) do
  on(VisualEditorPage).minor_edit_element.should_not be_visible
end

When(/^I edit the page with (.+)$/) do |input_string|
  on(VisualEditorPage) do |page|
    page.content_element.when_present(10).fire_event("onfocus")
    page.content_element.when_present.send_keys(input_string + " #{@random_string} ")
  end
end

When(/^I click Return to save form$/) do
  on(VisualEditorPage) do |page|
    page.diff_view_element.when_present(10)
    page.return_to_save_element.when_present(10).click
  end
end

When(/^I click Review your changes$/) do
  on(VisualEditorPage).review_changes_element.when_present(10).click
end

When(/^I edit the description of the change$/) do
  on(VisualEditorPage).describe_change_element.when_visible.send_keys("Describing with #{@random_string}")
end

When(/^I see the IP warning signs$/) do
  on(VisualEditorPage).ip_warning.should match Regexp.escape("Your IP address")
end

Then(/^Page text should contain (.+)$/) do |output_string|
  on(VisualEditorPage).page_text_element.when_present.text.should match Regexp.escape(output_string + " #{@random_string}")
end

Then(/^I can click the X on the save box$/) do
  on(VisualEditorPage).ex_element.when_present.click
end