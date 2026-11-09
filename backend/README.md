# Backend Finance Management

Backend REST API menggunakan PHP native dan PostgreSQL. Tidak memerlukan framework atau dependency Composer.

## Kebutuhan

- PHP 8.1 atau lebih baru
- Ekstensi PHP `pdo_pgsql` dan `mbstring`
- PostgreSQL serta `psql` (untuk menjalankan schema)

Pastikan ekstensi aktif dengan `php -m` dan cek `PDO` serta `pdo_pgsql` pada hasilnya.

## Setup lokal

1. Buat database PostgreSQL bernama `finance_management` atau ubah `DB_NAME` pada konfigurasi.
2. Salin `.env.example` menjadi `.env`, lalu isi kredensial PostgreSQL.
3. Jalankan schema dari root repository: `psql -U postgres -d finance_management -f backend/database/schema.sql`.
4. Jalankan API dari PowerShell:

   ```powershell
   cd backend
  php -S localhost:8000 -t public public/index.php
   ```

API tersedia di `http://localhost:8000`. Gunakan hostname `localhost` juga pada frontend agar cookie session `SameSite=Lax` berlaku lintas port. Pastikan `CORS_ORIGIN` sesuai origin frontend Vite, umumnya `http://localhost:5173`.

## Endpoint autentikasi

Semua response menggunakan JSON dengan format `{ "success": true|false, ... }`. Session disimpan dalam cookie `HttpOnly`; request dari browser harus menggunakan `credentials: 'include'`.

| Method | Endpoint | Fungsi |
| --- | --- | --- |
| `GET` | `/api/auth/csrf` | Membuat/mengambil token CSRF dan session cookie |
| `POST` | `/api/auth/register` | Membuat akun dengan `name`, `email`, `password`; langsung membuat session login |
| `POST` | `/api/auth/login` | Login dengan `email` dan `password` |
| `POST` | `/api/auth/logout` | Menghapus session |
| `GET` | `/api/auth/me` | Mengambil profil user yang sedang login |

Untuk setiap `POST`, kirim token dari endpoint CSRF pada header `X-CSRF-Token`. Setelah register/login, gunakan token baru yang dikembalikan di `data.csrfToken`.

```js
const csrfResponse = await fetch('http://localhost:8000/api/auth/csrf', {
  credentials: 'include',
});
const { data: { csrfToken } } = await csrfResponse.json();

const response = await fetch('http://localhost:8000/api/auth/login', {
  method: 'POST',
  credentials: 'include',
  headers: {
    'Content-Type': 'application/json',
    'X-CSRF-Token': csrfToken,
  },
  body: JSON.stringify({ email: 'user@example.com', password: 'password-anda' }),
});
```

Gunakan `SESSION_SECURE=true` saat API dijalankan melalui HTTPS. Jangan gunakan kredensial database contoh untuk deployment.