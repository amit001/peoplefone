# Demo

## Installation:

1. Clone the repository

    ```bash
    git clone git@github.com:amit001/peoplefone.git
    ```

2. Install the requirements

    ```bash
    composer update
    ```

3. Create a database and update the `.env` file with the database credentials. For phone number validation, signup with [Ipqualityscore](https://www.ipqualityscore.com) and find API Key to be updated in .env variable IPQUALITYSCORE_KEY


4. Run the migrations

    ```bash
    php artisan migrate
    ```

5. Run the seeders

    ```bash
    php artisan db:seed --class=UserTableSeeder
    ```

6. Run the server

    ```bash
    php artisan serve
    ```

7. Navigate to "**User**" in the dashboard (homepage) to view or edit users. Click on "Impersonate" button under action column to impersonate that user view their unread notifications.

8. Navigate to "**Notifications > Create**" to post a new notification.