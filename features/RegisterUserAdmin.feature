Feature:
  Scenario: Call a not found route
    When I add "Content-Type" header equal to "application/json"
    And I send a "GET" request to "/api/v1/not-found-route"
    Then the response status code should be 404

  Scenario: Try to register a user with missing "lastName" field
    When I add "Content-Type" header equal to "application/ld+json"
    And I add "Accept" header equal to "application/ld+json"
    And I send a "POST" request to "/api/users" with body:
        """
        {
            "roles": ["ROLE_ADMIN"],
            "firstName": "jhon",
            "email": "jhon.doe@gmail.com",
            "password": "pass59",
            "passwordConfirm": "pass59",
            "phone": "1234560712",
            "birthday": "12-12-1990"
        }
        """
    Then the response status code should be 400
    And the response should be in JSON
    Then print last JSON response
    And the JSON node "hydra:description" should be equal to the string "lastName: le nom de famille est obligatoire"
#
  Scenario: Successfully register a new user
    When I add "Content-Type" header equal to "application/ld+json"
    And I add "Accept" header equal to "application/ld+json"
    And I send a "POST" request to "/api/users" with body:
        """
        {
            "roles": ["ROLE_ADMIN"],
            "firstName": "jhon",
            "lastName": "doe",
            "email": "jhon.doe@gmail.com",
            "password": "pass59",
            "passwordConfirm": "pass59",
            "phone": "1234561212",
            "birthday": "12/12/1990"
        }
        """
    Then the response status code should be 201
    And the response should be in JSON
    Then print last JSON response
    And the JSON node "id" should not be null
    And the JSON node "email" should be equal to the string "jhon.doe@gmail.com"
        ### The following is not recommended, only to see our FeatureContext in work
    And the JSON node "id" should be greater than the number 0
    And the JSON node "firstName" length should be 4

  Scenario: Successfully register new Admin
    When I add "Content-Type" header equal to "application/ld+json"
    And I add "Accept" header equal to "application/ld+json"
    And I send a "POST" request to "/api/admins" with body:
        """
        {
            "user": "/api/users/1"
        }
        """
    Then the response status code should be 201
    And the response should be in JSON
    Then print last JSON response
    And the JSON node "id" should not be null


  Scenario: Dump the response (To debug for example - Here the email is already used)
    When I add "Content-Type" header equal to "application/ld+json"
    And I add "Accept" header equal to "application/ld+json"
    And I send a "POST" request to "/api/users" with body:
        """
        {
            "roles": ["ROLE_ADMIN"],
            "firstName": "jhon",
            "lastName": "doe",
            "email": "jhon.doe@gmail.com",
            "password": "test-pass-59",
            "passwordConfirm": "test-pass-59",
            "phone": "1234561212",
            "birthday": "12/12/1990"
        }
        """
    Then dump the response
