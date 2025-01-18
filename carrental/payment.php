<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter Payment Amount</title>
    <style>
        body { 
            font-family: Arial, sans-serif;
            background-image: url("assets/images/SAV.jpg");
            background-size: cover;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            max-width: 90%;
            width: 600px;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
        }
        h2 {
            color: #1565c0;
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }
        input[type="number"] {
            padding: 10px;
            width: 100%;
            border: 1px solid #90caf9;
            border-radius: 5px;
            font-size: 1rem;
            color: #333;
            margin-bottom: 15px;
        }
        .button {
            width: 100%;
            background-color: #1976d2;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-align: center;
        }
        .button:hover {
            background-color: #0d47a1;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Enter Payment Amount</h2>
        <!-- Form now sends the amount to the payment_options.php page -->
        <form action="payment_options.php" method="GET">
            
            <label for="amount">Enter Amount (NPR):</label>
            <input type="number" id="amount" name="amount" required min="1" step="0.01" placeholder="Enter amount in NPR">
            <button type="submit" class="button">Proceed to Payment Options</button>
        </form>
    </div>

    
</body>
</html>
