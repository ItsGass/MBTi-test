# MBTI Insight

Aplikasi tes kepribadian berbasis MBTI: 40 pernyataan, empat dimensi, 16 tipe, matriks kecocokan, dan sertifikat hasil yang bisa diunduh sebagai PNG. Dibangun dengan Laravel, Blade, dan Tailwind CSS — tanpa login, tanpa akun, dan seluruh hasil tersimpan pada tautan bertoken.

---

## Quick Start

Untuk yang sudah terbiasa dengan Laravel (detail lengkap ada di bawah):

```bash
git clone <URL_REPOSITORY> mbti-insight
cd mbti-insight
composer install
cp .env.example .env
php artisan key:generate
# buat database test_mbti, lalu sesuaikan DB_* di .env
php artisan migrate --seed
npm install
npm run build
composer run dev
```

Buka `http://localhost:8000`. Di Windows, ganti `cp` dengan `copy`.

---

## Fitur Utama

- **Tes 40 pernyataan** — 10 item per dimensi (E/I, S/N, T/F, J/P), skala Likert 1–5, 5 soal per halaman, progres tersimpan otomatis.
- **Skoring seimbang** — setiap dimensi memuat 5 item positif dan 5 item negatif, sehingga menjawab "setuju" pada semua soal tidak menggeser hasil.
- **Halaman hasil** — kode tipe, kekuatan sinyal, persentase keempat dimensi, kekuatan, area pengembangan, rekomendasi karier, dan 3 tipe paling cocok.
- **Katalog 16 tipe** — kartu interaktif dengan ilustrasi chibi SVG unik per tipe (tanpa file gambar eksternal).
- **Kompatibilitas** — matriks skor antar tipe beserta label kecocokan.
- **Sertifikat PNG** — kanvas landscape 1200 × 850 px, diekspor 2× menjadi 2400 × 1700 px melalui html2canvas.
- **Desain pastel responsif** — cream, charcoal, lilac, blush, sky, dan mint; setiap dimensi punya warna tetap di seluruh halaman.
- **Tanpa akun** — sesi tes diakses lewat token pada URL; sertifikat memakai `noindex, nofollow`.

---

## Tech Stack

### Backend

| Teknologi | Versi | Peran |
|---|---|---|
| PHP | `^8.3` (terpasang 8.3.19) | Bahasa aplikasi |
| Laravel Framework | `^13.17` (terpasang 13.39.0) | Routing, Eloquent, Blade, validasi, middleware, scheduler |
| Laravel Tinker | `^3.0` | REPL untuk inspeksi data |
| Eloquent ORM | bawaan Laravel | Relasi `UserTest → TestResult`, `MbtiType`, `Question` |
| Blade | bawaan Laravel | Template dan komponen view |
| Laravel Scheduler | bawaan Laravel | Perintah `mbti:expire-sessions` tiap jam |

Logika domain dipisahkan dari controller di `app/Services/Mbti`:

- `MbtiScorer` — menghitung skor empat dimensi dan kode tipe.
- `CompatibilityMatcher` — mengambil tipe paling cocok berdasarkan skor.
- `AnswerRecorder` — menyimpan jawaban per posisi.
- `TestSessionFactory` — membuat sesi tes beserta token.
- `ScoreResult` — objek nilai hasil skoring.

### Database

| Teknologi | Peran |
|---|---|
| MySQL 8 / MariaDB 10.6+ | Database aplikasi (default `test_mbti`) |
| SQLite `:memory:` | Database test (diatur di `phpunit.xml`, tidak menyentuh MySQL) |

Tabel inti: `users`, `cache`, `jobs`, `mbti_types`, `questions`, `question_variants`, `user_tests`, `test_answers`, `test_results`. Sesi, cache, dan queue memakai driver `database` secara default.

### Frontend

| Teknologi | Versi | Peran |
|---|---|---|
| Blade Components | — | `chibi`, `dimension-label`, `dimension-bar`, `type-card`, `question-card` |
| Tailwind CSS | `^4.0` (terpasang 4.3.3) | Utility-first styling, token `@theme` |
| Vite | `^8.0` (terpasang 8.3.5) | Bundling aset dan dev server |
| laravel-vite-plugin | `^3.1` | Integrasi Vite dengan Blade (`@vite`) |
| Instrument Sans | Bunny Fonts | Font utama, diunduh saat build lewat plugin Vite |
| JavaScript (ES modules) | — | `ui.js`, `test-runner.js`, `certificate.js` |
| html2canvas | `^1.4.1` | Render sertifikat menjadi PNG di browser |

Tidak ada framework JS (React/Vue/Alpine). Interaksi memakai JavaScript vanilla: salin tautan, picker kecocokan, autosave jawaban, dan ekspor sertifikat.

### Testing & Tooling

| Teknologi | Versi | Peran |
|---|---|---|
| Pest | `^4.7` (4.7.8) | Test runner utama |
| pest-plugin-laravel | `^4.1` | Helper HTTP test Laravel |
| PHPUnit | bawaan Pest | Basis assertion |
| Faker | `^1.23` | Data palsu untuk factory |
| Mockery | `^1.6` | Mock objek |
| Collision | `^8.6` | Output error CLI yang rapi |
| Laravel Pint | `^1.27` | Formatter PHP (preset Laravel) |
| Laravel Boost | `^2.2` | Aturan & skill untuk AI coding agent |
| Laravel Pail | `^1.2` | Tail log aplikasi |
| Laravel Pao | `^1.0` | Integrasi agent/IDE |
| Composer | 2.x | Manajemen dependensi PHP |
| npm | 10+ | Manajemen dependensi JS |

---

## Persyaratan Sistem

| Kebutuhan | Minimum |
|---|---|
| PHP | 8.3 |
| Composer | 2.2 (disarankan 2.8+) |
| Node.js | 20.19+ atau 22.12+ (syarat Vite 8) |
| npm | 10+ |
| MySQL | 8.0+ / MariaDB 10.6+ (opsional: SQLite) |
| Git | opsional (untuk metode clone) |
| Browser | Chrome, Edge, Firefox, atau Safari versi terbaru |

Ekstensi PHP yang wajib aktif:

```text
ctype, curl, dom, fileinfo, filter, hash, mbstring, openssl,
pcre, pdo, pdo_mysql, session, tokenizer, xml
```

Cek cepat:

```bash
php -v
php -m
composer -V
node -v
npm -v
```

Jika memakai Laragon/XAMPP, pastikan ekstensi `pdo_mysql`, `mbstring`, `openssl`, dan `fileinfo` tidak dikomentari di `php.ini`.

---

## Instalasi

Ada dua cara: **clone repository** atau **unduh ZIP**. Keduanya berakhir di langkah yang sama (database → `.env` → migrasi → build → jalankan).

### Cara 1 — Clone

```bash
git clone <URL_REPOSITORY> mbti-insight
cd mbti-insight
composer install
```

> Ganti `<URL_REPOSITORY>` dengan URL repository Anda.

Salin file environment:

```bash
# Linux / macOS
cp .env.example .env

# Windows Command Prompt
copy .env.example .env

# Windows PowerShell
Copy-Item .env.example .env
```

Buat application key:

```bash
php artisan key:generate
```

Lanjut ke [Membuat Database](#membuat-database), lalu [Konfigurasi .env](#konfigurasi-env). Setelah database siap:

```bash
php artisan migrate --seed
npm install
npm run build
composer run dev
```

Butuh langkah otomatis? Setelah `composer install` dan database dibuat, lihat [Shortcut: `composer run setup`](#shortcut-composer-run-setup).

### Cara 2 — ZIP

1. Unduh ZIP repository, lalu ekstrak ke folder tanpa spasi, misalnya `C:\laragon\www\mbti-insight` atau `~/Projects/mbti-insight`.
2. Pastikan isi folder memuat `artisan`, `composer.json`, `composer.lock`, `package.json`, dan folder `app/`. Jika setelah ekstrak ada folder bernama `mbti-insight-main/`, masuk ke folder tersebut.
3. Buka terminal di folder itu, lalu:

```bash
composer install
```

4. Salin environment dan buat key seperti pada cara clone:

```bash
copy .env.example .env      # Windows
cp .env.example .env        # Linux / macOS
php artisan key:generate
```

5. Lanjut ke [Membuat Database](#membuat-database) dan [Konfigurasi .env](#konfigurasi-env).
6. Isi data dan build aset:

```bash
php artisan migrate --seed
npm install
npm run build
```

7. Jalankan:

```bash
php artisan serve
```

**Catatan ZIP:** arsip biasanya **tidak** menyertakan `vendor/`, `node_modules/`, `.env`, dan `public/build` (semuanya ada di `.gitignore`). Karena itu `composer install`, `npm install`, dan `npm run build` wajib dijalankan. Jika muncul `Failed opening required 'vendor/autoload.php'`, berarti `composer install` belum dijalankan.

**Update dari ZIP:** backup `.env` dan database, ekstrak versi baru, lalu jalankan `composer install`, `php artisan migrate`, `npm install`, dan `npm run build`. Jangan menimpa `.env` lama.

### Shortcut: `composer run setup`

Setelah clone atau ekstrak ZIP, sebagian langkah bisa dijalankan otomatis:

```bash
composer run setup
php artisan db:seed
```

Skrip melakukan: `composer install` → salin `.env` (jika belum ada) → `key:generate` → `migrate --force` → `npm install --ignore-scripts` → `npm run build`.

**Peringatan:** database harus sudah dibuat dan `.env` sudah benar sebelum skrip dijalankan, dan skrip **tidak** melakukan seeding. Tanpa `db:seed`, katalog tipe dan pertanyaan akan kosong.

---

## Membuat Database

### MySQL / MariaDB

```sql
CREATE DATABASE test_mbti
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;
```

Lewat terminal:

```bash
mysql -u root -p -e "CREATE DATABASE test_mbti CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

Ingin nama lain? Ganti `DB_DATABASE` di `.env` sesuai nama database Anda.

### Alternatif SQLite

```bash
# Linux / macOS
touch database/database.sqlite

# Windows Command Prompt
type nul > database\database.sqlite
```

Lalu di `.env`:

```dotenv
DB_CONNECTION=sqlite
# DB_DATABASE=            # kosongkan untuk memakai database/database.sqlite
```

---

## Konfigurasi .env

Minimal yang perlu diperiksa:

| Variabel | Contoh | Keterangan |
|---|---|---|
| `APP_NAME` | `"MBTI Insight"` | Nama aplikasi |
| `APP_ENV` | `local` | `production` saat deploy |
| `APP_KEY` | `base64:...` | Wajib; hasil `php artisan key:generate` |
| `APP_DEBUG` | `true` | `false` di produksi |
| `APP_URL` | `http://localhost:8000` | Dipakai untuk URL absolut |
| `APP_TIMEZONE` | `Asia/Jakarta` | Zona waktu tanggal hasil/sertifikat |
| `DB_CONNECTION` | `mysql` | `mysql` atau `sqlite` |
| `DB_HOST` | `127.0.0.1` | Host database |
| `DB_PORT` | `3306` | Port MySQL |
| `DB_DATABASE` | `test_mbti` | Nama database |
| `DB_USERNAME` | `root` | User database |
| `DB_PASSWORD` | *(kosong)* | Password database |
| `SESSION_DRIVER` | `database` | Butuh tabel `sessions` dari migrasi |
| `CACHE_STORE` | `database` | Cache default |
| `QUEUE_CONNECTION` | `database` | Dev runner menjalankan queue listener |
| `MAIL_MAILER` | `log` | Tidak ada email keluar secara default |

`APP_LOCALE` bawaan `en`, sementara copy aplikasi berbahasa Indonesia. Tanggal memakai locale Carbon; ubah `APP_LOCALE=id` bila ingin nama bulan Indonesia.

Jangan pernah commit `.env` atau membagikan `APP_KEY`.

---

## Migrasi & Seed

```bash
php artisan migrate --seed
```

Yang dibuat/diisi:

- 9 tabel (user, cache, jobs, tipe MBTI, pertanyaan, varian, sesi tes, jawaban, hasil).
- **16 tipe MBTI** beserta deskripsi, kekuatan, kelemahan, karier, dan skor kecocokan.
- **40 pertanyaan** (10 per dimensi) dengan **120 varian** (3 varian per pertanyaan).

Mulai dari nol (menghapus semua data):

```bash
php artisan migrate:fresh --seed
```

Hanya mengisi data referensi (aman diulang karena seeder memakai update-or-create):

```bash
php artisan db:seed
```

Setelah mengubah `.env` atau config:

```bash
php artisan config:clear
php artisan view:clear
```

---

## Menjalankan Aplikasi

### Satu perintah (disarankan)

```bash
composer run dev
```

Perintah ini menjalankan `php artisan dev` yang menyalakan tiga proses sekaligus:

1. `php artisan serve` — server di `http://localhost:8000`
2. `php artisan queue:listen --tries=1 --timeout=0` — worker queue
3. `npm run dev` — Vite dev server dengan hot reload

Buka `http://localhost:8000`.

### Dua terminal

```bash
# Terminal 1
php artisan serve

# Terminal 2
npm run dev
```

Jika port 8000 dipakai proses lain:

```bash
php artisan serve --port=8080
```

Pastikan `APP_URL` disesuaikan agar tautan hasil dan sertifikat benar.

---

## Build & Deployment

### Build aset

```bash
npm run build
```

Hasil ada di `public/build` dan bersifat generated — jangan diedit manual.

### Checklist produksi

```dotenv
APP_ENV=production
APP_DEBUG=false
APP_URL=https://domain-anda.com
```

```bash
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan optimize
npm ci
npm run build
```

- Document root web server harus mengarah ke folder `public/`, bukan root proyek.
- Folder `storage/` dan `bootstrap/cache/` harus writable:

```bash
chmod -R ug+rwx storage bootstrap/cache
```

- Scheduler (perintah `mbti:expire-sessions` berjalan tiap jam):

```cron
* * * * * cd /path/ke/mbti-insight && php artisan schedule:run >> /dev/null 2>&1
```

- Queue worker bila nanti menambah job:

```bash
php artisan queue:work --tries=3
```

- Jangan mengekspos `.env`, `storage/logs`, atau `database/*.sqlite` ke publik.

### Dev runner vs produksi

`composer run dev` hanya untuk pengembangan (Vite dev server, queue listener, debug). Di produksi gunakan build statis dan web server biasa.

---

## Perintah Harian

| Perintah | Fungsi |
|---|---|
| `php artisan test --compact` | Menjalankan seluruh test |
| `php artisan test --filter=NamaTest` | Menjalankan satu test |
| `vendor/bin/pest tests/Feature/CertificateTest.php` | Menjalankan satu file test |
| `vendor/bin/pint --format agent` | Merapikan format PHP |
| `vendor/bin/pint --test` | Cek format tanpa mengubah file |
| `php artisan pail` | Tail log real-time |
| `php artisan route:list` | Daftar route |
| `php artisan schedule:work` | Scheduler lokal |
| `php artisan mbti:expire-sessions` | Tandai sesi tes kedaluwarsa |
| `php artisan tinker` | REPL Laravel |
| `php artisan optimize:clear` | Bersihkan cache config/route/view |

Test memakai SQLite `:memory:` sehingga tidak membutuhkan MySQL dan tidak menghapus data development.

---

## Struktur Direktori

```text
app/
├─ Console/Commands/ExpireTestSessions.php   # mbti:expire-sessions
├─ Enums/
│  ├─ Dimension.php                          # EI, SN, TF, JP
│  └─ SessionStatus.php                      # in_progress, completed, expired
├─ Http/
│  ├─ Controllers/                           # Page, TestSession, Answer, Result,
│  │                                         # TypeProfile, Compatibility
│  └─ Middleware/EnsureTestIsActive.php      # alias "test.active"
├─ Models/                                   # MbtiType, Question, QuestionVariant,
│                                            # UserTest, TestAnswer, TestResult, User
├─ Services/Mbti/                            # MbtiScorer, CompatibilityMatcher,
│                                            # AnswerRecorder, TestSessionFactory, ScoreResult
└─ Providers/

config/
├─ mbti.php                                  # soal, Likert, dimensi, palette, chibi, sertifikat
└─ ...                                       # config Laravel standar

database/
├─ migrations/                               # 9 migrasi
├─ seeders/                                  # MbtiTypeSeeder, QuestionSeeder
├─ factories/                                # factory untuk semua model
└─ seeders/data/                             # data tipe & pertanyaan

resources/
├─ css/app.css                               # Tailwind v4 + token warna
├─ js/
│  ├─ app.js                                 # entry point
│  ├─ ui.js                                  # salin tautan, picker kecocokan
│  ├─ test-runner.js                         # autosave & navigasi soal
│  └─ certificate.js                         # ekspor PNG (html2canvas)
└─ views/
   ├─ layouts/app.blade.php
   ├─ components/                            # chibi, dimension-label, dimension-bar,
   │                                         # type-card, question-card
   └─ pages/
      ├─ home.blade.php
      ├─ test/                               # start, show, expired
      ├─ result/                             # show, certificate
      ├─ types/                              # index, show
      └─ compatibility/                      # index, show

routes/web.php
tests/Feature/                               # Certificate, Compatibility, ContentIntegrity,
                                             # DimensionTone, PageSmoke, TestFlow
tests/Unit/MbtiScorerTest.php
```

---

## Rute Aplikasi

| Method | URI | Name | Fungsi |
|---|---|---|---|
| GET | `/` | `home` | Landing page |
| GET | `/tes/mulai` | `test.create` | Form nama & umur |
| POST | `/tes` | `test.store` | Buat sesi tes (throttle 10/menit) |
| GET | `/tes/{userTest}` | `test.show` | Halaman soal |
| PATCH | `/tes/{userTest}/jawaban` | `test.answers` | Simpan jawaban (throttle 120/menit) |
| POST | `/tes/{userTest}/selesai` | `test.submit` | Hitung skor & simpan hasil |
| GET | `/hasil/{userTest}` | `result.show` | Halaman hasil |
| GET | `/hasil/{userTest}/sertifikat` | `result.certificate` | Halaman unduh sertifikat |
| GET | `/tipe` | `types.index` | Katalog 16 tipe |
| GET | `/tipe/{mbtiType}` | `types.show` | Profil tipe |
| GET | `/kecocokan` | `compatibility.index` | Pilih dua tipe |
| GET | `/kecocokan/{left}/{right}` | `compatibility.show` | Detail kecocokan |

`{userTest}` adalah ULID, bukan ID berurutan. Perlakukan URL hasil sebagai rahasia karena siapa pun yang memegang tautan dapat membuka hasil.

---

## Alur Singkat

1. `GET /tes/mulai` → isi nama (umur opsional) → `POST /tes` membuat `UserTest` berstatus `in_progress` dengan token dan masa aktif 24 jam.
2. Setiap halaman menampilkan 5 soal; `PATCH .../jawaban` menyimpan jawaban dan progres.
3. `POST .../selesai` menjalankan `MbtiScorer`, menyimpan `TestResult`, lalu mengubah status menjadi `completed`.
4. Hasil dapat dibuka kapan saja lewat `/hasil/{token}`; sertifikat dirender di browser dan diunduh sebagai PNG 2400 × 1700.
5. Sesi yang tidak diselesaikan dalam 24 jam ditandai `expired` oleh `mbti:expire-sessions`.

---

## Kustomisasi

### `config/mbti.php`

| Key | Isi |
|---|---|
| `questions` | Total 40, 10 per dimensi, 5 per halaman, 5 per arah |
| `likert` | Skala 1–5 beserta label panjang dan pendek |
| `dimensions` | Label, kutub, judul, deskripsi, dan `tone` warna per dimensi |
| `session_ttl_hours` | Masa aktif sesi tes (24 jam) |
| `tie_break` | Aturan saat skor dimensi imbang |
| `scoring_version` | Versi algoritma skoring yang disimpan di hasil |
| `compatibility` | Jumlah rekomendasi dan band label kecocokan |
| `certificate` | Ukuran 1200 × 850, `scale` 2, jumlah karier 4, kecocokan 3, batas nama/karier |
| `palette` | Hex cream, ink, line, dan triad lilac/blush/sky/mint |
| `chibi` | Definisi karakter per kode tipe: tone, rambut, gaya rambut, outfit, prop, kacamata, warna kulit |

### Tampilan

- Token warna Tailwind ada di `resources/css/app.css` bagian `@theme`.
- Label dimensi memakai `resources/views/components/dimension-label.blade.php` (`@switch` per tone).
- Ilustrasi tipe memakai `resources/views/components/chibi.blade.php` (SVG inline, 16 prop berbeda).
- Sertifikat ada di `resources/views/pages/result/certificate.blade.php`; gunakan inline hex dan hindari `overflow: hidden` pada elemen teks karena html2canvas memotong descender.

### Menambah/mengubah pertanyaan

Ubah `database/seeders/data/` dan seeder terkait, lalu:

```bash
php artisan migrate:fresh --seed
php artisan test --compact
```

Test `ContentIntegrityTest` menjaga agar total soal tetap 40 dan setiap dimensi seimbang 5 positif + 5 negatif. Sesuaikan test bila komposisi memang diubah.

---

## Troubleshooting

| Gejala | Penyebab & solusi |
|---|---|
| `Unable to locate file in Vite manifest` | Aset belum dibuild. Jalankan `npm install && npm run build`, atau `npm run dev` saat development. |
| `SQLSTATE[HY000] [1049] Unknown database 'test_mbti'` | Database belum dibuat. Jalankan `CREATE DATABASE test_mbti ...` atau ubah `DB_DATABASE`. |
| `SQLSTATE[HY000] [1045] Access denied for user` | `DB_USERNAME`/`DB_PASSWORD` salah, atau user tidak punya akses ke database. |
| `MissingAppKeyException` / `No application encryption key` | Jalankan `php artisan key:generate`. |
| `419 Page Expired` | `SESSION_DRIVER=database` tetapi tabel `sessions` belum ada, atau cookie lama. Jalankan `php artisan migrate`, hapus cookie, lalu `php artisan config:clear`. |
| `Failed opening required 'vendor/autoload.php'` | Dependensi PHP belum ada. Jalankan `composer install`. |
| `Class "..." not found` setelah ekstrak ZIP | Jalankan `composer install` lalu `composer dump-autoload`. |
| Katalog kosong / `Tipe tidak ditemukan` | Data referensi belum diisi. Jalankan `php artisan db:seed`. |
| `Vite requires Node.js version ...` | Versi Node terlalu lama. Gunakan Node 20.19+ atau 22.12+. |
| `Permission denied` pada `storage/` atau `bootstrap/cache/` | `chmod -R ug+rwx storage bootstrap/cache` (Linux/macOS). |
| Port 8000 sudah dipakai | `php artisan serve --port=8080` dan sesuaikan `APP_URL`. |
| Unduhan sertifikat gagal / kosong | Pastikan aset sudah dibuild (`npm run build`), gunakan browser modern, dan cek Console. Muat ulang halaman sebelum mengunduh. |
| Font tidak muncul saat build offline | Plugin Vite mengunduh Instrument Sans dari Bunny Fonts; `npm run build` butuh koneksi internet. |
| Perubahan `.env` tidak terbaca | `php artisan config:clear` (atau `php artisan optimize:clear`). |
| Tautan hasil 404 | Token salah/terpotong, atau database sudah di-`migrate:fresh`. |

---

## Keamanan & Privasi

- Tidak ada autentikasi: keamanan hasil bergantung pada kerahasiaan token ULID.
- Nama dan umur disimpan di database; tidak ada pengiriman ke layanan pihak ketiga.
- Sertifikat dan halaman hasil memakai `noindex, nofollow`.
- Rate limit: pembuatan sesi 10/menit, penyimpanan jawaban 120/menit.
- Jangan commit `.env`, database lokal, atau log yang memuat data pengguna.

---

## Lisensi

Dirilis di bawah [MIT License](https://opensource.org/licenses/MIT).

Dibangun dengan [Laravel](https://laravel.com), [Tailwind CSS](https://tailwindcss.com), [Vite](https://vite.dev), [html2canvas](https://html2canvas.hertzen.com), [Pest](https://pestphp.com), dan [Instrument Sans](https://fonts.bunny.net/font/instrument-sans) melalui Bunny Fonts.
