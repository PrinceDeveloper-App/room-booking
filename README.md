# 🏢 Room Booking System (Prototype)

## 📌 Description

This project is a web-based **room booking system** that allows users to reserve time slots for a single room in a **daily view**.

---

## ⚙️ Technologies Used

* **PHP (CodeIgniter)** – backend framework  
* **SQLite** – lightweight database for persistence  
* **Bootstrap 5** – responsive UI  
* **jQuery / AJAX** – dynamic interaction  
* **REST API** – programmatic access to bookings  

---

## 🚀 Features

* 📅 **Day view with hourly time slots** (07:00–21:00)  
* ✅ **Visual distinction** between available (green) and booked (red) slots  
* 📝 **Create bookings** with name and optional purpose  
* ❌ **Cancel bookings** via a secure, unique link with a **dedicated cancellation interface**  
* 🔒 **Prevents double bookings** with time overlap validation  
* ⏱ **Booking duration**: 1–6 hours  
* 📆 **Booking window**: up to 7 days in advance  
* ⚡ **AJAX-based booking** – no page reload  
* 🔌 **REST API endpoints** for programmatic integration  

---

## 🏗️ Architecture

The application follows the **MVC pattern**:

* **Controller** → handles HTTP requests  
* **Model** → database operations  
* **View** → UI rendering  

Additionally, a **Service Layer (`BookingService`)** encapsulates business logic, ensuring **separation of concerns**.

---

## ▶️ Setup Instructions

### Option 1: Local (XAMPP/WAMP)

1. Clone the repository:

   ```bash
   git clone https://github.com/PrinceDeveloper-App/room-booking.git
   ```
2. Move it into your web server root (e.g., `htdocs`)  
3. Configure `base_url` in `application/config/config.php`  
4. Ensure SQLite extension is enabled in PHP  
5. Open in browser:

   ```
   http://localhost:8080/room-booking/
   ```

---

## 📦 REST API

### 1. Get Bookings by Date

**Request:**  
```GET /api/bookings?date=YYYY-MM-DD```

**Example:**  
```GET /api/bookings?2026-04-08```

**Response:**

```json
{
  "status": "success",
  "bookings": [
    {
      "id": 1,
      "name": "John",
      "start_time": "2026-04-08 12:00:00",
      "end_time": "2026-04-08 14:00:00",
      "cancel_token": "9a7f4c1b2e3d4f5a6b7c8d9e0f1a2b3c"
    }
  ]
}
```

### 2. Create Booking

**Request:**  
```POST /api/bookings/create```

**Body Example:**

```json
{
  "name": "John",
  "start_time": "2026-04-08 12:00:00",
  "duration": 2
}
```

**Response:**

```json
{
  "status": "success",
  "cancel_link": "http://localhost:8080/booking/cancel/9a7f4c1b2e3d4f5a6b7c8d9e0f1a2b3c"
}
```

### 3. Cancel Booking

**Request:**  
```POST /api/bookings/cancel/{token}```

**Response:**

```json
{
  "status": "success",
  "message": "Booking cancelled"
}
```

## 🤖 AI Tools Used

* **ChatGPT / Claude-Code**  
  - Generated boilerplate code  
  - Designed validation logic  
  - Structured API endpoints  

---

## ⚠️ Limitations

* Single room only  
* No authentication system  
* Basic UI (no drag & drop calendar)  
* No concurrency locking (advanced DB handling)  

---

## 💡 Future Improvements

* Multi-room support  
* User Dashboard for managing bookings (view, edit, extend)  
* User authentication system  
* Drag & drop calendar interface  
* Real-time updates via WebSockets  

---

## 🏆 Key Design Decisions

* SQLite chosen for **simplicity and portability**  
* **Service layer** added for maintainability  
* **Secure token-based cancellation** implemented  
* **Overlap detection** ensures no double bookings  
* AJAX and REST API for **modern, responsive UX**  

---

## 👨‍💻 Author

**Prince Mathew**

