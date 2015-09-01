When(/^I clear the confirm dialog by clicking Keep changes$/) do
  on(VisualEditorPage).confirm_switch_element.when_present.click
end

When(/^I click Edit for VisualEditor from this page$/) do
  on(VisualEditorPage) do |page|
    page.alert do
      page.edit_ve_element.when_present.click
    end
  end
end

When(/^I click the Switch to source editing menu option$/) do
  on(VisualEditorPage) do |page|
    page.alert do
      page.tools_menu_element.when_present.click
      page.switch_to_source_editing_element.when_present.click
    end
  end
end

When(/^I enter the wikitext editor$/) do
  on(VisualEditorPage) do |page|
    page.edit_wikitext_element.when_present.click
    step 'I clear the confirm dialog by clicking Keep changes'
    page.wikitext_editor_element.when_present
  end
end

When(/^I see the Cancel option$/) do
  on(VisualEditorPage).confirm_switch_cancel_on_switch_element.when_present
end

When(/^I see the Discard option$/) do
  on(VisualEditorPage).confirm_switch_discard_element.when_present
end

When(/^I see the wikitext editor$/) do
  on(VisualEditorPage).wikitext_editor_element.when_present(10)
end

Then(/^I should be in Visual Editor editing alternate mode$/) do
  on(VisualEditorPage) do |page|
    page.wait_until(15) do
      page.text.include? 'Edit page for'
    end
    expect(page.content_element.when_present).to be_visible
  end
end

Then(/^I should be in Visual Editor editing mode$/) do
  on(VisualEditorPage) do |page|
    page.wait_until(15) do
      page.text.include? 'Edit page for'
    end
  end
  expect(browser.url).to match(%r{w/index\.php\?title=Edit_page_for_#{browser_name}&veaction=edit})
end

Then(/^I should be in wikitext editing mode$/) do
  on(VisualEditorPage) do |page|
    page.wait_until(15) do
      page.text.include? 'Editing Edit page for'
    end
  end
  expect(browser.url).to eq(wiki_url("Edit page for #{browser_name}?action=submit"))
end
