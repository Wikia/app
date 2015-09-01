Feature: Table

  Scenario: Insert table
    Given I go to the "Table Insert Test" page with content "Table Insert Test"
    When I click the insert table toolbar element
    Then the table should appear
