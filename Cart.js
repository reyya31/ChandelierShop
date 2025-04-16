let listProductHTML = document.querySelector('.listProduct');
let listCartHTML = document.querySelector('.listCart');
let iconCart = document.querySelector('.icon-cart');
let iconCartSpan = document.querySelector('.icon-cart span');
let body = document.querySelector('body');
let closeCart = document.querySelector('.close');
let products = [];
let cart = [];

iconCart.addEventListener('click', () => {
    body.classList.toggle('showCart');
});
closeCart.addEventListener('click', () => {
    body.classList.toggle('showCart');
});

const addDataToHTML = () => {
    if(products.length > 0) {
        products.forEach(product => {
            let newProduct = document.createElement('div');
            newProduct.dataset.id = product.id;
            newProduct.classList.add('item');
            newProduct.innerHTML = 
            `<img src="${product.image}" alt="">
            <h2>${product.name}</h2>
            <div class="price">NPR.${product.price}</div>
            <button class="addCart">Add To Cart</button>`;
            listProductHTML.appendChild(newProduct);
        });
    }
};

listProductHTML.addEventListener('click', (event) => {
    let positionClick = event.target;
    if(positionClick.classList.contains('addCart')){
        let id_product = positionClick.parentElement.dataset.id;
        addToCart(id_product);
    }
});

const addToCart = (product_id) => {
    let positionThisProductInCart = cart.findIndex((value) => value.product_id == product_id);
    if(cart.length <= 0){
        cart = [{
            product_id: product_id,
            quantity: 1
        }];
    } else if(positionThisProductInCart < 0){
        cart.push({
            product_id: product_id,
            quantity: 1
        });
    } else {
        cart[positionThisProductInCart].quantity += 1;
    }
    addCartToHTML();
    addCartToMemory();
    updateTotalPrice();
};

const addCartToMemory = () => {
    localStorage.setItem('cart', JSON.stringify(cart));
};

const addCartToHTML = () => {
    listCartHTML.innerHTML = '';
    let totalQuantity = 0;
    if(cart.length > 0){
        cart.forEach(item => {
            totalQuantity += item.quantity;
            let newItem = document.createElement('div');
            newItem.classList.add('item');
            newItem.dataset.id = item.product_id;

            let positionProduct = products.findIndex((value) => value.id == item.product_id);
            let info = products[positionProduct];
            listCartHTML.appendChild(newItem);
            newItem.innerHTML = `
            <div class="image">
                    <img src="${info.image}">
                </div>
                <div class="name">
                ${info.name}
                </div>
                <div class="totalPrice">NPR. ${info.price * item.quantity}</div>

                <div class="quantity">
                    <span class="minus"><</span>
                    <span>${item.quantity}</span>
                    <span class="plus">></span>
                </div>
            `;
        });
    }
    iconCartSpan.innerText = totalQuantity;
};

function updateTotalPrice() {
    let total = 0;
    document.querySelectorAll('.listCart .item').forEach(item => {
        const price = parseFloat(item.querySelector('.totalPrice').textContent.replace('NPR.', '').trim());
        total += price;
    });
    document.getElementById('totalPrice').textContent = 'Rs. ' + total.toFixed(2);
    updateEsewaAmount(total);
}

function updateEsewaAmount(amount) {
    document.getElementById('amount').value = amount;
}

listCartHTML.addEventListener('click', (event) => {
    let positionClick = event.target;
    if(positionClick.classList.contains('minus') || positionClick.classList.contains('plus')){
        let product_id = positionClick.parentElement.parentElement.dataset.id;
        let type = 'minus';
        if(positionClick.classList.contains('plus')){
            type = 'plus';
        }
        changeQuantityCart(product_id, type);
    }
});

const changeQuantityCart = (product_id, type) => {
    let positionItemInCart = cart.findIndex((value) => value.product_id == product_id);
    if(positionItemInCart >= 0){
        let info = cart[positionItemInCart];
        switch (type) {
            case 'plus':
                cart[positionItemInCart].quantity += 1;
                break;
            default:
                let changeQuantity = cart[positionItemInCart].quantity - 1;
                if (changeQuantity > 0) {
                    cart[positionItemInCart].quantity = changeQuantity;
                } else {
                    cart.splice(positionItemInCart, 1);
                }
                break;
        }
    }
    addCartToHTML();
    addCartToMemory();
    updateTotalPrice();
};

// Update your checkout button event listener
document.querySelector('.checkOut').addEventListener('click', function() {
    // Use a more robust method to extract the number from the string
    const totalPriceText = document.getElementById('totalPrice').textContent;
    const totalPrice = parseFloat(totalPriceText.replace(/[^\d.]/g, ''));
    
    console.log("Checkout amount: " + totalPrice); // For debugging
    
    if (totalPrice > 0) {
        document.getElementById('amount').value = totalPrice.toFixed(2);
        document.getElementById('paymentForm').style.display = 'block';
        document.getElementById('paymentForm').scrollIntoView({ behavior: 'smooth' });
    } else {
        alert('Please add items to your cart before checkout.');
    }
});
// Update your updateTotalPrice function
function updateTotalPrice() {
    let total = 0;
    document.querySelectorAll('.listCart .item').forEach(item => {
        const priceText = item.querySelector('.totalPrice').textContent;
        const price = parseFloat(priceText.replace('NPR.', '').replace(',', '').trim());
        total += price;
    });
    document.getElementById('totalPrice').textContent = 'Rs. ' + total.toFixed(2);
}

const initApp = () => {
    fetch('Cart.json')
    .then(response => response.json())
    .then(data => {
        products = data;
        addDataToHTML();

        if(localStorage.getItem('cart')){
            cart = JSON.parse(localStorage.getItem('cart'));
            addCartToHTML();
            updateTotalPrice();
        }
    });
};

initApp();
