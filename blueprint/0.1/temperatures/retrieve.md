## Retrieve a temperature [GET /temperatures/{id}]

+ Parameters

    + id: 2 (number)

+ Request

    + Headers

            Accept: application/json

+ Response 200 (application/vnd.phprest-v0.1+json)

        {
            "id": 2,
            "unit": "celsius",
            "value": 11,
            "created": "2015-01-02T15:10:10+00:00",
            "_links": {
                "self": {
                    "href": "/temperatures/2"
                }
            }
        }
