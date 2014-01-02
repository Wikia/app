When(/^I click the down arrow on Headings interface$/) do
  on(VisualEditorPage).downarrow_element.when_present.click
end

When(/^I click Paragraph$/) do
  on(VisualEditorPage).paragraph_element.when_present.click
end

Then(/^(.+) should appear in the diff view$/) do |headings_string|
  on(VisualEditorPage) do |page|
    # Contents pulled from the Cucumber tables in the .feature are escaped regexes.
    # In this case we want unescaped regexes (and in one case a leading space)
    # So we put single quotes around the entries in the .feature file and strip them here to get unescaped regexes.
    headings_string = headings_string.gsub(/'/, '')
    page.wait_until(10) do
      page.paragraph_diff_view.include? "Your text"
    end
    page.paragraph_diff_view.should match Regexp.new(headings_string)
  end
end

Then(/^I can click the up arrow on the save box$/) do
  on(VisualEditorPage).uparrow_element.when_present.click
end

When(/^I click Heading$/) do
  on(VisualEditorPage).heading_element.when_present.click
end

When(/^I click Subheading1$/) do
  on(VisualEditorPage).subheading1_element.when_present.click
end

When(/^I click Subheading2$/) do
  on(VisualEditorPage).subheading2_element.when_present.click
end

When(/^I click Subheading3$/) do
  on(VisualEditorPage).subheading3_element.when_present.click
end

When(/^I click Subheading4$/) do
  on(VisualEditorPage).subheading4_element.when_present.click
end

When(/^I click Preformatted$/) do
  on(VisualEditorPage).preformatted_element.when_present.click
end

 When(/^I click Page title$/) do
  on(VisualEditorPage).page_title_element.when_present.click
end
