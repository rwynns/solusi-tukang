/**
 * Database-based Cart Management System
 * Handles both authenticated users (database) and guests (localStorage/cookies)
 */

class CartManager {
    constructor() {
        this.isAuthenticated = window.isAuthenticated || false;
        this.csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            ?.getAttribute("content");
        this.init();
    }

    init() {
        this.updateCartCount();

        // If user is authenticated, migrate guest cart on page load
        if (this.isAuthenticated) {
            this.migrateGuestCart();
        }
    }

    /**
     * Add item to cart
     */
    async addToCart(subJasaId, name, price, image, satuan, quantity = 1) {
        if (!this.isAuthenticated) {
            // For guests, use localStorage
            return this.addToLocalStorage(
                subJasaId,
                name,
                price,
                image,
                satuan,
                quantity
            );
        }

        try {
            const response = await fetch("/cart/add", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": this.csrfToken,
                },
                body: JSON.stringify({
                    id: subJasaId,
                    quantity: quantity,
                }),
            });

            const data = await response.json();

            if (data.success) {
                this.updateCartCount();
                this.showNotification(data.message);
                return data;
            } else {
                throw new Error(data.message);
            }
        } catch (error) {
            console.error("Error adding to cart:", error);
            this.showNotification(
                "Gagal menambahkan item ke keranjang",
                "error"
            );
            return { success: false, message: error.message };
        }
    }

    /**
     * Update cart item quantity
     */
    async updateCartItem(subJasaId, quantity, index = null) {
        if (!this.isAuthenticated) {
            // For guests, use localStorage with index
            return this.updateLocalStorageItem(index, quantity);
        }

        try {
            const response = await fetch("/cart/update", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": this.csrfToken,
                },
                body: JSON.stringify({
                    sub_jasa_id: subJasaId,
                    quantity: quantity,
                }),
            });

            const data = await response.json();

            if (data.success) {
                this.updateCartCount();
                return data;
            } else {
                throw new Error(data.message);
            }
        } catch (error) {
            console.error("Error updating cart item:", error);
            return { success: false, message: error.message };
        }
    }

    /**
     * Remove item from cart
     */
    async removeCartItem(subJasaId, index = null) {
        if (!this.isAuthenticated) {
            // For guests, use localStorage with index
            return this.removeFromLocalStorage(index);
        }

        try {
            const response = await fetch("/cart/remove", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": this.csrfToken,
                },
                body: JSON.stringify({
                    sub_jasa_id: subJasaId,
                }),
            });

            const data = await response.json();

            if (data.success) {
                this.updateCartCount();
                this.showNotification(data.message);
                return data;
            } else {
                throw new Error(data.message);
            }
        } catch (error) {
            console.error("Error removing cart item:", error);
            return { success: false, message: error.message };
        }
    }

    /**
     * Clear entire cart
     */
    async clearCart() {
        if (!this.isAuthenticated) {
            localStorage.removeItem("cart");
            this.updateCartCount();
            return { success: true, message: "Keranjang berhasil dikosongkan" };
        }

        try {
            const response = await fetch("/cart/clear", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": this.csrfToken,
                },
            });

            const data = await response.json();

            if (data.success) {
                this.updateCartCount();
                this.showNotification(data.message);
                return data;
            } else {
                throw new Error(data.message);
            }
        } catch (error) {
            console.error("Error clearing cart:", error);
            return { success: false, message: error.message };
        }
    }
    /**
     * Get cart data
     */
    async getCartData() {
        if (!this.isAuthenticated) {
            const cart = JSON.parse(localStorage.getItem("cart") || "[]");
            const total = cart.reduce(
                (sum, item) => sum + item.price * item.quantity,
                0
            );
            const count = cart.reduce((sum, item) => sum + item.quantity, 0);

            return {
                success: true,
                items: cart,
                count: count,
                total: total,
                formatted_total: `Rp ${total.toLocaleString("id-ID")}`,
            };
        }

        try {
            const response = await fetch("/cart/data", {
                method: "GET",
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": this.csrfToken,
                },
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();

            if (data.success) {
                return data;
            } else {
                throw new Error(data.message || "Failed to get cart data");
            }
        } catch (error) {
            console.error("Error getting cart data:", error);

            // Return empty cart data as fallback
            return {
                success: false,
                items: [],
                count: 0,
                total: 0,
                formatted_total: "Rp 0",
                message: error.message,
            };
        }
    }

    /**
     * Get cart count
     */
    async getCartCount() {
        if (!this.isAuthenticated) {
            const cart = JSON.parse(localStorage.getItem("cart") || "[]");
            return cart.reduce((sum, item) => sum + item.quantity, 0);
        }

        try {
            const response = await fetch("/cart/count");
            const data = await response.json();
            return data.count || 0;
        } catch (error) {
            console.error("Error getting cart count:", error);
            return 0;
        }
    }

    /**
     * Update cart count in UI
     */
    async updateCartCount() {
        const count = await this.getCartCount();

        const cartCountElements = document.querySelectorAll(
            '[id*="cartCount"], [class*="cart-count"]'
        );
        cartCountElements.forEach((element) => {
            element.textContent = count;
        });

        // Specific selectors for existing elements
        const cartCountEl = document.getElementById("cartCount");
        const mobileCartCountEl = document.getElementById("mobileCartCount");

        if (cartCountEl) cartCountEl.textContent = count;
        if (mobileCartCountEl) mobileCartCountEl.textContent = count;
    }

    /**
     * Migrate guest cart to user cart when user logs in
     */
    async migrateGuestCart() {
        const guestCart = JSON.parse(localStorage.getItem("cart") || "[]");

        if (guestCart.length === 0) {
            return;
        }

        try {
            const response = await fetch("/cart/migrate", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": this.csrfToken,
                },
            });

            const data = await response.json();

            if (data.success) {
                localStorage.removeItem("cart");
                this.updateCartCount();
                console.log("Guest cart migrated successfully");
            }
        } catch (error) {
            console.error("Error migrating guest cart:", error);
        }
    }

    /**
     * LocalStorage methods for guests
     */
    addToLocalStorage(subJasaId, name, price, image, satuan, quantity) {
        const cart = JSON.parse(localStorage.getItem("cart") || "[]");
        const existingItemIndex = cart.findIndex(
            (item) => item.id === subJasaId
        );

        // Fix image URL
        let imageUrl = image;
        if (
            !image ||
            image === "" ||
            image === "null" ||
            image.includes("null")
        ) {
            imageUrl = "/images/login-bg.png";
        }

        if (existingItemIndex > -1) {
            cart[existingItemIndex].quantity += quantity;
        } else {
            cart.push({
                id: subJasaId,
                name: name,
                price: price,
                image: imageUrl,
                quantity: quantity,
                satuan: satuan,
            });
        }

        localStorage.setItem("cart", JSON.stringify(cart));
        this.updateCartCount();
        this.showNotification(`${name} telah ditambahkan ke keranjang`);

        return {
            success: true,
            message: "Item berhasil ditambahkan ke keranjang",
        };
    }

    updateLocalStorageItem(index, quantity) {
        const cart = JSON.parse(localStorage.getItem("cart") || "[]");

        if (cart[index]) {
            if (quantity <= 0) {
                cart.splice(index, 1);
            } else {
                cart[index].quantity = quantity;
            }

            localStorage.setItem("cart", JSON.stringify(cart));
            this.updateCartCount();

            return {
                success: true,
                message: "Jumlah item berhasil diperbarui",
            };
        }

        return { success: false, message: "Item tidak ditemukan" };
    }

    removeFromLocalStorage(index) {
        const cart = JSON.parse(localStorage.getItem("cart") || "[]");

        if (cart[index]) {
            cart.splice(index, 1);
            localStorage.setItem("cart", JSON.stringify(cart));
            this.updateCartCount();

            return {
                success: true,
                message: "Item berhasil dihapus dari keranjang",
            };
        }

        return { success: false, message: "Item tidak ditemukan" };
    }

    /**
     * Show notification
     */
    showNotification(message, type = "success") {
        // Create notification element if it doesn't exist
        let notification = document.getElementById("cart-notification");

        if (!notification) {
            notification = document.createElement("div");
            notification.id = "cart-notification";
            notification.className =
                "fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full";
            document.body.appendChild(notification);
        }

        // Set notification content and style
        notification.textContent = message;
        notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transition-all duration-300 transform ${
            type === "success"
                ? "bg-green-500 text-white"
                : "bg-red-500 text-white"
        }`;

        // Show notification
        setTimeout(() => {
            notification.classList.remove("translate-x-full");
        }, 100);

        // Hide notification after 3 seconds
        setTimeout(() => {
            notification.classList.add("translate-x-full");
        }, 3000);
    }

    /**
     * Alias methods for backward compatibility
     */
    async updateQuantity(subJasaId, quantity, index = null) {
        return await this.updateCartItem(subJasaId, quantity, index);
    }

    async removeFromCart(subJasaId, index = null) {
        return await this.removeCartItem(subJasaId, index);
    }
}

// Global functions for backward compatibility
window.addToCart = function (
    subJasaId,
    name,
    price,
    image,
    satuan,
    quantity = 1
) {
    if (window.cartManager) {
        return window.cartManager.addToCart(
            subJasaId,
            name,
            price,
            image,
            satuan,
            quantity
        );
    }
};

window.updateCartCount = function () {
    if (window.cartManager) {
        window.cartManager.updateCartCount();
    }
};
