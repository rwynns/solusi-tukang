# Fix Modal "Perbarui Status Pesanan" di Admin Order Show

## Issues yang ditemukan dan diperbaiki:

### 1. JavaScript Route Error

**Problem**: JavaScript menggunakan route `/admin/orders/${orderId}/update-status` tapi route sebenarnya adalah `/admin/orders/${orderId}/status`

**Fixed**:

```javascript
// Before
statusUpdateForm.action = `/admin/orders/${orderId}/update-status`;

// After
statusUpdateForm.action = `/admin/orders/${orderId}/status`;
```

### 2. Modal Structure

**Problem**: Modal tidak memiliki backdrop overlay dan struktur yang proper untuk modal Tailwind CSS

**Fixed**:

-   Ditambahkan backdrop dengan `bg-gray-500 bg-opacity-75`
-   Struktur modal dibuat sesuai dengan best practices Tailwind CSS
-   Proper z-index dan positioning

### 3. Modal Event Handling

**Problem**: Modal tidak bisa ditutup dengan click pada backdrop

**Fixed**:

-   Ditambahkan event listener untuk backdrop click
-   Event ESC key sudah ada dan tetap berfungsi

## Perubahan yang dilakukan:

1. **File**: `resources/views/admin/orders/show.blade.php`
    - Fixed JavaScript route dari `/update-status` ke `/status`
    - Updated modal HTML structure dengan proper backdrop
    - Added backdrop click event handling
    - Fixed both status modal and payment modal

## Testing:

1. Buka halaman admin order detail
2. Click tombol "Ubah Status"
3. Modal harus muncul dengan backdrop
4. Modal bisa ditutup dengan:
    - Click tombol X
    - Click tombol Batal
    - Click backdrop
    - Press ESC key
5. Submit form harus berhasil update status

## Routes yang terlibat:

-   `PATCH /admin/orders/{order}/status` → `OrderController@updateStatus`
-   `PATCH /admin/orders/{order}/update-payment` → `OrderController@updatePaymentStatus`
