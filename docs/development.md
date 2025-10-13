# 🛠 Development Notes — Hamrah Gold

This document summarizes the development process, technologies used, and time spent on building the **Hamrah Gold** project.

---

## ⏱ Time Spent

| Layer      | Duration |
|------------|----------|
| Backend    | 3 hours  |
| Frontend   | 4 hours  |
| **Total** | 7 hours  |

---

## 🏗 Backend Development (3 hours)

**Technologies:** Laravel 11, PHP, MySQL, Postman  

**Tasks Completed:**
- Designed and implemented database schema using MySQL  
- Defined table relationships (One-to-Many, Many-to-Many where needed)  
- Created Eloquent models for all tables  
- Built controllers and API endpoints (RESTful)  
- Generated Resources for API responses  
- Added error handling and input validation  
- Tested APIs using Postman  
- Created migrations and seeders for initial data  

---

## 🎨 Frontend Development (4 hours)

**Technologies:** Vue 3, TypeScript, Pinia, Vuetify, Inertia.js, Vite  

**Tasks Completed:**
- Set up Vue 3 with TypeScript for type safety  
- Implemented Pinia for global state management  
- Designed UI with Vuetify components and layouts  
- Configured Inertia.js SPA architecture for smooth page transitions  
- Connected frontend components with backend APIs  
- Implemented toast notifications, forms, and input validation  
- Handled dynamic data rendering and reactive components  

---

## 🧩 Tech Stack Summary

| Layer | Technology |
|-------|------------|
| Backend | Laravel 11, PHP, MySQL |
| Frontend | Vue 3, TypeScript, Pinia, Vuetify, Inertia.js |
| Build Tool | Vite |
| Styling | Tailwind CSS |
| Tools | Postman for API testing, VS Code |

---

## 💡 Notes & Recommendations

- Backend endpoints are fully tested and validated  
- Frontend is modular, maintainable, and type-safe  
- Pinia store makes state management consistent across the app  
- Vuetify ensures consistent design system across all pages  
- All API requests are wrapped in reusable composables with error handling  
- Project setup can be replicated quickly with the provided `README.md` instructions  

---

*Documented by Majid Ataei — Fullstack Developer*
