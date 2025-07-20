# Sistem Konfirmasi Penyelesaian Pesanan (Dual Confirmation)

## Perubahan yang Dibuat

### 1. Database Migration

-   **File**: `2025_07_20_220254_add_completion_confirmations_to_orders_table.php`
-   **Kolom Baru**:
    -   `customer_confirmed` (boolean, default false)
    -   `tukang_confirmed` (boolean, default false)
    -   `customer_confirmed_at` (timestamp, nullable)
    -   `tukang_confirmed_at` (timestamp, nullable)

### 2. Model Order

-   **File**: `app/Models/Order.php`
-   **Perubahan**:
    -   Menambah kolom baru ke `$fillable` dan `$casts`
    -   Menambah konstanta status baru
    -   Menambah method `isBothConfirmed()`, `canBeCompleted()`, `confirmByCustomer()`, `confirmByTukang()`

### 3. Controller

-   **File**: `app/Http/Controllers/OrderController.php`
-   **Method Baru**:
    -   `customerConfirmCompletion()` - untuk konfirmasi customer
    -   `tukangConfirmCompletion()` - untuk konfirmasi tukang

### 4. Routes

-   **File**: `routes/web.php`
-   **Route Baru**:
    -   `POST /customer/orders/{order}/confirm-completion` (customer.orders.confirm-completion)
    -   `POST /pesanan-saya/{order}/confirm-completion` (tukang.pesanan.confirm-completion)
    -   `POST /orders/{order}/confirm-completion` (orders.confirm-completion)

### 5. Views

-   **Customer View**: `resources/views/customer/orders/show.blade.php`

    -   Menambah tombol "Konfirmasi Selesai" untuk customer
    -   Menambah status konfirmasi kedua belah pihak
    -   Menambah JavaScript function `confirmCompletion()`

-   **Tukang View**: `resources/views/tukang/orders/show.blade.php`
    -   Mengganti tombol "Tandai Selesai" dengan "Konfirmasi Selesai"
    -   Menambah status konfirmasi kedua belah pihak
    -   Menambah JavaScript function `confirmCompletion()`

### 6. Observer

-   **File**: `app/Observers/OrderObserver.php`
-   **Perubahan**:
    -   Menambah logic untuk mengubah status dari 'pending' ke 'processing' ketika payment menjadi 'paid'

### 7. Seeder

-   **File**: `database/seeders/UpdateExistingOrdersSeeder.php`
-   **Fungsi**: Update existing completed orders dengan default confirmation values

### 8. Test View

-   **File**: `resources/views/test-confirmation.blade.php`
-   **Route**: `/test-order-confirmation`
-   **Fungsi**: Testing interface untuk melihat status konfirmasi pesanan

## Alur Sistem Baru

1. **Customer membuat pesanan** → Status: `pending`, Payment: `unpaid`
2. **Admin verifikasi payment** → Payment: `paid`, Status: `processing` (otomatis)
3. **Tukang dan Customer dapat melakukan konfirmasi penyelesaian**
    - Setiap pihak dapat klik tombol "Konfirmasi Selesai"
    - Status konfirmasi masing-masing tersimpan terpisah
4. **Pesanan selesai ketika KEDUA pihak sudah konfirmasi**
    - Status pesanan otomatis berubah menjadi `completed`
    - **🆕 PEMBAGIAN PENDAPATAN BARU TERJADI SAAT INI** (bukan saat payment lunas)

## ⚠️ Perubahan Penting: Timing Pembagian Pendapatan

### Sebelumnya:

-   Pendapatan dibagi ketika **payment status = 'paid'**
-   Tukang langsung mendapat uang meski pekerjaan belum selesai

### Sekarang:

-   Pendapatan dibagi ketika **status pesanan = 'completed'**
-   Tukang baru mendapat uang setelah konfirmasi kedua belah pihak
-   Lebih aman dan fair untuk semua pihak

### File yang Dimodifikasi untuk Perubahan Ini:

-   **Observer**: `app/Observers/OrderObserver.php`
    -   Pindah trigger dari `payment_status = 'paid'` ke `status = 'completed'`
    -   Tambah validasi payment harus lunas sebelum distribusi
-   **Seeder**: `database/seeders/CleanupEarningSplitsSeeder.php`

    -   Membersihkan earning splits yang timing-nya salah## Fitur Keamanan

-   **Validasi Akses**: Customer hanya bisa konfirmasi pesanan miliknya sendiri
-   **Validasi Akses**: Tukang hanya bisa konfirmasi pesanan yang ditugaskan kepadanya
-   **Validasi Status**: Konfirmasi hanya bisa dilakukan jika status = `processing` dan payment = `paid`
-   **Prevent Double Confirmation**: Setiap pihak hanya bisa konfirmasi sekali
-   **Transaction Safety**: Menggunakan database transaction untuk konsistensi data

## Testing

1. Akses `/test-order-confirmation` untuk melihat daftar pesanan yang bisa ditest
2. Login sebagai customer/tukang untuk test tombol konfirmasi
3. Periksa bahwa status pesanan berubah menjadi `completed` hanya setelah kedua pihak konfirmasi
