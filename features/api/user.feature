@user
Feature: User management
  As an administrator, I should be able to manage users.

  Background:
    Given I authenticate myself as admin

  Scenario: Get a collection
    When I send a GET request to "/api/users"
    Then the response status code should be 200
    And I should get a paged collection with the context "/api/contexts/User"

  Scenario: Get a resource
    When I send a GET request to "/api/users/21"
    Then the response status code should be 200
    And the JSON should be equal to:
    """
    {
        "@context": "/api/contexts/User",
        "@id": "/api/users/21",
        "@type": "User",
        "createdAt": "2014-12-31T22:00:00+00:00",
        "endingSchoolYear": null,
        "fullname": null,
        "jobs": [
            {
                "@id": "/api/jobs/77",
                "@type": "Job",
                "abbreviation": "GRND",
                "mandate": null,
                "title": "Resident Mastermind"
            }
        ],
        "organizationEmail": null,
        "studentConvention": {
            "@id": "/api/student_conventions/GILMIC20100227",
            "@type": "StudentConvention",
            "dateOfSignature": "2010-02-26T22:36:59+00:00"
        },
        "types": [
            "TYPE_CONTRACTOR",
            "TYPE_MEMBER"
        ],
        "updatedAt": "2015-06-09T20:00:00+00:00",
        "username": "Hebert.Paul",
        "email": "Leconte.Yves@Lenoir.fr",
        "roles": [
            "ROLE_USER"
        ],
        "enabled": true
    }
    """

  Scenario: Filter users by type
    When I send a GET request to "/api/users?filter[where][type]=contractor"
    Then the response status code should be 200
    And I should get a paged collection with the context "/api/contexts/User"
    And the JSON node "hydra:totalItems" should be equal to 44
    And the JSON node "types" of the objects of the JSON node "hydra:member" should contains "TYPE_CONTRACTOR"

  Scenario: Filter users by mandate
    When I send a GET request to "/api/users?filter[where][mandate]=/api/mandates/5"
    Then the response status code should be 200
    And I should get a paged collection with the context "/api/contexts/User"
    And the JSON node "hydra:totalItems" should be equal to 8
    And all the users should have a mandate with the value "/api/mandates/5"
