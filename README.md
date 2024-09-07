Blog


This is a Blog application that allows users to create, edit, and comment on articles. Users can also manage their profiles, including uploading profile pictures. The application is built using Laravel and JavaScript, with a PostgreSQL database for storing data.

Features


User Authentication: Users can register and log in.
Create and Edit Articles: Logged-in users can create new articles, edit existing ones, upload files, and update titles and descriptions.
Commenting System: Users can comment on articles and delete their own comments.
Profile Management: Users can edit their profiles and upload a profile picture.
Responsive Design: The blog is designed to be responsive and user-friendly on various devices.
Installation
Prerequisites
Before you begin, ensure you have the following installed:

PHP (>= 8.0)
Composer
Node.js & npm
PostgreSQL
Git

Clone the repository: 

git clone https://github.com/yourusername/blog.git
cd blog


Install PHP dependencies using Composer:

composer install

Install JavaScript dependencies using npm:

npm install

Copy the .env.example file to .env:

cp .env.example .env

Update the .env file with your database and other environment settings:

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password

Generate the application key:

php artisan key:generate

Run database migrations:

php artisan migrate

Serve the application:

php artisan serve

The application should now be running at http://127.0.0.1:8000/

You can register a new user account, log in, and start using the blog features.

Contributing
If you'd like to contribute, please fork the repository and use a feature branch. Pull requests are warmly welcome.

License
This project is open-source and available under the MIT License.
