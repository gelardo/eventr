# Event Reminder App

A Laravel-based event reminder application with offline support and CSV import functionality.

## Features

- Create and manage events with reminder functionality
- Custom event reminder ID generation
- Offline support with automatic sync when online Email reminders to attendees
- CSV import for bulk event creation
- Upcoming and completed events view
- Responsive UI using Tailwind CSS

## To - Do

- Offline Integration with Service Worker

## Requirements

- PHP 8.1 or higher
- Composer
- Node.js and NPM
- Laravel 10.x
- Sqlite/Mysql

## Installation

1. Clone the repository
```bash
git clone https://github.com/gelardo/eventr.git
cd eventr
```

2. Install PHP dependencies
```bash
composer install
```

3. Copy the environment file and configure your database
```bash
cp .env.example .env
php artisan key:generate
```

4. Configure your database in the .env file
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=event_reminder
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

5. Configure mail settings in .env for email reminders
```
MAIL_MAILER=smtp
MAIL_HOST=your_mail_host
MAIL_PORT=587
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_email
MAIL_FROM_NAME="${APP_NAME}"
```

6. Run migrations
```bash
php artisan migrate
```

7. Run 
```bash
npm run dev
```

7. Start the development server
```bash
php artisan serve
```


## Usage

### Creating Events
1. Fill out the event creation form with:
   - Title
   - Description (optional)
   - Start date/time
   - End date/time
   - Attendee emails (comma-separated)

### Importing Events
1. Prepare a CSV file with the following headers:
   - title
   - description
   - start_datetime
   - end_datetime
   - attendees (comma-separated emails and All emails must be enclosed within double quote)

2. Use the Import Events section to upload your CSV file


## Development


### For testing Queue Worker for Email Dispatch 
```bash
php artisan queue:work
```

### For Event Reminder Email add a cronjob for everymin, a schedular is placed in routes/console.php to run the task at midnight
```bash
* * * * * php /path-to-your-project/artisan schedule:run >> /dev/null 2>&1
```

