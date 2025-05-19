document.addEventListener('DOMContentLoaded', function() {
    const categorySelect = document.getElementById('category');
    const sortSelect = document.getElementById('sort');
    const productGrid = document.querySelector('.product-grid');

    function loadProducts(category = '', sort = 'default') {
        productGrid.innerHTML = '<p>Cargando productos...</p>';

        fetch(`/Gorras/gorras-proyecto/views/shop/get_products.php?category=${category}&sort=${sort}`)
        .then(response => response.json())
        .then(products => {
            productGrid.innerHTML = '';
            
            if (!products || products.length === 0) {
                productGrid.innerHTML = '<p>No hay productos disponibles.</p>';
                return;
            }

            products.forEach(product => {
                if (product && product.name && product.price && product.image_url) {
                    const card = `
                        <div class="product-card">
                            <img src="/Gorras/gorras-proyecto/public/img/${product.image_url}" 
                                alt="${product.name}"
                                onerror="this.src='/Gorras/gorras-proyecto/public/img/default.jpg'">
                            <div class="product-info">
                                <h3>${product.name}</h3>
                                <p class="price">$${parseFloat(product.price).toFixed(2)}</p>
                                <button class="add-to-cart" data-id="${product.id}">Añadir al carrito</button>
                            </div>
                        </div>
                    `;
                    productGrid.innerHTML += card;
                }
            });
        })
        .catch(error => {
            console.error('Error:', error);
            productGrid.innerHTML = '<p>Error al cargar los productos.</p>';
        });
    }

    // Event listeners
    categorySelect?.addEventListener('change', () => {
        loadProducts(categorySelect.value, sortSelect.value);
    });

    sortSelect?.addEventListener('change', () => {
        loadProducts(categorySelect.value, sortSelect.value);
    });

    // Load products on page load
    loadProducts();

    // Agregar al carrito
    if (productGrid) {
        productGrid.addEventListener('click', (e) => {
            if (e.target.classList.contains('add-to-cart')) {
                e.preventDefault();
                const productId = e.target.dataset.id;
                addToCart(productId);
            }
        });
    }
});

function addToCart(productId) {
    fetch('/Gorras/gorras-proyecto/views/cart/add_to_cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            productId: productId,
            quantity: 1
        })
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => Promise.reject(err));
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert('Producto agregado al carrito');
        } else {
            alert(data.message || 'Error al agregar el producto al carrito');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al procesar la solicitud');
    });
}