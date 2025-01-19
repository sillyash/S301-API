# Routes

## GET

- `/` : returns the list of all the routes
- `/test/env` : returns the environment variables and PHP constants (useful for debugging)
- `/data` : returns data from the database
  - `?table=vin` : returns the data from the table `Vin`
  - `?rows=10` : returns the 10 first rows (optional)

## POST

- `/proposition` : inserts a Proposition in the database
  - The title and description of the proposition should be passed in the `php://input` stream as JSON.
  - Example:
    ```json
    {
      "title": "New Proposition",
      "description": "Description of the new proposition"
    }
    ```

## PUT



## DELETE



