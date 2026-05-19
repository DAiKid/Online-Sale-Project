## Getting Started

Follow these steps to set up and run the project locally on your machine.

1. Install Backend Dependencies
    composer install

2. Install Frontend Dependencies & Build Assets

    npm install
    npm run dev

3. Setup Environment Configuration
Copy the .env.example file to create your local .env file:

Windows (CMD): copy .env.example .env

Mac/Linux: cp .env.example .env

Open the .env file and configure your database settings
This project supports Google/GitHub login. To test this feature, please generate your own credentials from the respective developer consoles and update the fields in the .env file.

4. Generate Application Key
    php artisan key:generate

5. Create a blank database in your local MySQL server, connect DB connection in .env file and then run
    php artisan migrate

6. Link Storage (Optional but Recommended)
To ensure uploaded files and images display correctly in the browser, link the storage folder:

    php artisan storage:link

7. Run the Application
Start the Laravel local development server:

    php artisan serve
