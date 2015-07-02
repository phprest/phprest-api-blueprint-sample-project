## Retrieve all the temperatures [GET /temperatures{?query,sort}]

+ Parameters

    + query: (string, optional)
    + sort: created (string, optional)

+ Request

    + Headers

            Accept: application/json

+ Response 200 (application/vnd.phprest-v0.1+json)

        [
            {
                "id": 2,
                "unit": "celsius",
                "value": 11,
                "created": "2015-01-02T15:10:10+0000",
                "_links": {
                    "self": {
                        "href": "/temperatures/2"
                    }
                }
            },
            {
                "id": 3,
                "unit": "celsius",
                "value": 12,
                "created": "2015-01-03T15:20:20+0000",
                "_links": {
                    "self": {
                        "href": "/temperatures/3"
                    }
                }
            },
            {
                "id": 4,
                "unit": "celsius",
                "value": 13,
                "created": "2015-01-04T15:30:30+0000",
                "_links": {
                    "self": {
                        "href": "/temperatures/4"
                    }
                }
            }
        ]
