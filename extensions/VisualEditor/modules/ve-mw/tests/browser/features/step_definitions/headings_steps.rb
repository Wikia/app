When(/^I click Heading$/) do
  on(VisualEditorPage).heading_element.when_present.click
end

When(/^I click Page title$/) do
  on(VisualEditorPage).page_title_element.when_present.click
end

When(/^I click Paragraph$/) do
  on(VisualEditorPage).paragraph_element.when_present.click
end

When(/^I click Preformatted$/) do
  on(VisualEditorPage).preformatted_element.when_present.click
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

When(/^I click the down arrow on the Headings menu$/) do
  on(VisualEditorPage).format_indicator_down_element.when_present.click
end
