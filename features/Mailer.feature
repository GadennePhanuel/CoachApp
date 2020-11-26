Feature:
  try send email

  Scenario: send empty Email
    When I add "Content-Type" header equal to "application/ld+json"
    And I add "Accept" header equal to "application/ld+json"
    And I authenticate using the email address "user@test.fr" having the role "ROLE_ADMIN"
    And I send a "POST" request to "/api/sendEmail" with body:
        """
        {
          "email": {
                "receivers": "",
                "subject": "",
                "message": ""
                }
        }
        """
    Then the response status code should be 400
    And the response should be in JSON
    And the JSON node "success" should be false


  Scenario: Successfully send Email
    When I add "Content-Type" header equal to "application/ld+json"
    And I add "Accept" header equal to "application/ld+json"
    And I authenticate using the email address "user@test.fr" having the role "ROLE_ADMIN"
    And I send a "POST" request to "/api/sendEmail" with body:
        """
        {
          "email": {
                "receivers": "phanuelgadenne@yahoo.fr;mathdelage@gmail.com;nique@test.fr",
                "subject": "Test a la con",
                "message": "Petit message a la con"
                }
        }
        """
    Then the response status code should be 200
    And the response should be in JSON
    And the JSON node "success" should be true