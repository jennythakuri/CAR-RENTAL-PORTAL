<?php
$method = isset($_GET['method']) ? $_GET['method'] : 'unknown';
$amount = isset($_GET['amount']) ? htmlspecialchars($_GET['amount']) : '0.00';
$bank = isset($_GET['bank']) ? $_GET['bank'] : 'N/A';
$remark = isset($_GET['remark']) ? htmlspecialchars($_GET['remark']) : 'Payment for service';

// If the method does not require a bank, set a default bank name.
if (in_array($method, ['khalti', 'fonepay'])) {
    $bank = 'N/A';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Payment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        p {
            color: #555;
            font-size: 16px;
            margin: 10px 0;
            text-align: center;
        }

        .confirm-details {
            background-color: #f4f4f4;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
            text-align: center;
        }

        .confirm-details p {
            margin-bottom: 10px;
            font-size: 18px;
        }

        .form-group {
            text-align: center;
        }

        .form-group button {
            padding: 10px 30px;
            font-size: 18px;
            color: white;
            background-color: #4CAF50;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .form-group button:hover {
            background-color: #45a049;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                margin: 20px;
                padding: 15px;
            }
            h2 {
                font-size: 24px;
            }
            p {
                font-size: 14px;
            }
        }

        @media (max-width: 480px) {
            .confirm-details p {
                font-size: 16px;
            }
            .form-group button {
                width: 100%;
                padding: 12px;
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Confirm Payment</h2>
        
        <div class="confirm-details">
            <p>Payment Method: <?php echo ucfirst($method); ?></p>
            <p>Amount: NPR <?php echo $amount; ?></p>
            <p>Bank: <?php echo $bank; ?></p>
            <p>Remark: <?php echo $remark; ?></p>  







        </div>

        <form action="payment_success.php" method="POST">
            <input type="hidden" name="method" value="<?php echo htmlspecialchars($method); ?>">
            <input type="hidden" name="amount" value="<?php echo htmlspecialchars($amount); ?>">
            <input type="hidden" name="bank" value="<?php echo htmlspecialchars($bank); ?>">
             <input type="hidden" name="remark" value="<?php echo htmlspecialchars($remark); ?>"> 
            <div class="form-group">
                <button type="submit">Confirm and Pay</button>
            </div>
        </form>
    </div>
</body>
</html>
