const settings = window.settings || {};

// Initialize toasts
document.addEventListener('DOMContentLoaded', function() {
    const toasts = document.querySelectorAll('.toast.show');
    toasts.forEach(function(toast) {
        const bsToast = new bootstrap.Toast(toast, {
            autohide: true,
            delay: 5000
        });
        bsToast.show();

        // Remove from DOM after hide
        toast.addEventListener('hidden.bs.toast', function() {
            toast.remove();
        });
    });

    // Handle Add to Cart with Animation
    document.querySelectorAll('.add-to-cart-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const button = this.querySelector('button[type="submit"]');
            const productCard = this.closest('.product-card, .card');
            const productImage = productCard ? productCard.querySelector('img') : null;
            
            // Disable button
            button.disabled = true;
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="bi bi-hourglass-split"></i> Menambahkan...';
            
            fetch(base_url + 'cart/add', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Fly to cart animation
                    if (productImage) {
                        flyToCart(productImage);
                    }
                    
                    // Update cart badge
                    updateCartBadge(data.totalItems);
                    
                    // Show success message
                    showNotification('success', data.message);
                    
                    // Reset button after animation
                    setTimeout(function() {
                        button.disabled = false;
                        button.innerHTML = originalText;
                    }, 1000);
                } else {
                    button.disabled = false;
                    button.innerHTML = originalText;
                    
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    } else {
                        showNotification('error', data.message);
                    }
                }
            })
            .catch(error => {
                button.disabled = false;
                button.innerHTML = originalText;
                showNotification('error', 'Terjadi kesalahan. Silakan coba lagi.');
            });
        });
    });
});

function flyToCart(productImage) {
    const cart = document.querySelector('.bi-cart3');
    if (!cart || !productImage) return;
    
    // Clone the image
    const flyingImg = productImage.cloneNode();
    flyingImg.style.cssText = `
        position: fixed;
        z-index: 9999;
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.3);
    `;
    
    // Get positions
    const imgRect = productImage.getBoundingClientRect();
    const cartRect = cart.getBoundingClientRect();
    
    flyingImg.style.left = imgRect.left + 'px';
    flyingImg.style.top = imgRect.top + 'px';
    
    document.body.appendChild(flyingImg);
    
    // Animate
    setTimeout(function() {
        flyingImg.style.transition = 'all 0.8s cubic-bezier(0.5, 0, 0.5, 1)';
        flyingImg.style.left = cartRect.left + 'px';
        flyingImg.style.top = cartRect.top + 'px';
        flyingImg.style.width = '20px';
        flyingImg.style.height = '20px';
        flyingImg.style.opacity = '0';
    }, 10);
    
    // Remove after animation
    setTimeout(function() {
        flyingImg.remove();
        // Bounce cart icon
        cart.style.animation = 'cartBounce 0.5s ease';
        setTimeout(() => cart.style.animation = '', 500);
    }, 800);
}

function updateCartBadge(totalItems) {
    let badge = document.querySelector('.cart-badge');
    const cartLink = document.querySelector('.bi-cart3').closest('a');
    
    if (totalItems > 0) {
        if (!badge) {
            badge = document.createElement('span');
            badge.className = 'position-absolute translate-middle badge rounded-circle bg-danger cart-badge';
            badge.innerHTML = '<span class="visually-hidden">items in cart</span>';
            cartLink.appendChild(badge);
        }
        badge.childNodes[0].textContent = totalItems > 99 ? '99+' : totalItems;
        
        // Bounce animation
        badge.style.animation = 'none';
        setTimeout(() => badge.style.animation = 'bounce 0.5s ease', 10);
    }
}

function showNotification(type, message) {
    const toastContainer = document.querySelector('.toast-container');
    const toastDiv = document.createElement('div');

    let iconClass, bgClass, heading, textColor;
    switch(type) {
        case 'success':
            iconClass = 'bi-check-circle-fill';
            bgClass = 'text-bg-success';
            heading = 'Berhasil!';
            textColor = 'text-white-50';
            break;
        case 'error':
            iconClass = 'bi-exclamation-triangle-fill';
            bgClass = 'text-bg-danger';
            heading = 'Oops!';
            textColor = 'text-white-50';
            break;
        case 'warning':
            iconClass = 'bi-exclamation-circle-fill';
            bgClass = 'text-bg-warning';
            heading = 'Perhatian!';
            textColor = 'text-dark-50';
            break;
        case 'info':
            iconClass = 'bi-info-circle-fill';
            bgClass = 'text-bg-info';
            heading = 'Info!';
            textColor = 'text-white-50';
            break;
        default:
            iconClass = 'bi-info-circle-fill';
            bgClass = 'text-bg-primary';
            heading = 'Info!';
            textColor = 'text-white-50';
    }

    toastDiv.className = `toast align-items-center ${bgClass} border-0 shadow-lg`;
    toastDiv.setAttribute('role', 'alert');
    toastDiv.setAttribute('aria-live', 'assertive');
    toastDiv.setAttribute('aria-atomic', 'true');

    toastDiv.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                <div class="d-flex align-items-center">
                    <i class="bi ${iconClass} fs-4 me-3"></i>
                    <div>
                        <strong>${heading}</strong><br>
                        <small class="${textColor}">${message}</small>
                    </div>
                </div>
            </div>
            <button type="button" class="btn-close ${type === 'warning' ? '' : 'btn-close-white'} me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    `;

    toastContainer.appendChild(toastDiv);

    // Initialize and show toast
    const bsToast = new bootstrap.Toast(toastDiv, {
        autohide: true,
        delay: 4000
    });
    bsToast.show();

    // Remove from DOM after hide
    toastDiv.addEventListener('hidden.bs.toast', function() {
        toastDiv.remove();
    });
}

// Wishlist Toggle Function
window.toggleWishlist = function(button, produkId) {
    if (!button || !produkId) return;
    
    const icon = button.querySelector('i');
    const originalClass = icon.className;
    
    // Disable button
    button.disabled = true;
    
    const formData = new FormData();
    formData.append('produk_id', produkId);
    
    fetch(base_url + 'wishlist/toggle', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Toggle icon
            if (data.isAdded) {
                icon.classList.remove('bi-heart');
                icon.classList.add('bi-heart-fill');
            } else {
                icon.classList.remove('bi-heart-fill');
                icon.classList.add('bi-heart');
            }
            
            // Update wishlist badge
            updateWishlistBadge(data.totalWishlist);
            
            // Show notification
            showNotification('success', data.message);
        } else {
            // Restore icon
            icon.className = originalClass;
            
            if (data.redirect) {
                window.location.href = data.redirect;
            } else {
                showNotification('error', data.message);
            }
        }
        
        button.disabled = false;
    })
    .catch(error => {
        console.error('Error:', error);
        icon.className = originalClass;
        button.disabled = false;
        showNotification('error', 'Terjadi kesalahan. Silakan coba lagi.');
    });
}

function updateWishlistBadge(totalWishlist) {
    let badge = document.querySelector('.wishlist-badge');
    const wishlistLink = document.querySelector('.bi-heart').closest('a');
    
    if (totalWishlist > 0) {
        if (!badge) {
            badge = document.createElement('span');
            badge.className = 'position-absolute translate-middle badge rounded-circle bg-danger wishlist-badge';
            badge.innerHTML = '<span class="visually-hidden">wishlist items</span>';
            wishlistLink.appendChild(badge);
        }
        badge.childNodes[0].textContent = totalWishlist > 99 ? '99+' : totalWishlist;
        
        // Bounce animation
        badge.style.animation = 'none';
        setTimeout(() => badge.style.animation = 'bounce 0.5s ease', 10);
    } else {
        if (badge) {
            badge.remove();
        }
    }
}
