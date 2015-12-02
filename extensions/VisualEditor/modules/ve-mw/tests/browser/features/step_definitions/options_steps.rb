When(/^I click Advanced Settings$/) do
  on(VisualEditorPage).option_advanced_settings_element.when_present.click
end

When(/^I click Categories$/) do
  on(VisualEditorPage).options_categories_element.when_present.click
end

When(/^I click Options$/) do
  on(VisualEditorPage).options_in_hamburger_element.when_present.click
end

When(/^I click Page Settings$/) do
  on(VisualEditorPage).option_page_settings_element.when_present.click
end

When(/^I click the hamburger menu$/) do
  on(VisualEditorPage).hamburger_menu_element.when_present.click
end

When(/^I see options overlay$/) do
  on(VisualEditorPage).options_page_title_element.when_present
end

Then(/^I should see the options overlay$/) do
  expect(on(VisualEditorPage).options_page_title_element.when_present).to be_visible
end

Then(/^the options overlay should display Advanced Settings$/) do
  expect(on(VisualEditorPage).options_settings_content_advanced_element).to be_visible
end

Then(/^the options overlay should display Categories$/) do
  expect(on(VisualEditorPage).options_settings_content_categories_element).to be_visible
end

Then(/^the options overlay should display Page Settings$/) do
  expect(on(VisualEditorPage).options_settings_content_page_settings_element).to be_visible
end

When(/^I click Yes for Indexed by Search Engines$/) do
  on(VisualEditorPage).option_to_set_index_by_search_element.when_present.click
end

When(/^I click Yes for showing tab for adding new section$/) do
  on(VisualEditorPage).option_to_show_new_section_tab_element.when_present.click
end

When(/^I check the option for Enable display title$/) do
  on(VisualEditorPage).check_option_to_enable_display_title
end

When(/^I type "(.*?)" for display title textbox$/) do |display_title_text|
  on(VisualEditorPage).display_title_textbox_element.when_present.send_keys(display_title_text)
end

When(/^I click Apply Changes button$/) do
  on(VisualEditorPage).apply_changes_button_element.when_present.click
end

Then(/^the options set in Advanced Settings panel should appear in diff view$/) do
  on(VisualEditorPage) do |page|
    page.wait_until(10) do
      page.diff_view.include? 'automated test'
    end
    expect(page.diff_view).to match /{{DISPLAYTITLE:automated test}}.+Options VisualEditor Test.+__INDEX__.+__NEWSECTIONLINK__/m
  end
end
