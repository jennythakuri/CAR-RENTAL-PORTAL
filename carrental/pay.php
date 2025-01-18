<?php
$method = isset($_GET['method']) ? $_GET['method'] : 'unknown';
$amount = isset($_GET['amount']) ? htmlspecialchars($_GET['amount']) : '0.00';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Bank</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        p {
            color: #555;
            margin: 10px 0;
            text-align: center;
        }
        #bankSelection {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        .bank-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 15px;
            margin: 10px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
            width: calc(33.33% - 20px);
            box-sizing: border-box;
        }
        .bank-item img {
            max-width: 60px;
            margin-bottom: 10px;
        }
        .bank-item:hover {
            background-color: #eaeaea;
            transform: scale(1.02);
        }
        .bank-button {
            padding: 10px 20px;
            border: none;
            border-radius: 25px;
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .bank-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Select Your Bank</h2>
        <p>Payment Method: <?php echo ucfirst($method); ?></p>
        <p>Amount: NPR <?php echo $amount; ?></p>

        <div id="bankSelection">
            <div class="bank-item">
                <a href="confirm_payment.php?method=<?php echo urlencode($method); ?>&amount=<?php echo urlencode($amount); ?>&bank=Nepal%20Investment%20Bank">
                    <button class="bank-button">Nepal Investment Bank</button>
                </a>
                <img src="assets/images/nib_logo.png" alt="Nepal Investment Bank">
            </div>
            <div class="bank-item">
                <a href="confirm_payment.php?method=<?php echo urlencode($method); ?>&amount=<?php echo urlencode($amount); ?>&bank=Nabil%20Bank">
                    <button class="bank-button">Nabil Bank</button>
                </a>
                <img src="assets/images/nabil_logo.png" alt="Nabil Bank">
            </div>
            <div class="bank-item">
                <a href="confirm_payment.php?method=<?php echo urlencode($method); ?>&amount=<?php echo urlencode($amount); ?>&bank=Himalayan%20Bank">
                    <button class="bank-button">Himalayan Bank</button>
                </a>
                <img src="assets/images/himalayan_logo.png" alt="Himalayan Bank">
            </div>
            <div class="bank-item">
                <a href="confirm_payment.php?method=<?php echo urlencode($method); ?>&amount=<?php echo urlencode($amount); ?>&bank=Standard%20Chartered%20Bank%20Nepal">
                    <button class="bank-button">Standard Chartered Bank Nepal</button>
                </a>
                <img src="assets/images/standard_chartered_logo.png" alt="Standard Chartered Bank Nepal">
            </div>
            <div class="bank-item">
                <a href="confirm_payment.php?method=<?php echo urlencode($method); ?>&amount=<?php echo urlencode($amount); ?>&bank=Nepal%20SBI%20Bank">
                    <button class="bank-button">Nepal SBI Bank</button>
                </a>
                <img src="assets/images/nepal_sbi_logo.png" alt="Nepal SBI Bank">
            </div>
            <div class="bank-item">
                <a href="confirm_payment.php?method=<?php echo urlencode($method); ?>&amount=<?php echo urlencode($amount); ?>&bank=NIC%20Asia%20Bank">
                    <button class="bank-button">NIC Asia Bank</button>
                </a>
                <img src="assets/images/nic_asia_logo.png" alt="NIC Asia Bank">
            </div>
            <div class="bank-item">
                <a href="confirm_payment.php?method=<?php echo urlencode($method); ?>&amount=<?php echo urlencode($amount); ?>&bank=Mega%20Bank%20Nepal">
                    <button class="bank-button">Mega Bank Nepal</button>
                </a>
                <img src="assets/images/mega_bank_logo.png" alt="Mega Bank Nepal">
            </div>
            <div class="bank-item">
                <a href="confirm_payment.php?method=<?php echo urlencode($method); ?>&amount=<?php echo urlencode($amount); ?>&bank=Sanima%20Bank">
                    <button class="bank-button">Sanima Bank</button>
                </a>
                <img src="assets/images/sanima_logo.png" alt="Sanima Bank">
            </div>
            <div class="bank-item">
                <a href="confirm_payment.php?method=<?php echo urlencode($method); ?>&amount=<?php echo urlencode($amount); ?>&bank=Machhapuchhre%20Bank">
                    <button class="bank-button">Machhapuchhre Bank</button>
                </a>
                <img src="assets/images/machhapuchhre_logo.png" alt="Machhapuchhre Bank">
            </div>
            <div class="bank-item">
                <a href="confirm_payment.php?method=<?php echo urlencode($method); ?>&amount=<?php echo urlencode($amount); ?>&bank=Global%20IME%20Bank">
                    <button class="bank-button">Global IME Bank</button>
                </a>
                <img src="assets/images/global_ime_logo.png" alt="Global IME Bank">
            </div>
            <div class="bank-item">
                <a href="confirm_payment.php?method=<?php echo urlencode($method); ?>&amount=<?php echo urlencode($amount); ?>&bank=Kumari%20Bank">
                    <button class="bank-button">Kumari Bank</button>
                </a>
                <img src="assets/images/kumari_logo.png" alt="Kumari Bank">
            </div>
            <div class="bank-item">
                <a href="confirm_payment.php?method=<?php echo urlencode($method); ?>&amount=<?php echo urlencode($amount); ?>&bank=Prabhu%20Bank">
                    <button class="bank-button">Prabhu Bank</button>
                </a>
                <img src="assets/images/prabhu_logo.png" alt="Prabhu Bank">
            </div>
        </div>
    </div>
</body>
</html>
