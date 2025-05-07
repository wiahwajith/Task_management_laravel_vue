# Task_management_laravel_vue
Task Management Application

# 📝 Task Management Application

A full-stack Task Management App built with **Laravel (Backend)** and **Vue 3 + Pinia (Frontend)**.

---

## 🚀 Features

- User registration & login (JWT-based)
- Secure task CRUD (Create, Read, Update, Delete)
- Filter tasks by status (All, Pending, Completed)
- Component-based Vue frontend with Pinia for state management
- Laravel REST API with proper request validation & authentication
- Clean, modular architecture

---

## 🛠️ Tech Stack

- **Frontend**: Vue 3, Pinia, Vue Router, Axios
- **Backend**: Laravel 10, MySQL (or SQLite), Laravel Sanctum/JWT
- **Auth**: JWT-based API authentication

---

## 📁 Folder Structure

/project-root
│
├── backend/ # Laravel app
│ ├── app/
│ ├── routes/
│ └── ...
│
├── frontend/ # Vue 3 + Pinia app
│ ├── src/
│ └── ...

yaml



---

## 🧰 Setup Instructions

### 🔧 Backend (Laravel)

1. Navigate to the `backend` folder:
   ```bash
   cd backend
Install dependencies:


composer install
 .env and set DB credentials:


cp .env.example .env
Generate app key:



php artisan key:generate
Migrate and seed:


php artisan migrate --seed
Run backend server:


php artisan serve
💻 Frontend (Vue)
Navigate to frontend folder:


cd frontend
Install dependencies:


npm install
Run Vue app:


npm run dev
🔐 Auth Flow
Register/Login → Get JWT token

Token stored in localStorage

All API calls are authenticated via Bearer token

📦 API Endpoints (Laravel)
Method	Endpoint	Description
POST	/api/register	Register new user
POST	/api/login	Login & get JWT token
GET	/api/tasks?status=completed	List tasks (with filter)
POST	/api/tasks	Create new task
PUT	/api/tasks/{id}	Update task
DELETE	/api/tasks/{id}	Delete task
PATCH	/api/tasks/{id}/complete	Mark task as complete

🌐 CORS Issue?
Enable CORS in Laravel with:



composer require fruitcake/laravel-cors
Then publish config and allow your frontend origin.

📄 License
MIT – Free to use and modify!
