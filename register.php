<?php

$connection = mysqli_connect("localhost","root","","platform");
$database = mysqli_select_db($connection,"platform");

$username = $phone = $tran_pass = $password = $gender = $invite = $errormsgg = $account = $my_code = "";

if (isset($_POST["submiter"])) {
    if (empty($_POST['uname']) || empty($_POST['phone']) || empty($_POST['tr_pass']) || empty($_POST['pas']) || empty($_POST['rad']) || empty($_POST['invite'])) {
        $errormsgg = "Empty fields!";
    } else {
        $username = mysqli_real_escape_string($connection, $_POST['uname']);
        $phone = mysqli_real_escape_string($connection, $_POST['phone']);
        $tran_pass = mysqli_real_escape_string($connection, $_POST['tr_pass']);
        $password = mysqli_real_escape_string($connection, $_POST['pas']);
        $gender = mysqli_real_escape_string($connection, $_POST['rad']);
        $invite = mysqli_real_escape_string($connection, $_POST['invite']);

        // Check if the invitation code exists
        $invite_check = "SELECT * FROM platform_table WHERE my_code = '$invite'";
        $result = mysqli_query($connection, $invite_check);

        if (mysqli_num_rows($result) == 0) {
            // If the invitation code doesn't exist, deny registration
            echo "<script>alert('Invalid invitation code, try again!');</script>";
            $errormsgg = "Invalid invitation code!";
        } else {
            // Get inviter's details
            $inviter = mysqli_fetch_assoc($result);
            $inviter_id = $inviter['id'];
            $inviter_balance = $inviter['account'];

            // Generate a new invitation code for the new user
            $my_code = generateRandomCode(6);
            $account = 25.00;

            // Insert new user data
            $sql = "INSERT INTO platform_table(username, phone, transaction_password, passwordd, gender, invitation_code, account, my_code, inviter_id) 
                    VALUES ('$username', '$phone', '$tran_pass', '$password', '$gender', '$invite', '$account', '$my_code', '$inviter_id')";
            $query = mysqli_query($connection, $sql);

            if ($query) {
                // Give the invitee 20% of the inviter's earnings
                distributeEarnings($inviter_id, $inviter_balance);

                echo "<script>
                    alert('Registration successful. Login to proceed.');
                    window.location.href = 'index.php';
                </script>";
            } else {
                $errormsgg = "Error registering user!";
            }
        }
    }
}

// Function to generate a random invitation code
function generateRandomCode($length = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    return substr(str_shuffle($characters), 0, $length);
}

// Function to distribute 20% earnings to the invitee
function distributeEarnings($user_id, $amount) {
    global $connection;

    // Calculate 20% commission
    $commission = 0.20 * $amount;

    // Fetch all users invited by this user
    $query = "SELECT * FROM platform_table WHERE inviter_id = '$user_id'";
    $result = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $invitee_id = $row['id'];
        
        // Update invitee's account balance
        $update = "UPDATE platform_table SET account = account + $commission WHERE id = '$invitee_id'";
        mysqli_query($connection, $update);
    }
}
?>





<html>
<head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
   <link rel="stylesheet" href="loging.css">
  </head> 
<body>

 <div id="register">
      <form name="regist" method="POST" POST="logingpage.php" autocomplete="on">
      <h2></h2>
      
       <div onclick="closepage1()"><i class="fa fa-times" id="close"></i></div>
       <h3 class="error"><?php echo $errormsgg; ?></h3>
       <label for="username">Username</label><br>
          <input type="text" name="uname" id="use1" class="us" placeholder="Enter name" value="<?php echo $username; ?>" required><i class="fa fa-user" id="una1"></i><br>

        <label for="phone">Phone</label><br>
          <input type="text" name="phone" id="use1" class="us" placeholder="Phone number" value="<?php echo $phone; ?>" required><i class="fa fa-phone" id="una1"></i><br>

        <label for="transaction_password">Transaction Password</label><br>
        <input type="password" name="tr_pass" id="use1" class="us" placeholder="transaction key" value="<?php echo $tran_pass; ?>" ><i class="fa fa-key" id="una1"></i><br>

        <label for="password">Password</label><br>
      <input type="password" name="pas" id="use1" class="us" placeholder="Password" value="<?php echo $password; ?>"  required>
          <i class="fa fa-unlock-alt" id="una1"></i><br>

        <label for="Gender">Gender</label>
        <input type="radio" name="rad" value="Female">Female
        <input type="radio" name="rad" value="Male">Male<br>

        <label for="invitation_code">Invitation code</label>
        <input type="text" name="invite" id="inv" required><br>

        <input type="submit" name="submiter" id="sub1" value="Submit">

    </div>

  </form>
</div>

<script>
function closepage1(){
  document.getElementById("register").style.display="none";
}
</script>
</body>
</html>