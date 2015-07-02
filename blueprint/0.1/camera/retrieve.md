## Retrieve the current state of the Camera [GET]

+ Request

    + Headers

            Accept: application/json

+ Response 200 (application/vnd.phprest-v0.1+json)

        {
            "state": "on",
            "_links": {
                "self": {
                    "href": "/camera"
                },
                "transition.off::post": {
                    "href": "/camera?transition=off"
                }
            }
        }
