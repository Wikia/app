Given(/^I am on the (.+) page$/) do |article|
  article = article.gsub(/ /, '_')
  visit(ZtargetPage, using_params: { article_name: article })
end

Given(/^I click in the editable part$/) do
  on(VisualEditorPage).content_element.when_present.send_keys('')
end

Given(/^I go to the browser specific edit page page$/) do
  page_title = 'Edit page for ' + browser_name
  page_content = 'Edit page for ' + browser_name

  api.create_page page_title, page_content
  step "I am on the #{page_title} page"
end

Given(/^I go to the "(.+)" page with content "(.+)"$/) do |page_title, page_content|
  @wikitext = page_content
  api.create_page page_title, page_content
  step "I am on the #{page_title} page"
end

Given(/^I make the text "(.*?)" be selected$/) do |select_text|
  on(VisualEditorPage) do |page|
    page.content_element.when_present.click
    require 'watir-webdriver/extensions/select_text'
    page.content_element.when_present.select_text select_text
  end
end

When(/^I click Edit for VisualEditor$/) do
  on(VisualEditorPage) do |page|
    page.edit_ve_element.when_present.click
    page.content_element.when_present.click
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

When(/^I click Save page$/) do
  on(VisualEditorPage) do |page|
    page.save_page_element.when_present.click
  end
end

When(/^I click Save page the second time$/) do
  on(VisualEditorPage) do |page|
    page.second_save_page_element.when_present.click
    page.second_save_page_element.when_not_present
  end
end

When(/^I click This is a minor edit$/) do
  on(VisualEditorPage).minor_edit_element.when_present.click
end

When(/^I do not see This is a minor edit$/) do
  on(VisualEditorPage).minor_edit_element.when_not_present
end

When(/^I edit the description of the change$/) do
  on(VisualEditorPage).describe_change_element.when_visible.send_keys("Describing with #{@random_string}")
end

When(/^I edit the page with (.+)$/) do |input_string|
  on(VisualEditorPage) do |page|
    page.page_text_element.when_not_visible
    page.content_element.when_present(10).send_keys(input_string + " #{@random_string} ")
  end
end

When(/^I see the IP warning signs$/) do
  on(VisualEditorPage).ip_warning_element.when_present
end

Then(/^I can click Cancel save$/) do
  on(VisualEditorPage).confirm_switch_cancel_element.when_present.click
end

Then(/^I can click the X on the save box$/) do
  on(VisualEditorPage).ex_element.when_present.click
end

Then(/^Page text should contain (.+)$/) do |output_string|
  expect(on(VisualEditorPage).page_text_element.when_present.text).to match Regexp.escape(output_string + " #{@random_string}")
end

Then(/^(.+) should appear in the diff view$/) do |headings_string|
  on(VisualEditorPage) do |page|
    # Contents pulled from the Cucumber tables in the .feature are escaped regexes.
    # In this case we want unescaped regexes (and in one case a leading space)
    # So we put single quotes around the entries in the .feature file and strip them here to get unescaped regexes.
    headings_string = headings_string.gsub(/"/, '')
    page.wait_until(10) do
      page.diff_view.include? 'Your text'
    end
    expect(page.diff_view).to match headings_string
  end
end
