document.addEventListener('DOMContentLoaded', function() {
    const cartContainer = document.getElementById('cart-items');
    
    if (!cartContainer) {
        console.error('Error: No se encontró el contenedor del carrito');
        return;
    }

    loadCartItems(cartContainer);
});

function loadCartItems(cartContainer) {
    // Show loading state
    cartContainer.innerHTML = '<p>Cargando productos...</p>';
    
    fetch('/Gorras/gorras-proyecto/views/cart/init_cart.php', {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error en la respuesta del servidor');
        }
        return response.json();
    })
    .then(data => {
        if (data.items && data.items.length > 0) {
            cartContainer.innerHTML = data.items.map(item => `
                <div class="cart-item">
                    <img src="/Gorras/gorras-proyecto/public/img/${item.image_url}" 
                        alt="${item.name}">
                    <div class="item-details">
                        <h3>${item.name}</h3>
                        <p class="price">$${parseFloat(item.price).toFixed(2)}</p>
                        <div class="quantity">
                            <button class="qty-btn" data-action="decrease">-</button>
                            <span>${item.quantity}</span>
                            <button class="qty-btn" data-action="increase">+</button>
                        </div>
                    </div>
                    <button class="remove-item" data-id="${item.id}">Eliminar</button>
                </div>
            `).join('') + `
            <div class="cart-total">
                <h3>Total: $<span id="total-amount">${parseFloat(data.total).toFixed(2)}</span></h3>
                <button id="checkout-btn">Comprar Producto</button>
            </div>`;
        } else {
            cartContainer.innerHTML = `
                <p>No hay productos en el carrito</p>
                <a href="/Gorras/gorras-proyecto/views/shop/catalog.php" class="continue-shopping">
                    Continuar comprando
                </a>`;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        cartContainer.innerHTML = '<p>Error al cargar el carrito</p>';
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const cartItems = document.querySelector('.cart-items');

    // Event delegation for cart actions
    cartItems?.addEventListener('click', function(e) {
        if (e.target.classList.contains('qty-btn')) {
            handleQuantityChange(e);
        }
        if (e.target.classList.contains('remove-item')) {
            handleRemoveItem(e);
        }
    });

    // Agregar listener para el botón de compra
    document.addEventListener('click', function(e) {
        if (e.target.id === 'checkout-btn') {
            if (confirm('¿Estás seguro de realizar la compra?')) {
                processPurchase();
            }
        }
    });
});

function handleQuantityChange(e) {
    const action = e.target.dataset.action;
    const itemId = e.target.closest('.cart-item').querySelector('.remove-item').dataset.id;
    const quantitySpan = e.target.parentElement.querySelector('span');
    let quantity = parseInt(quantitySpan.textContent);

    if (action === 'increase') {
        quantity++;
    } else if (action === 'decrease' && quantity > 1) {
        quantity--;
    }

    updateQuantity(itemId, quantity);
    quantitySpan.textContent = quantity;
}

function handleRemoveItem(e) {
    const itemId = e.target.dataset.id;
    if (confirm('¿Estás seguro de eliminar este producto?')) {
        removeItem(itemId);
    }
}

function updateQuantity(itemId, quantity) {
    fetch('/Gorras/gorras-proyecto/views/cart/update_quantity.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            itemId: itemId,
            quantity: quantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateCartTotal();
        } else {
            alert(data.message || 'Error al actualizar cantidad');
        }
    })
    .catch(error => console.error('Error:', error));
}

function removeItem(itemId) {
    fetch('/Gorras/gorras-proyecto/views/cart/remove_item.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ itemId: itemId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message || 'Error al eliminar producto');
        }
    })
    .catch(error => console.error('Error:', error));
}

function updateCartTotal() {
    fetch('/Gorras/gorras-proyecto/views/cart/get_total.php')
    .then(response => response.json())
    .then(data => {
        document.getElementById('total-amount').textContent = 
            new Intl.NumberFormat('es-CO', { minimumFractionDigits: 2 }).format(data.total);
    })
    .catch(error => console.error('Error:', error));
}

// Agregar después de updateCartTotal
function processPurchase() {
    fetch('/Gorras/gorras-proyecto/views/cart/process_purchase.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('¡Gracias por tu compra!');
            window.location.href = '/Gorras/gorras-proyecto/views/shop/catalog.php';
        } else {
            alert(data.message || 'Error al procesar la compra');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al procesar la compra');
    });
}