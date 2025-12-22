# 🚀 Laravel Google Drive & Sheets Importer

A powerful Laravel application that imports product data directly from **Google Drive** and **Google Sheets** using **Google OAuth 2.0** and **Laravel Excel**.  
Designed to handle **large datasets efficiently** with queued jobs, chunk reading, and progress tracking.

---

## ✨ Features

- 🔐 Google OAuth 2.0 authentication
- 📁 Browse and select files from Google Drive
- 📊 Import data from Google Sheets
- ⚡ Queue-based imports for large files
- 📦 Chunk reading for memory efficiency
- 📈 Import progress tracking
- 🧩 Clean and scalable Laravel architecture

---

## 🛠 Tech Stack

- Laravel 10+
- PHP 8.2+
- Laravel Excel (Maatwebsite)
- Google Drive API
- Google Sheets API
- MySQL / MariaDB
- Laravel Queue (Database Driver)

---

## 📋 Prerequisites

Ensure you have the following installed:

- PHP 8.2 or higher
- Composer
- MySQL or MariaDB
- Node.js & NPM (optional)
- Google Cloud Project with:
  - Google Drive API enabled
  - Google Sheets API enabled
  - OAuth 2.0 credentials

---

## 📥 Installation

### 1️⃣ Clone the Repository

```bash
git clone https://github.com/your-username/your-repo-name.git
cd your-repo-name

2️⃣ Install Dependencies
composer install
npm install
npm run dev

3️⃣ Environment Setup
cp .env.example .env
php artisan key:generate

4️⃣ Configure .env

Update your .env file with the following values:

APP_NAME=Laravel
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

QUEUE_CONNECTION=database

GOOGLE_CLIENT_ID=your_google_client_id
GOOGLE_CLIENT_SECRET=your_google_client_secret
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback

5️⃣ Database & Storage Setup
php artisan migrate
php artisan storage:link

6️⃣ Queue Configuration

Create queue table (if not already created):

php artisan queue:table
php artisan migrate


Start the queue worker:

php artisan queue:work


⚠️ Queue worker must be running for imports to work.

7️⃣ Run the Application
php artisan serve


Application will be available at:

👉 http://localhost:8000

🔐 Google OAuth Setup

Go to Google Cloud Console

Create or select a project

Enable:

Google Drive API

Google Sheets API

Create OAuth 2.0 Client ID

Add this redirect URI:

http://localhost:8000/auth/google/callback


Copy the Client ID and Client Secret into your .env file

📊 Import Workflow

Login using Google OAuth

Select a Google Sheet from Drive

Start import

Import runs as a queued job

Data is processed using chunk reading

Import status is tracked in real time

🧪 Queue Notes

This project uses the database queue driver

For production, use Supervisor to keep queue workers alive

📌 Future Enhancements

WebSocket-based real-time progress

CSV & Excel file uploads

Import validation & error reporting UI

Multi-sheet import support

🤝 Contributing

Contributions are welcome!

Fork the repository

Create a feature branch

Submit a pull request

📄 License

This project is open-sourced under the MIT License.