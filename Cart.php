<?php
session_start();

function generateEsewaSignature($secretKey, $amount, $transactionUuid, $merchantCode) {
    $signatureString = "total_amount=$amount,transaction_uuid=$transactionUuid,product_code=$merchantCode";
    $hash = hash_hmac('sha256', $signatureString, $secretKey, true);
    return base64_encode($hash);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkout'])) {
    $amount = $_POST['amount'] ?? '';
    $productName = $_POST['productName'] ?? 'Luminara Luxe Products';
    $transactionId = $_POST['transactionId'] ?? '';
    
    // Add debugging
    error_log("eSewa Payment Request - Amount: $amount, TransactionID: $transactionId");
    
    if (empty($amount) || empty($transactionId)) {
        die('Missing required parameters.');
    }

    // eSewa Configuration (TEST ENVIRONMENT)
    $merchantCode = "EPAYTEST";
    $secretKey = "8gBm/:&EnhH.1/q";
    $successUrl = "http://localhost/Chandelier/esewa_success.php";
    $failureUrl = "http://localhost/Chandelier/esewa_failure.php";
    $transactionUuid = uniqid("txn-", true);

    $signature = generateEsewaSignature($secretKey, $amount, $transactionUuid, $merchantCode);

    $esewaConfig = [
        "amount" => $amount,
        "tax_amount" => "0",
        "total_amount" => $amount,
        "transaction_uuid" => $transactionUuid,
        "product_code" => $merchantCode,
        "product_service_charge" => "0",
        "product_delivery_charge" => "0",
        "success_url" => $successUrl,
        "failure_url" => $failureUrl,
        "signed_field_names" => "total_amount,transaction_uuid,product_code",
        "signature" => $signature,
    ];

    $paymentUrl = "https://rc-epay.esewa.com.np/api/epay/main/v2/form";
    
    echo "<form id='esewaForm' method='POST' action='$paymentUrl'>";
    foreach ($esewaConfig as $key => $value) {
        echo "<input type='hidden' name='$key' value='$value'>";
    }
    echo "</form>";
    echo "<script>document.getElementById('esewaForm').submit();</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Your Cart - Luminara Luxe</title>
    <link rel="stylesheet" href="Cart.css" />
    <script defer src="Cart.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css"
    />
</head>
<body class="">
    <div class="container">
        <header>
            <div class="title">PRODUCT LIST</div>
            <div class="icon-cart">
                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 15a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm0 0h8m-8 0-1-4m9 4a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-9-4h10l2-7H3m2 7L3 4m0 0-.792-3H1"/>
                </svg>
                <span>0</span>
            </div>
        </header>
        <div class="listProduct">
            <!-- Products will be listed here -->
        </div>
    </div>
    <div class="cartTab">
        <h1>Shopping Cart</h1>
        <div class="listCart">
            <!-- Cart items will be listed here -->
        </div>
        <div class="cartTotal">
            <h3>Total: <span id="totalPrice">Rs. 0</span></h3>
        </div>
        <div class="btn">
    <button class="close">CLOSE</button>
    <button class="checkOut">CHECK OUT</button>
</div>
    </div>

    <form id="paymentForm" method="POST" style="display: none; padding: 20px; margin-top: 20px;">
    <input type="hidden" id="amount" name="amount" value="0">
    <input type="hidden" name="productName" value="Luminara Luxe Products">
    <input type="hidden" id="transactionId" name="transactionId" value="<?php echo uniqid('txn-'); ?>">
    <input type="hidden" name="checkout" value="1">
    
    <button type="submit" class="checkOutBtn" style="background-color: green; color: white; font-size: 1.5rem; display: flex; align-items: center; justify-content: center; margin-right: 2rem; padding: 1rem 0; border-radius: 1rem; width: 100%;">
        Pay with eSewa
    </button>
</form>

<script>
        // This should be in your Cart.js file, but I'm including it here for completeness
        document.addEventListener('DOMContentLoaded', () => {
            // Your existing cart functionality
            // ...

            // When checkout button is clicked
            document.querySelector('.checkOut').addEventListener('click', function() {
                const totalPrice = parseFloat(document.getElementById('totalPrice').textContent.replace('Rs. ', ''));
                if (totalPrice > 0) {
                    document.getElementById('amount').value = totalPrice;
                    document.getElementById('paymentForm').style.display = 'block';
                    
                    // Scroll to the payment form
                    document.getElementById('paymentForm').scrollIntoView({ behavior: 'smooth' });
                } else {
                    alert('Please add items to your cart before checkout.');
                }
            });
            
            // Update total price function (should be called whenever cart items change)
            function updateTotalPrice() {
                let total = 0;
                document.querySelectorAll('.listCart .item').forEach(item => {
                    const price = parseFloat(item.querySelector('.price').textContent.replace('Rs. ', ''));
                    const quantity = parseInt(item.querySelector('.quantity').textContent);
                    total += price * quantity;
                });
                
                document.getElementById('totalPrice').textContent = 'Rs. ' + total.toFixed(2);
            }
            
            // Make sure to call updateTotalPrice() whenever cart items are added/removed or quantities change
        });
    </script>
    <script src="Cart.js"></script>
</body>
</html>