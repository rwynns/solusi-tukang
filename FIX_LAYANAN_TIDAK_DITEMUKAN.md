# Fix: Masalah "Layanan Tidak Ditemukan" di Halaman Penghasilan Tukang

## 🐛 Masalah

Di halaman Penghasilan Tukang (`/penghasilan`), kolom Layanan selalu menampilkan "Layanan tidak ditemukan" meskipun data sebenarnya ada.

## 🔍 Root Cause

1. **Inconsistent Column Names**:

    - View menggunakan `$item->subJasa->name`
    - Database SubJasa menggunakan kolom `nama` (bukan `name`)
    - Database Jasa juga menggunakan kolom `nama` (bukan `name`)

2. **Missing Nested Relations**:

    - Controller tidak memuat relasi `jasa` dari `subJasa`
    - Hanya memuat sampai `order.orderItems.subJasa` tanpa `.jasa`

3. **No Fallback**:
    - Tidak ada fallback ke field `name` di `order_items` table

## ✅ Solusi yang Diterapkan

### 1. Fix Column Names

```php
// SEBELUMNYA (SALAH):
{{ $item->subJasa->name ?? 'Layanan tidak ditemukan' }}
{{ $item->subJasa->jasa->name }}

// SESUDAHNYA (BENAR):
{{ $item->subJasa->nama ?? 'Layanan tidak ditemukan' }}
{{ $item->subJasa->jasa->nama }}
```

### 2. Add Nested Relations

```php
// File: app/Http/Controllers/Tukang/EarningsController.php

// SEBELUMNYA:
->with(['order', 'order.orderItems.subJasa'])

// SESUDAHNYA:
->with(['order', 'order.orderItems.subJasa.jasa'])
```

### 3. Add Fallback Logic

```php
// File: resources/views/tukang/earnings/index.blade.php
@php
    $firstItem = $earning->order->orderItems->first();
    $serviceName = $firstItem->subJasa->nama ?? $firstItem->name ?? 'Layanan tidak ditemukan';
@endphp
{{ $serviceName }}
```

```php
// File: resources/views/tukang/earnings/show.blade.php
{{ $item->subJasa->nama ?? $item->name ?? 'Layanan tidak ditemukan' }}
```

## 🧪 Testing

### Route Debug Baru:

-   `/test-earning-data` - Debug data earning splits dan relasi

### Cara Test:

1. Akses halaman `/penghasilan` sebagai tukang
2. Periksa kolom "Layanan" - seharusnya menampilkan nama layanan yang benar
3. Klik "Detail" pada salah satu earning untuk melihat detail
4. Akses `/test-earning-data` untuk debug relasi data

## 📁 File yang Dimodifikasi

1. **`app/Http/Controllers/Tukang/EarningsController.php`**

    - Menambah `.jasa` ke eager loading
    - Update method `index()` dan `show()`

2. **`resources/views/tukang/earnings/index.blade.php`**

    - Fix `->name` menjadi `->nama`
    - Tambah fallback ke `$item->name`

3. **`resources/views/tukang/earnings/show.blade.php`**

    - Fix `->name` menjadi `->nama`
    - Tambah fallback ke `$item->name`

4. **`routes/web.php`**
    - Tambah route debug `/test-earning-data`

## 🔄 Langkah Selanjutnya

1. **Test Menyeluruh**: Pastikan semua earning menampilkan layanan dengan benar
2. **Check Other Views**: Periksa view lain yang mungkin punya masalah serupa
3. **Database Review**: Pastikan foreign key constraints pada `order_items.sub_jasa_id` bekerja dengan baik

## 💡 Best Practice untuk Kedepan

1. **Consistent Naming**: Standarisasi nama kolom (gunakan `name` atau `nama` secara konsisten)
2. **Always Use Fallbacks**: Selalu sediakan fallback untuk data yang mungkin null
3. **Proper Relations**: Selalu eager load relasi yang dibutuhkan untuk menghindari N+1 query
4. **Debug Routes**: Gunakan debug routes untuk troubleshooting data issues
