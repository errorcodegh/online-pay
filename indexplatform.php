<?php include 'contact.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, scalable=yes">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SemRush - Click and Pay Ads</title>
    <link rel="stylesheet" href="indexstyle1.css">
</head>
<body>
    <header>

        <div id="smallview">
            <i class="fa fa-times" id="cls" onclick="cls()"></i>
            <ul>
        <li><a href="indexplatform.php"><i class="fa fa-home"></i> Home</a></li>
        <li><a href="#about"><i class="fa fa-info-circle"></i> About</a></li>
        <li><a href="#services"><i class="fa fa-cogs"></i> Services</a></li>
        <li><a href="#contact"><i class="fa fa-envelope"></i> Contact</a></li>
        <li><a href="profile.php"><i class="fa fa-user-circle"></i> Profile</a></li>
            </ul>
        </div>

        <div class="logo">
        <h2><img src="images_file/logome.webp"> SemRush<span class="auto-type"></span></h2>
            <i class="fa fa-bars" id="list" onclick="small()"></i>
        </div>

        <nav>
            <ul>
        <li><a href="indexplatform.php"><i class="fa fa-home"></i> Home</a></li>
        <li><a href="#about"><i class="fa fa-info-circle"></i> About</a></li>
        <li><a href="#services"><i class="fa fa-cogs"></i> Services</a></li>
        <li><a href="#contact"><i class="fa fa-envelope"></i> Contact</a></li>
        <li><a href="profile.php"><i class="fa fa-user-circle"></i> Profile</a></li>
            </ul>
        </nav>

    </header>

    <section id="home">
        <div class="container">
            <div class="hero-text">
                <h2>Optimize Product, Earn More</h2>
                <h1><span class="auto-type1"></span></h1>
                <a href="product_purchase.php" class="cta-btn">Get Started</a>
            </div>
        </div>
    </section>

    <section id="about">
        <div class="container">
            <div class="about-content">
                <h2>About SemRush</h2>
                <p>Pay-Per-Click (PPC) service is an online advertising model in which advertisers pay a fee each time their ad is clicked. It’s a way of buying visits to your site, rather than attempting to “earn” those visits organically through search engine optimization (SEO). PPC is commonly used on search engines like Google, social media platforms like Facebook, or other websites that display ads.
                This involves selecting the platform (e.g., ActiveCampaign, Bing Ads, Facebook Ads) and creating the ads themselves. Advertisers decide on targeting options such as keywords, demographics, location, devices, and time of day to ensure the right audience sees their ads.</p>
            </div>
        </div>
    </section>

    <section id="services">
        <div class="services">
            <h2>Earning Stages</h2>

            <div class="service">
                <h3><i class="fa fa-star bronze"></i>  vip 1</h3>
                <h3> 100$ Bronze</h3>
                <p><li>When you reset your account,the corresponding vip level, will be according to your accounn balance</li></p>
                <p><li>The commission rate for each set of product is 0.4%. there are 40 product and you need to perform three task daily</li></p>
            </div>

            <div class="service">
                <h3><i class="fa fa-star gold"></i>  vip 2</h3>
                <h3>1000$ Gold</h3>
                <p><li>When you reset your account,the corresponding vip level, will be according to your accounn balance</li></p>
                <p><li>The commission rate for each set of product is 0.6%. there are 45 product and you need to perform three task daily</li></p>
            </div>

            <div class="service">
                <h3><i class="fa fa-star platinum"></i>  vip 3</h3>
                <h3>2000$ Platinum</h3>
                <p><li>When you reset your account,the corresponding vip level, will be according to your accounn balance</li></p>
                <p><li>The commission rate for each set of product is 0.8%. there are 50 product and you need to perform three task daily</li></p>
            </div>

            <div class="service">
                <h3><i class="fa fa-star diamonds"></i>  vip 4</h3>
                <h3>3000$ Diamonds</h3>
                <p><li>When you reset your account,the corresponding vip level, will be according to your accounn balance</li></p>
                <p><li>The commission rate for each product is 1%. there are 55 product and you need to perform three task daily</li></p>
            </div>
           
        </div>
    </section>

    <div id="count">
    
      <div class="ct">
      <h2>Total</h2>
      <p id="num1">+00</p>
     </div>

     <div class="ct">
      <h2>Cash Out</h2>
      <p id="num2">+00</p>
     </div>

     <div class="ct">
      <h2>Pending</h2>
      <p id="num3">+00</p>
     </div>

    </div><br><br><br>

    <div id="ads">
    <h2>We can help you advertise your product here with just a click</h2>
    <button onclick="ad()">Create Ads</button>
    </div><br><br>

       <section id="partners"><br>
        <h1>Trusted by leading brands</h1><br>
     <div class="partner-slider">
            <div class="slide-container">
    <div class="slide"><img src="images_file/amazon.png" alt="Amazon Pay"></div>
    <div class="slide"><img src="images_file/facebook.png" alt="Amazon Pay"></div>
     <div class="slide"><img src="images_file/google.png" alt="Amazon Pay"></div>
     <div class="slide"><img src="images_file/yahoo.png" alt="Amazon Pay"></div>
     <div class="slide"><img src="images_file/bing.png" alt="Amazon Pay"></div>
            </div>
        </div><br>
    </section>

    <section id="contact">
        <div class="container">
            <h2>Contact Us</h2>
            <form action="contact.php" method="POST">
                <input type="text" placeholder="Your Name" name="uname" required>
                <input type="email" placeholder="Your Email" name="umail" required>
                <textarea placeholder="Your Message" name="msg" required></textarea>
                <button type="submit" name="submit">Send Message</button>
            </form>
        </div>
    </section>

    <footer>
        <div class="container">
            <p>&copy; 2025 ActiveCampaign | All Rights Reserved</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>

<script>
  var typed = new Typed('.auto-type', {
        
        strings: ['Lets help you','with our digital platform', 'That pays daily', 'Get registered and earn'],
        typeSpeed: 60,
        backSpeed: 10,
        loop: true,
      });

   var typed = new Typed('.auto-type1', {
        
        strings: ['Maximize Your Earnings','With Our Higher Click Rate', 'Just With Click And Submit', 'Get Registered And Earn'],
        typeSpeed: 60,
        backSpeed: 10,
        loop: true,
      });

</script>

<script>
 let speed = 20;
 let counter = setInterval(ts,speed);
 let reading = 0;
 
 function ts(){
 let counting = document.getElementById('num1');
 counting.innerHTML = reading++;
 if(reading == 3002){
   clearInterval(counter);
 }
}

 let speed1 = 20;
 let counter1 = setInterval(ts1,speed1);
 let reading1 = 0;

 function ts1(){
 let counting1 = document.getElementById('num2');
 counting1.innerHTML = reading1++;
 
 if(reading1 == 2502){
   clearInterval(counter1);
 }

}


let speed2 = 20;
 let counter2 = setInterval(ts2,speed2);
 let reading2 = 0;

 function ts2(){
 let counting2 = document.getElementById('num3');
 counting2.innerHTML = reading2++;
 if(reading2 == 402){
   clearInterval(counter2);
 }

}
   </script>


<script>
 function small(){
   document.getElementById("smallview").style.display ="block";
 }

  function cls(){
   document.getElementById("smallview").style.display ="none";
 }
</script>

</body>
</html>
