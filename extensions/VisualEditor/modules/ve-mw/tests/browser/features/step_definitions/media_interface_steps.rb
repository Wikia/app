When(/^I click Media$/) do
  on(VisualEditorPage) do |page|
    page.insert_menu_element.when_present.click
    page.ve_media_menu_element.when_present.click
  end
end

When(/^I enter (.+) into media Search box$/) do |content|
  on(VisualEditorPage).media_search_element.when_present.send_keys(content)
end

When(/^I select an Image$/) do
  on(VisualEditorPage).media_select_element.when_present.click
end

Then(/^(.+) should appear in the media diff view$/) do |headings_string|
  on(VisualEditorPage) do |page|
    # Contents pulled from the Cucumber tables in the .feature are escaped regexes.
    # In this case we want unescaped regexes (and in one case a leading space)
    # So we put single quotes around the entries in the .feature file and strip them here to get unescaped regexes.
    headings_string = headings_string.gsub(/'/, '')
    page.wait_until(15) do
      page.diff_view.include? 'Your text'
    end
    expect(page.diff_view).to match headings_string
  end
end

Then(/^I can click the X on the media save box$/) do
  on(VisualEditorPage).media_exit_element.when_present.click
end
