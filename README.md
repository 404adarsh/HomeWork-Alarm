# HomeWork-Alarm 📚⏰

HomeWork-Alarm is a complete school management platform where principals, teachers, students, and parents can stay connected.  
The system allows easy management of homework, attendance, announcements, chat, payments (recording only), and more.

---

## 🌟 Key Features
- **Multi-role access:** Principals can create accounts for their teachers and students.  
- **Homework Notifications:** Teachers can send homework and important notices directly to students.  
- **Fee Management (recording only):** Schools can record fee submissions, and students can view payment status on their dashboard. *(No payment gateway like Razorpay is integrated.)*  
- **Attendance Tracking:** Teachers can mark daily attendance which students/parents can see.  
- **Chat System:** Students and teachers can interact in a safe, structured chat environment.  
- **Announcements:** Admins can share important messages and highlight updates.  
- **Games & Fun:** A playful module where students can play simple games.  
- **Secure Login:** Different roles (Owner, Admin, Teacher, Student) with authentication.  

---

## 🛠️ Database Schema
The platform uses MySQL for storing data with tables for:
- **Admins**
- **Announcements**
- **Attendance**
- **Chat**
- **Games & Moves**
- **Owners (School/Coaching Details)**
- **Payments** *(records only — no gateway integration)*
- **Students**
- **Teachers**

(Full `CREATE TABLE` statements are included in the repository — keep them in `schema.sql`.)

---

## 🚀 How It Works
1. **Principal/Owner Registration** – School principal or coaching owner registers and adds details.  
2. **Teacher & Student Onboarding** – Principals add teachers and students under their school ID.  
3. **Daily Operations**  
   - Teachers send homework notifications.  
   - Attendance marked for each class.  
   - Fee records updated and shown on student dashboards.  
4. **Parents & Students** – Parents and students can track homework, announcements, attendance, and fee status online.  

---

## 🧑‍💻 Tech Stack
- **Backend:** PHP / MySQL  
- **Frontend:** HTML, CSS, JavaScript (Bootstrap used in pages)  
- **Database:** MySQL / MariaDB  
- **Mailing:** PHPMailer (via Composer)  
- **Authentication:** Role-based login (Owner/Admin/Teacher/Student)  

---

## 📌 Use Cases
- Schools, Colleges, and Coaching Institutes.  
- Principals/Owners managing multiple teachers & students.  
- Parents wanting transparency in homework & fee tracking.  
- Students accessing all information in one dashboard.  

---

## 🔮 Future Enhancements
- Parent Login Panel  
- Online Payment Gateway Integration (planned, not implemented)  
- Real-time Notifications via Mobile App  
- AI-based Homework Suggestions  

---


---

## ✉️ PHPMailer — How to get a Gmail App Password (for sending OTPs/emails)
> Use App Passwords with Gmail + 2-Step Verification. Do **not** use your regular Gmail password in code. App Passwords are required for third-party apps (or use OAuth2).

**Step-by-step (Gmail):**
1. Sign in to the Google account you will send emails from (e.g., `your.email@gmail.com`).  
2. Go to **Google Account → Security**.  
3. Under **"Signing in to Google"**, enable **2-Step Verification** (if not already enabled). Follow the prompts and complete setup.  
4. After 2-Step Verification is enabled, return to **Security** → **"Signing in to Google"** → click **App passwords**.  
5. In the App passwords page:
   - Select **Mail** as the app.
   - Choose a device (or select **Other (Custom name)** and enter `HomeWork-Alarm`), then click **Generate**.  
6. Google shows a 16-character app password. **Copy it now** — this is the value you will use in PHPMailer as the SMTP password.

**How to use the App Password in PHPMailer (example):**
```php
$mail->isSMTP();
$mail->Host       = 'smtp.gmail.com';
$mail->SMTPAuth   = true;
$mail->Username   = 'your.email@gmail.com';        // your Gmail address
$mail->Password   = 'xxxxxxxxxxxxxxxx';            // the 16-char App Password from Google
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port       = 587;

$mail->setFrom('your.email@gmail.com', 'HomeWorkAlarm');
$mail->addAddress($userEmail);
