# 📚 Lectura – Virtual Learning Environment (VLE)

Lectura is a **web-based Virtual Learning Environment (VLE)** designed to improve how educational institutions manage **study materials, assignments, grading, and academic progress**.  
The system was developed as an **undergraduate Software Engineering project (SWE6010)** and is tailored to address real challenges faced by schools that rely on informal communication tools such as WhatsApp and email.

Lectura provides a **secure, role-based platform** for **students, teachers, parents, and administrators**, ensuring organized access to learning resources while complying with modern **data protection and privacy standards**.

---

## 📖 Introduction

Many schools still rely on informal digital tools for sharing learning materials and assignments. While popular, these tools are **not designed for education**, leading to:

- Disorganized study materials
- Lost or misplaced assignments
- Delayed grading
- Limited parental visibility
- Poor academic tracking

Lectura was created to solve these problems by offering a **centralized, secure, and scalable learning platform**. It supports **blended learning**, improves collaboration, and ensures **data security**.

---

## 🎯 Project Objectives

- Improve organization and accessibility of study materials
- Enable secure online assignment submission and grading
- Provide role-based dashboards for all users
- Allow parents to monitor their child’s academic progress
- Build a scalable system that supports future enhancements

---

## ✨ Key Features

### 👩‍🎓 Student Features

- Secure login and personalized dashboard
- Access and download study materials
- Online assignment submission
- View grades and feedback
- Receive notifications for deadlines and updates

### 👨‍🏫 Teacher Features

- Upload and manage study materials
- Create, manage, and grade assignments
- Provide feedback to students
- Track student submissions and performance

### 👨‍👩‍👧 Parent Features

- Monitor child’s academic progress
- View grades and assignment status
- Receive academic notifications
- Communicate with teachers

### 🛠️ Admin Features

- User management (students, teachers, parents)
- Manage subjects, curriculums, grade levels, and sections
- Role-based access control
- Enroll and create new students and users

### 🔐 Security & System Features

- Role-based authentication and authorization
- Password hashing and secure data storage
- Route and view protection
- Notification system with queueing

---

## 🛠️ Tools & Technologies Used

### Backend

- **PHP (Laravel Framework)**
- **MySQL**

### Frontend

- **Blade Templates**
- **Bootstrap 5**
- **Select2**
- **FilePond**

### Development & Testing

- **Laragon** (Local server environment)
- **Visual Studio Code**

### Design

- **Figma** (UI/UX Design)

---

## ⚙️ Installation Guide

### Prerequisites

Make sure you have the following installed:

- PHP (>= 8.1 recommended)
- Composer
- MySQL
- Laragon or any local server (XAMPP/WAMP)
- Pusher API Keys
- Mailpit or any mail testing tool (Mailtrap/MailHog)

---

# ⚙️ **Installation**

### 1. Clone the repository

     git clone https://github.com/Mustafa21102005/lectura.git

### 2. Open the project in Your Preferred Text Editor

- Open the project folder in a text editor or IDE of your choice (e.g., VS Code, PhpStorm).

### 3. Rename `.env.example` to `.env`

- In the project root, rename the `.env.example` file to `.env`.
- Insert your **database connection information** and other environment-specific configurations in the `.env` file like **email connection** and **pusher api keys**.

### 4. Install PHP Dependencies

- Open your terminal and navigate to the project directory.
- Run the following command to install PHP dependencies:

    ```
    composer install
    ```

### 5. Generate Application Key

- Next, generate the application key by running:

    ```
    php artisan key:generate
    ```

### 6. Run Database Migrations and Seeders

- To set up the database schema and seed your database with initial data, run the following command:

    ```
    php artisan migrate --seed
    ```

### 7. Run Laravel Schedule

- To start the automation of scanning for assignment and send automated emails to students:

    ```
    php artisan schedule:work
    ```

### 8. Run Laravel Queues

- To start the queues and send emails to users:

    ```
    php artisan queue:work
    ```

### 9. Run the Project

- Finally, you can start the development server by running:

    ```
    php artisan serve
    ```

- Your application will be live at `http://127.0.0.1:8000`.

### 🎉 You're Ready to Go!

Now you can start using the project! 🎉

---

## 🔑 Demo Accounts

You can use the following demo credentials to test each role in the system:

| Role    | Email             | Password |
| ------- | ----------------- | -------- |
| Admin   | admin@gmail.com   | password |
| Teacher | teacher@gmail.com | password |
| Student | student@gmail.com | password |
| Parent  | parent@gmail.com  | password |
