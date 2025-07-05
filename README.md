[SETUP]
git clone https://github.com/rafvdwp/Test-Eval-Fullstack-Dev.git
cd Test-Eval-Fullstack-Dev
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve

[ERD]
Users (admin, manager, staff)
Tasks (title, description, status, due_date, user_id)
Logs (user_id, action, timestamp)

[Fitur]
- Login berbasis Sanctum API
- Task Dashboard (per role)
- Admin Panel (CRUD User)
- Validasi Form
- Logging aktivitas (middleware)

[Screenshot]
![image](https://github.com/user-attachments/assets/5abf60b8-d7d4-4635-bcb0-09c3ff815fb7)
![image](https://github.com/user-attachments/assets/b0ac7967-97ae-41bd-982d-292b553a7f2d)

*Test API
![image](https://github.com/user-attachments/assets/f4d08d91-478c-4de9-a052-3b0bf81ff3df)
![image](https://github.com/user-attachments/assets/70716303-1322-463d-9a7f-4fcf76e9e5d7)
