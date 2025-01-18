<?php
require 'admin/includes/config.php';  // Ensure the path is correct

// Start the session to access the stored transaction_id
session_start();

// Retrieve the stored transaction ID from session
$transactionId = $_SESSION['transaction_id'] ?? null;
if (!$transactionId) {
    // Handle the case where there is no transaction ID
    echo "Error: Transaction ID not found.";
    exit;
}

// Retrieve payment details from POST request
$method = $_POST['method'] ?? 'unknown';
$amount = $_POST['amount'] ?? '0.00';
$bank = $_POST['bank'] ?? 'N/A';
$status = 'completed';
$date = date('Y-m-d H:i:s');

// Insert payment data into the payments table
try {
    $stmt = $dbh->prepare("INSERT INTO payments (transaction_id, method, amount, bank, status, date) 
                           VALUES (:transaction_id, :method, :amount, :bank, :status, :date)");
    $stmt->execute([
        ':transaction_id' => $transactionId,
        ':method' => $method,
        ':amount' => $amount,
        ':bank' => $bank,
        ':status' => $status,
        ':date' => $date
    ]);

    // Optionally, update the user_info table with the transaction ID (if user is logged in)
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $updateStmt = $dbh->prepare("UPDATE user_info SET last_transaction_id = :transaction_id WHERE user_id = :user_id");
        $updateStmt->execute([
            ':transaction_id' => $transactionId,
            ':user_id' => $user_id
        ]);
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful</title>
    <style>
        body { 
        
            
            background: linear-gradient(to right, #021f28, #607cad); 
            color: #fff; 
        }
        h2 { 
            color: #0cee14; /* Base color */
            font-size:25px; /* Larger initial font size */
            font-weight: bold; /* Ensure text is bold */
            text-transform: uppercase; /* Make text uppercase */
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4), 0 0 10px #0cee14, 0 0 20px #0cee14; /* Glowing effect */
            background: linear-gradient(to right, #0cee14, #06a504); /* Gradient effect */
            -webkit-background-clip: text; /* Apply gradient to text */
            -webkit-text-fill-color: transparent; /* Makes the gradient visible */
            margin-bottom: 20px;
            animation: shrinkEffect 1s ease-in-out; /* Apply shrink animation */
        }
        
        /* Animation Keyframes */
        @keyframes shrinkEffect {
            0% { transform: scale(1.5); } /* Start larger */
            100% { transform: scale(1); } /* Shrink to normal size */
        }
        
        
        .container { max-width: 900px; margin: 50px auto; padding: 20px; background-color: white; border-radius: 10px; text-align: center; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }
        p { 
            font-size: 1.2rem; 
            margin: 10px 0; 
            color: #444; 
        }
        .transaction-details { 
            margin-top: 20px; 
            text-align: left; 
            background: #f8f9fa; 
            padding: 15px; 
            border-radius: 10px; 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
        }
        .transaction-details p { 
            font-size: 1.1rem; 
            color: #555; 
        }
        a, .submit-button, .print-button { 
            display: inline-block; 
            margin-top: 20px; 
            padding: 12px 25px; 
            text-decoration: none; 
            border-radius: 5px; 
            font-size: 1rem; 
            font-weight: bold; 
            transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.2s ease; 
        }
        a { 
            background: linear-gradient(to right, #ff7e5f, #feb47b); 
            color: white; 
        }
        a:hover { 
            background: linear-gradient(to right, #feb47b, #ff7e5f); 
            transform: scale(1.05); 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); 
        }
        .submit-button { 
            background: linear-gradient(to right, #11998e, #38ef7d); 
            color: white; 
            cursor: pointer; 
        }
        .submit-button:hover { 
            background: linear-gradient(to right, #38ef7d, #11998e); 
            transform: scale(1.05); 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); 
        }
        .print-button { 
            background: linear-gradient(to right, #396afc, #2948ff); 
            color: white; 
            cursor: pointer; 
        }
        .print-button:hover { 
            background: linear-gradient(to right, #2948ff, #396afc); 
            transform: scale(1.05); 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); 
        }
        @media (max-width: 600px) {
            .container { 
                padding: 20px; 
            }
            p { 
                font-size: 1rem; 
            }
        }
    </style>
    </style>
    <script>
        function showAlert() {
            alert("Payment Successful");
            // You could send an AJAX request here to update the user_info table with the transaction ID
            var transactionId = "<?php echo $transactionId; ?>";

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "update_user_info.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("transaction_id=" + transactionId);

            xhr.onload = function() {
                if (xhr.status === 200) {
                    console.log("Transaction ID added to user_info table.");
                } else {
                    console.error("Error updating user_info table.");
                }
            };
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Payment Successful!</h2>
        
        <div class="transaction-details">
            <p><strong>Transaction ID:</strong> <?php echo htmlspecialchars($transactionId); ?></p>
            <p><strong>Payment Method:</strong> <?php echo ucfirst(htmlspecialchars($method)); ?></p>
            <p><strong>Amount:</strong> NPR <?php echo htmlspecialchars($amount); ?></p>
            <p><strong>Bank:</strong> <?php echo htmlspecialchars($bank); ?></p>
            <p><strong>Status:</strong> <?php echo ucfirst(htmlspecialchars($status)); ?></p>
            <p><strong>Date:</strong> <?php echo htmlspecialchars($date); ?></p>
        </div>
        
        <a href="index.php">Go to your dashboard</a>
       
        <button class="print-button" onclick="window.print()">Print Receipt</button>
        <button class="submit-button" onclick="showAlert()">Submit</button>
    </div>
</body>
</html>
