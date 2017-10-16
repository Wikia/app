@chrome @en.wikipedia.beta.wmflabs.org @firefox @internet_explorer_10 @safari @test2.wikipedia.org
Feature: VisualEditor Headings

  Background:
    Given I go to the "Headings VisualEditor Test" page with content "Headings VisualEditor Test"
      And I make the text "Headings VisualEditor Test" be selected

  Scenario Outline: Cycle through headings values
    When I click the down arrow on Headings interface
      And I click <headings_interface_name>
      And I click Save page
      And I click Review your changes
    Then <headings_string> should appear in the diff view
      And I can click the X on the save box
  Examples:
    | headings_interface_name | headings_string                      |
    | Heading                 | "^== Headings VisualEditor Test"     |
    | Subheading1             | "^=== Headings VisualEditor Test"    |
    | Subheading2             | "^==== Headings VisualEditor Test"   |
    | Subheading3             | "^===== Headings VisualEditor Test"  |
    | Subheading4             | "^====== Headings VisualEditor Test" |
    | Preformatted            | " Headings VisualEditor Test"        |
    | Page title              | "^= Headings VisualEditor Test"      |
