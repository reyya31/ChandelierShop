<?php 
session_start(); 

// Get query parameters from eSewa (if they send them in the redirect)
$transaction_id = isset($_GET['transaction_uuid']) ? $_GET['transaction_uuid'] : 'txn-' . uniqid();
$amount = isset($_GET['amount']) ? $_GET['amount'] : '20000.00';
$reference_id = 'ESEWA' . strtoupper(substr(uniqid(), 0, 8));
$datetime = date('M d, Y, g:i a'); // Current date and time formatted

// Clear the cart
echo "<script>window.onload = function() { localStorage.removeItem('cart'); }</script>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            border-bottom: 1px solid #eee;
        }
        .title {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }
        .success-title {
            color: #27ae60;
            font-size: 24px;
            font-weight: bold;
            margin: 0;
        }
        .icon {
            background-color: #27ae60;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 20px;
        }
        .message {
            padding: 20px;
            color: #666;
            text-align: right;
        }
        .details {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            margin: 0 20px 20px;
        }
        .detail-row {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            margin-bottom: 10px;
        }
        .detail-label {
            color: #888;
            font-size: 12px;
            margin-bottom: 3px;
        }
        .detail-value {
            color: #333;
            font-weight: bold;
            font-size: 14px;
        }
        .continue-btn {
            display: block;
            background-color: #3498db;
            color: white;
            text-align: center;
            padding: 12px;
            margin: 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .note {
            padding: 0 20px 20px;
            color: #888;
            font-size: 12px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="icon">&#10003;</div>
            <div class="title">
                <h1 class="success-title">Payment Successful!</h1>
            </div>
        </div>
        
        <div class="message">
            Thank you for your purchase at Luminara Luxe. Your transaction has been completed successfully.
        </div>
        
        <div class="details">
            <div class="detail-row">
                <span class="detail-label">Transaction ID: Unknown</span>
                <span class="detail-value"><?php echo $transaction_id; ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Amount Paid: NPR</span>
                <span class="detail-value"><?php echo number_format((float)$amount, 2); ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">eSewa Reference ID: Unknown</span>
                <span class="detail-value"><?php echo $reference_id; ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Date: April 15, 2023, 4:53 pm</span>
                <span class="detail-value"><?php echo $datetime; ?></span>
            </div>
        </div>
        
        <a href="index.html" class="continue-btn">Continue Shopping</a>
        
        <div class="note">
            A confirmation email has been sent to your registered email address.
        </div>
    </div>
</body>
</html>