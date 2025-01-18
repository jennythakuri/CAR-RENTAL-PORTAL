<?php
session_start();
include('includes/config.php');

// Function to generate unique transaction ID
function generateTransactionID() {
    return strtoupper(uniqid('TRX-', true)); // Generates a unique transaction ID starting with "TRX-"
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $phone_code = $_POST['phone_code'];
    $phone = $_POST['phone'];
    $dob = $_POST['dob'];
    $citizenship = $_POST['citizenship'];
    $gender = $_POST['gender'];
    $district = $_POST['district'];
    $province = $_POST['province'];
    $occupation = $_POST['occupation'];
    $nationality = $_POST['nationality'];
    $city = $_POST['city'];
    $remarks = $_POST['remarks'];

    // Generate transaction ID
    $transaction_id = generateTransactionID();

    // Store the transaction ID in the session
    $_SESSION['transaction_id'] = $transaction_id;

    // Create PDO connection
    try {
        $stmt = $dbh->prepare("INSERT INTO user_info (transaction_id, first_name, last_name, address, email, phone_code, phone, dob, citizenship, gender, district, province, occupation, nationality, city, remarks) 
        VALUES (:transaction_id, :first_name, :last_name, :address, :email, :phone_code, :phone, :dob, :citizenship, :gender, :district, :province, :occupation, :nationality, :city, :remarks)");

        // Bind parameters
        $stmt->bindParam(':transaction_id', $transaction_id);
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone_code', $phone_code);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':dob', $dob);
        $stmt->bindParam(':citizenship', $citizenship);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':district', $district);
        $stmt->bindParam(':province', $province);
        $stmt->bindParam(':occupation', $occupation);
        $stmt->bindParam(':nationality', $nationality);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':remarks', $remarks);

        // Execute the query
        if ($stmt->execute()) {
            echo '<script>alert("Data inserted successfully! Transaction ID: ' . $transaction_id . ' NOW CLICK TO NEXT BTN");</script>';
        } else {
            echo '<script>alert("Failed to insert data.");</script>';
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>



<!-- janaki -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Info</title>
    <style>
        /* General Styling */
        /* General Styling */
/* General Styling */
/* General Styling */
body {
    font-family: Arial, sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    margin: 0;
    background: linear-gradient(135deg, #1976d2, #42a5f5);
    padding: 10px;
    flex-direction: column;
}

/* Marquee Styling */
.marquee-container {
    width: 100%;
    background-color: #1976d2;
    color: white;
    padding: 10px;
    font-size: 18px;
    text-align: center;
    margin-bottom: 20px;
}

.marquee-container marquee {
    font-weight: bold;
    color: #ffffff;
}

.container {
    width: 100%;
    max-width: 100%; /* Ensure the container stretches to fill the available width */
    background: #fff;
    padding: 30px;
    font-weight: bold;
    border-radius: 10px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    margin: 0;
}

h2 {
    color: #1976d2;
    margin-bottom: 20px;
    text-align: center;
}

.input-field {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 16px;
    transition: border 0.3s;
}

.input-field:focus {
    border-color: #1976d2;
    outline: none;
}

.form-group {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    margin-bottom: 20px;
}

.form-group .input-field {
    width: 48%; /* Ensure each input takes up half the width */
}

.phone-group {
    display: flex;
    gap: 10px;
    flex-wrap: nowrap;
}

.phone-code,
.phone-number {
    width: 48%;
}

.gender-group {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    margin-top: 10px;
}

.gender-group label {
    width: 30%;
    text-align: left;
}

/* .button-container {
    display: flex;
    justify-content: center;
    width: 100%;
}
*/
.button {
    padding: 14px 20px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 18px;
    transition: background-color 0.3s;
    margin-top: 20px;
} 

.button-container {
    display: flex;
    justify-content: center;
    gap: 20px; /* Space between buttons */
    margin-top: 20px; /* Optional, adds space from elements above */
}

/* .button {
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    border: none;
    border-radius: 5px;
    transition: background-color 0.3s ease, transform 0.2s ease;
} */

.submit-btn {
    background-color: #4CAF50; /* Green for Submit */
    color: white;
}

.submit-btn:hover {
    background-color: #45a049; /* Darker green on hover */
    transform: scale(1.05); /* Slightly increase size on hover */
}

.next-btn {
    background-color: #008CBA; /* Blue for Next */
    color: white;
}

.next-btn:hover {
    background-color: #007bb5; /* Darker blue on hover */
    transform: scale(1.05); /* Slightly increase size on hover */
}


.button:hover {
    background-color: #45a049;
}

.error {
    color: #e53935;
    margin-top: 10px;
    text-align: center;
}

/* Responsive Design */
@media (max-width: 768px) {
    .form-group {
        flex-direction: column;
    }

    .form-group .input-field {
        width: 100%;
    }

    .phone-group {
        flex-direction: column;
    }

    .phone-code,
    .phone-number {
        width: 100%;
    }

    .gender-group {
        flex-direction: column;
        align-items: flex-start;
    }

    .gender-group label {
        width: 100%;
    }
}

    </style>
</head>
<body>

    <!-- Marquee Section -->
    <div class="marquee-container">
        <marquee>Welcome! Please enter your details to proceed with the payment. All fields are required.</marquee>
    </div>

    <!-- User Information Form -->
    <div class="container">
        <h2>Enter Your Information</h2>
        <!-- <form action="payment.php" method="POST" id="userInfoForm"> -->
        <form action="user_info.php" method="POST" id="userInfoForm">
            <div class="form-group">
                <input type="text" name="first_name" id="first_name" placeholder="First Name" class="input-field" required>
                <input type="text" name="last_name" id="last_name" placeholder="Last Name" class="input-field" required>
            </div>

            <div class="form-group">
                <input type="text" name="address" id="address" placeholder="Address" class="input-field" required>
                <input type="email" name="email" id="email" placeholder="Email" class="input-field" required>
            </div>

            <div class="form-group phone-group">
                <select name="phone_code" id="phone_code" class="input-field phone-code" required>
                    <option value="+977">+977 (Nepal)</option>
                </select>
                <input type="tel" name="phone" id="phone" placeholder="Phone Number" class="input-field phone-number" required>
            </div>

            <div class="form-group">
                <input type="date" name="dob" id="dob" class="input-field" required>
                <input type="text" name="citizenship" id="citizenship" placeholder="Citizenship Number" class="input-field" required>
            </div>

            <div class="gender-group">
                <label><input type="radio" name="gender" value="male" required> Male</label>
                <label><input type="radio" name="gender" value="female"> Female</label>
                <label><input type="radio" name="gender" value="other"> Other</label>
            </div>

            <div class="form-group">
    <select name="district" id="district" class="input-field" required>
        <option value="">Select District</option>
        
        <!-- Province No. 1 -->
        <option value="Bhojpur">Bhojpur</option>
        <option value="Dhankuta">Dhankuta</option>
        <option value="Ilam">Ilam</option>
        <option value="Jhapa">Jhapa</option>
        <option value="Khotang">Khotang</option>
        <option value="Morang">Morang</option>
        <option value="Okhaldhunga">Okhaldhunga</option>
        <option value="Panchthar">Panchthar</option>
        <option value="Sankhuwasabha">Sankhuwasabha</option>
        <option value="Solukhumbu">Solukhumbu</option>
        <option value="Sunsari">Sunsari</option>
        <option value="Taplejung">Taplejung</option>
        <option value="Terhathum">Terhathum</option>
        <option value="Udayapur">Udayapur</option>
        
        <!-- Madhesh Province -->
        <option value="Bara">Bara</option>
        <option value="Dhanusha">Dhanusha</option>
        <option value="Mahottari">Mahottari</option>
        <option value="Parsa">Parsa</option>
        <option value="Rautahat">Rautahat</option>
        <option value="Saptari">Saptari</option>
        <option value="Sarlahi">Sarlahi</option>
        <option value="Siraha">Siraha</option>
        
        <!-- Bagmati Province -->
        <option value="Bhaktapur">Bhaktapur</option>
        <option value="Chitwan">Chitwan</option>
        <option value="Dhading">Dhading</option>
        <option value="Dolakha">Dolakha</option>
        <option value="Kathmandu">Kathmandu</option>
        <option value="Kavrepalanchok">Kavrepalanchok</option>
        <option value="Lalitpur">Lalitpur</option>
        <option value="Makwanpur">Makwanpur</option>
        <option value="Nuwakot">Nuwakot</option>
        <option value="Ramechhap">Ramechhap</option>
        <option value="Rasuwa">Rasuwa</option>
        <option value="Sindhuli">Sindhuli</option>
        <option value="Sindhupalchok">Sindhupalchok</option>
        
        <!-- Gandaki Province -->
        <option value="Baglung">Baglung</option>
        <option value="Gorkha">Gorkha</option>
        <option value="Kaski">Kaski</option>
        <option value="Lamjung">Lamjung</option>
        <option value="Manang">Manang</option>
        <option value="Mustang">Mustang</option>
        <option value="Myagdi">Myagdi</option>
        <option value="Nawalpur">Nawalpur</option>
        <option value="Parbat">Parbat</option>
        <option value="Syangja">Syangja</option>
        <option value="Tanahun">Tanahun</option>
        
        <!-- Lumbini Province -->
        <option value="Arghakhanchi">Arghakhanchi</option>
        <option value="Banke">Banke</option>
        <option value="Bardiya">Bardiya</option>
        <option value="Dang">Dang</option>
        <option value="Gulmi">Gulmi</option>
        <option value="Kapilvastu">Kapilvastu</option>
        <option value="Palpa">Palpa</option>
        <option value="Pyuthan">Pyuthan</option>
        <option value="Rolpa">Rolpa</option>
        <option value="Rukum East">Rukum East</option>
        <option value="Rupandehi">Rupandehi</option>
        
        <!-- Karnali Province -->
        <option value="Dailekh">Dailekh</option>
        <option value="Dolpa">Dolpa</option>
        <option value="Humla">Humla</option>
        <option value="Jajarkot">Jajarkot</option>
        <option value="Jumla">Jumla</option>
        <option value="Kalikot">Kalikot</option>
        <option value="Mugu">Mugu</option>
        <option value="Rukum West">Rukum West</option>
        <option value="Salyan">Salyan</option>
        <option value="Surkhet">Surkhet</option>
        
        <!-- Sudurpashchim Province -->
        <option value="Achham">Achham</option>
        <option value="Baitadi">Baitadi</option>
        <option value="Bajhang">Bajhang</option>
        <option value="Bajura">Bajura</option>
        <option value="Dadeldhura">Dadeldhura</option>
        <option value="Darchula">Darchula</option>
        <option value="Doti">Doti</option>
        <option value="Kailali">Kailali</option>
        <option value="Kanchanpur">Kanchanpur</option>
    </select>


                <select name="province" id="province" class="input-field" required>
                    <option value="">Select Province</option>
                    <option value="Province No. 1">Province No. 1</option>
                    <option value="Madhesh">Madhesh</option>
                    <option value="Bagmati">Bagmati</option>
                    <option value="Gandaki">Gandaki</option>
                    <option value="Lumbini">Lumbini</option>
                    <option value="Karnali">Karnali</option>
                    <option value="Sudurpashchim">Sudurpashchim</option>
                </select>
            </div>

            <div class="form-group">
                <select name="occupation" id="occupation" class="input-field" required>
                    <option value="">Select Occupation</option>
                    <option value="Engineer">Engineer</option>
                    <option value="Doctor">Doctor</option>
                    <option value="Student">Student</option>
                    <option value="Teacher">Teacher</option>
                    <option value="Businessperson">Businessperson</option>
                    <option value="Farmer">Farmer</option>
                    <option value="Artist">Artist</option>
                    <option value="Scientist">Scientist</option>
                    <option value="Lawyer">Lawyer</option>
                    <option value="Accountant">Accountant</option>
                    <option value="Nurse">Nurse</option>
                    <option value="Technician">Technician</option>
                    <option value="Self-employed">Self-employed</option>
                    <option value="Government Employee">Government Employee</option>
                    <option value="Unemployed">Unemployed</option>
                    <option value="Retired">Retired</option>
                    <option value="Other">Other</option>
                </select>
                <select name="nationality" id="nationality" class="input-field" required>
                    <option value="">Select Nationality</option>
                    <option value="Nepali">Nepali</option>
                    <option value="Indian">Indian</option>
                </select>
            </div>

            <input type="text" name="city" id="city" placeholder="City" class="input-field" required>
            <input type="text" name="remarks" id="remarks" placeholder="Remarks (optional)" class="input-field">

            <div class="button-container">
            <button type="submit" class="button" onclick="showAlert()">Submit</button>

                <button type="button" class="button next-btn" onclick="window.location.href='payment.php'">Next</button>
                            </div>
        </form>

        <div id="error-message" class="error"></div>
    </div>

    <script>
        // Client-side form validation
// Client-side form validation
document.getElementById("userInfoForm").addEventListener("submit", function(event) {
    let errorMessage = "";
    let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    let phonePattern = /^[0-9]{10}$/;
    let citizenshipPattern = /^\d{2}-\d{2}-\d{2}-\d{5}$/;

    let email = document.getElementById("email").value;
    let phone = document.getElementById("phone").value;
    let citizenship = document.getElementById("citizenship").value;

    if (!emailPattern.test(email)) {
        errorMessage += "Invalid email format.\n";
    }
    if (!phonePattern.test(phone)) {
        errorMessage += "Phone number must be 10 digits.\n";
    }
    if (!citizenshipPattern.test(citizenship)) {
        errorMessage += "Invalid citizenship number format (XX-XX-XX-XXXXX).\n";
    }

    if (errorMessage) {
        document.getElementById("error-message").innerText = errorMessage;
        event.preventDefault();  // Prevent form submission
    }
});
<script>
</body>
</html>
