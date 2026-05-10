===============================
AIR QUALITY INDEX (AQI) WEB APPLICATION
===============================

This repository contains a full-stack web application designed to provide air quality updates across various cities and divisions in Bangladesh. The project features a user registration and login system, a dynamic dashboard for selecting locations, and a personalized user interface based on stored preferences.

-------------------------------
FEATURES
-------------------------------

**User Authentication**
- Secure system for user registration and login

**Registration**
- Client-side validation for AIUB student emails
- Strong password requirements
- Zip code format validation

**Login**
- Server-side verification against MySQL database

**Location-Based Updates**
- Users can select up to 10 cities
- View real-time or stored AQI data

**Personalization**
- Uses cookies to store “Favorite Color”
- Dynamically updates dashboard theme after login

**Database Integration**
- MySQL backend (aqi database)
- Stores user profiles, credentials, and geographic data

-------------------------------
TECHNICAL STACK
-------------------------------

**Frontend**
- HTML5
- CSS3 (Flexbox / Grid)
- JavaScript (ES6) for form validation

**Backend**
- PHP (server-side logic, session management, database interaction)

**Database**
- MySQL
- Prepared statements for SQL injection protection

-------------------------------
PROJECT STRUCTURE
-------------------------------

- Index.php → Landing page with registration & login
- box3.js → Client-side validation logic
- process.php → Handles form submission and database insertion
- login.php / logout.php → Session and authentication management
- request.php → Main dashboard for AQI city selection and display
