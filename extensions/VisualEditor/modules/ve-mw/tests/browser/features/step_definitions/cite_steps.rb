Given(/^I open the Cite menu$/) do
  on(VisualEditorPage).cite_menu_element.when_present.click
end

When(/^I click Add more information$/) do
  on(VisualEditorPage).cite_add_more_information_button_element.when_present.click
end

When(/^I click Basic$/) do
  on(VisualEditorPage).cite_basic_reference_element.when_present.click
end

When(/^I click Book$/) do
  on(VisualEditorPage).cite_book_element.when_present.click
end

When(/^I click Insert Citation$/) do
  on(VisualEditorPage).insert_citation_element.when_present.click
end

When(/^I click Journal$/) do
  on(VisualEditorPage).cite_journal_element.when_present.click
end

When(/^I click News$/) do
  on(VisualEditorPage).cite_news_element.when_present.click
end

When(/^I click the new field label$/) do
  on(VisualEditorPage).cite_new_field_label_element.when_present.click
end

When(/^I click Website$/) do
  on(VisualEditorPage).cite_website_element.when_present.click
end

When(/^I fill in the first textarea with "(.*?)"$/) do |first_string|
  on(VisualEditorPage).cite_first_textarea_element.when_present.send_keys first_string
end

When(/^I fill in the second textarea with "(.*?)"$/) do |second_string|
  on(VisualEditorPage).cite_second_textarea_element.when_present.send_keys second_string
end

When(/^I fill in the third textarea with "(.*?)"$/) do |third_string|
  on(VisualEditorPage).cite_third_textarea_element.when_present.send_keys third_string
end

When(/^I fill in the fourth textarea with "(.*?)"$/) do |fourth_string|
  on(VisualEditorPage).cite_fourth_textarea_element.when_present.send_keys fourth_string
end

When(/^I fill in the fifth textarea with "(.*?)"$/) do |fifth_string|
  on(VisualEditorPage).cite_fifth_textarea_element.when_present.send_keys fifth_string
end

When(/^I fill in the sixth textarea with "(.*?)"$/) do |sixth_string|
  on(VisualEditorPage).cite_sixth_textarea_element.when_present.send_keys sixth_string
end

When(/^I fill in the seventh textarea with "(.*?)"$/) do |seventh_string|
  on(VisualEditorPage).cite_seventh_textarea_element.when_present.send_keys seventh_string
end

When(/^I fill in the eighth textarea with "(.*?)"$/) do |eighth_string|
  on(VisualEditorPage).cite_eighth_textarea_element.when_present.send_keys eighth_string
end

When(/^I fill in the new field "(.*?)"$/) do |new_field_text|
  on(VisualEditorPage).cite_new_website_field_element.when_present.send_keys new_field_text
end

When(/^I see Show more fields$/) do
  on(VisualEditorPage).cite_show_more_fields_element.when_present
end

When(/^I type in a field name "(.*?)"$/) do |custom_field|
  on(VisualEditorPage).cite_custom_field_name_element.when_present.send_keys custom_field
end

Then(/^diff view should show the Book citation added$/) do
  on(VisualEditorPage) do |page|
    page.wait_until(10) do
      sleep 1
      page.diff_view.include? 'Cite VisualEditor Test'
    end
    expect(page.diff_view).to match '<ref>{{Cite book|title = Book title|last = Book author last name|first = Book author first name|publisher = Book publisher|year = 2014|isbn = 9780743273565|location = Location of publication|pages = 123|New book field = New book field contents}}</ref>Cite VisualEditor Test'
  end
end

Then(/^diff view should show the Journal citation added$/) do
  on(VisualEditorPage) do |page|
    page.wait_until(10) do
      sleep 1
      page.diff_view.include? 'Cite VisualEditor Test'
    end
    expect(page.diff_view).to match '<ref>{{Cite journal|url = Journal title|title = Journal Source date|last = Journal Last Name|first = Journal First Name|date = Journal Source Date|journal = Journal Journal|accessdate = Journal Access Date|doi = Journal DOI}}</ref>Cite VisualEditor Test'
  end
end

Then(/^diff view should show the News citation added$/) do
  on(VisualEditorPage) do |page|
    page.wait_until(10) do
      sleep 1
      page.diff_view.include? 'Cite VisualEditor Test'
    end
    expect(page.diff_view).to match '<ref>{{Cite news|url = News URL|title = News Source title|last = News Last name|first = News First name|date = News Source date|work = News Work|accessdate = News URL access date}}</ref>Cite VisualEditor Test'
  end
end

Then(/^diff view should show the Website citation added$/) do
  on(VisualEditorPage) do |page|
    page.wait_until(10) do
      sleep 1
      page.diff_view.include? 'Cite VisualEditor Test'
    end
    expect(page.diff_view).to match '<ref>{{Cite web|url = http://en.wikipedia.org/|title = Website Source title|date = Website Source date 28 July 2014|accessdate = {{CURRENTMONTHNAME}} {{CURRENTYEAR}}28 July 2014|website = Website title|publisher = Website publisher|last = Website Last name|first = Website First name|New website field = New website field contents}}</ref>Cite VisualEditor Test'
  end
end

Then(/^I should see a Continue anyway button$/) do
  expect(on(VisualEditorPage).required_parameters_continue_anyway_element.when_present).to be_visible
end

Then(/^I should see a Go back button$/) do
  expect(on(VisualEditorPage).required_parameters_go_back_element.when_present).to be_visible
end

Then(/^I should see a Required parameters missing error$/) do
  expect(on(VisualEditorPage).required_parameters_missing_message_element.when_present).to be_visible
end

Then(/^I should see the General references$/) do
  expect(on(VisualEditorPage).cite_group_name_textarea_element).to be_visible
end

Then(/^I should see the Options use this group text$/) do
  expect(on(VisualEditorPage).cite_basic_options_area_element.text).to match(/Options.+Use this group/m)
end

Then(/^I should see the VisualEditor interface$/) do
  expect(on(VisualEditorPage).cite_visualeditor_user_interface_element).to be_visible
end

Then(/^the Book input field titles are in the correct order$/) do
  expect(on(VisualEditorPage).cite_ui).to match(/Title.+Last name.+First name.+Publisher.+Year of publication.+ISBN.+Location of publication.+Page/m)
end

Then(/^the Journal input field titles are in the correct order$/) do
  expect(on(VisualEditorPage).cite_ui).to match(/Title.+Source date/m)
end

Then(/^the News input field titles are in the correct order$/) do
  expect(on(VisualEditorPage).cite_ui).to match(/URL.+Source title.+Last name.+First name.+Source date.+Work.+URL access date/m)
end

Then(/^the Website input field titles are in the correct order$/) do
  expect(on(VisualEditorPage).cite_ui).to match(/URL.+Source title.+Source date.+URL access date.+Website title.+Publisher.+Last name.+First name/m)
end
