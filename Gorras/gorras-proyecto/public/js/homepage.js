document.addEventListener('DOMContentLoaded', function() {
    loadFeaturedProducts();
    
    // Event delegation for add to cart buttons
    document.querySelector('.product-grid').addEventListener('click', function(e) {
        if (e.target.classList.contains('add-to-cart')) {
            const productId = e.target.dataset.id;
            addToCart(productId);
        }
    });
});

function loadFeaturedProducts() {
    const productGrid = document.querySelector('.product-grid');
    
    fetch('/Gorras/gorras-proyecto/views/home/get_featured_products.php')
        .then(response => response.json())
        .then(data => {
            if (data.success && data.products.length > 0) {
                productGrid.innerHTML = data.products.map(product => `
                    <div class="product-card">
                        <img src="/Gorras/gorras-proyecto/public/img/${product.image_url}" 
                            alt="${product.name}">
                        <div class="product-info">
                            <h3>${product.name}</h3>
                            <p class="price">$${parseFloat(product.price).toFixed(2)}</p>
                            <button class="add-to-cart" data-id="${product.id}">
                                Añadir al carrito
                            </button>
                        </div>
                    </div>
                `).join('');
            } else {
                productGrid.innerHTML = '<p>No hay productos destacados disponibles.</p>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            productGrid.innerHTML = '<p>Error al cargar los productos destacados</p>';
        });
}

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
    .then(response => response.json())
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