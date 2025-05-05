<?php
session_start();
$connection = mysqli_connect("localhost", "root", "", "platform");
$database = mysqli_select_db($connection, "platform");

$id = $_SESSION['id'];
$sql = "SELECT * FROM platform_table WHERE id = '$id'";
$query = mysqli_query($connection, $sql);
$result = mysqli_fetch_array($query);
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>

        *{
            padding: 0px;
            margin: 0px;
            border: 0px;

        }

        body{
            background: cyan;
            opacity: 0.8;
        }



        #dep{
            width: 50%;
            height: auto;
            color: cyan;
            box-shadow: 0px 10px 10px rgba(0,0,0,0.8);
            color: black;
            margin: 2em auto;
            line-height: 2em;
            padding: 2em;
            font-size: 1.4em;
            border-right: 5px solid gold;
        }

        #cls {font-size: 1.3em;}

        #bt{
            padding: 1.5em;
            border-radius: 10px;
            background: gold;
        }

        #bt:hover{background: silver;}

        @media screen and (max-width: 480px){      

            #dep{
                max-width: 100%;
                height: auto;

            }
        }
       
    </style>
</head>
<body>

<div id="dep">
    <a href="profile.php">
        <button><i class="fa fa-times" id="cls"></i></button></a><br><br>
    <p>Thank you <?php echo $result["username"] ?>,     
    With your referral code as <?php echo $result["my_code"] ?>.      
    Kindly note, for security reasons and convenience, we urge
    you to contact customer service to help you make a deposit below. Thank you.</p><br>
    <button id="bt">Customer Service</button>
</div>

</body>
</html>
