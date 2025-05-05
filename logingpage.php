
<?php
session_start();

// Database connection
$connection = mysqli_connect("localhost", "root", "", "platform");

$username = $password = $errormsg = "";

// Form submit handling
if (isset($_POST["submit"])) {
    if (empty($_POST["username"]) || empty($_POST["password"])) {
        $errormsg = "Empty fields";
    } else {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $sql = "SELECT * FROM platform_table WHERE username = '$username' AND passwordd = '$password'";
        $query = mysqli_query($connection, $sql);

        if ($query && mysqli_num_rows($query) == 1) {
            $result = mysqli_fetch_array($query);
            $_SESSION['id'] = $result['id'];
            header("Location: indexplatform.php");
            exit;
        } else {
            $errormsg = "Credentials wrong";
        }
    }
}

?>




<!DOCTYPE html>
<html>
<head>
  <title>blueppc logging page</title>
  <link rel="stylesheet" href="loging.css">
  <meta name="viewport" content="width=device-width, scalable=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
  
<body>
  <div id="allforms">
    <div id="myimage"><img src="click.jpg" id="im">

    <div id="topflow">
      <h3>Hello User!!</h3> <span class="auto-type"></span>
    </div>

    </div>

  <div id="firstlog">
    <form name="loggpage" method="POST" action="logingpage.php">
    <div class="typewriter"><h1>Welcome here!!</h1></div><br>
    <h3 class="error"><?php echo $errormsg; ?></h3>
      <div id="aveta"><i class="fa fa-user-circle" id="fa"></i></i></div>
      <h3><i class="fa fa-headphones" id="whatsapp"></i></i></h3>
      <h3></h3>
      <label for="userName">Username</label><br>
      <input type="text" name="username" id="user" class="use" placeholder="Enter UserName" value="<?php echo $username; ?>"><i class="fa fa-user" id="una"></i><br>

      <label for="passWord">Password</label><br>
      <input type="text" name="password" id="pass" class="use" placeholder="Enter PassWord" value="<?php echo $password; ?>" ><i class="fa fa-unlock-alt" id="lock"></i><br>

      <legend id="ee">No account? Register&nbsp<input type="checkbox"  onclick="closepage()"></legend>

       <input type="submit" name="submit" id="sub" value="SubMit">
    </form>
    </div>

  </div>

<div><?php include 'register.php'; ?></div>


   

<script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>

<script>
  var typed = new Typed('.auto-type', {
        
        strings: ['Lets help you with our digital platform', 'That pays daily', 'Get registered and earn'],
        typeSpeed: 130,
        backSpeed: 130,
        loop: true,
      });

</script>

<script>

  function closepage(){
  document.getElementById("firstlog").style.display="none";
  document.getElementById("register").style.display="block";
}

function closepage1(){
  document.getElementById("register").style.display="none";
  document.getElementById("firstlog").style.display="block";
}

</script>

  </body>
  </html>





   

