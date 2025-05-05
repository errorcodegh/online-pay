<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TASK Events & Earnings</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
        }

        body {
            background: #1e1e2f;
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: start;
            height: 100vh;
            overflow-y: auto;
            padding: 20px;
            position: relative;
          
        }

        .close-btn {
            position: absolute;
            top: 15px;
            right: 20px;
            background: none;
            border: none;
            color: #fff;
            font-size: 24px;
            cursor: pointer;
            transition: 0.3s;
        }

        .close-btn:hover {
            color: #e74c3c;
        }

        .container {
            background: #2a2a3c;
            border-radius: 10px;
            padding: 25px;
            width: 90%;
            max-width: 800px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.3);
            text-align: center;
            margin-bottom: 15px;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeIn 0.8s ease-out forwards;
            line-height: 2em;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h2 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #f39c12;
        }

        h3 {
            font-size: 18px;
            color: #bbb;
        }

        .earn-container {
            background: #33334a;
            border-radius: 8px;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 10px 0;
            transition: 0.3s;
            cursor: pointer;
            opacity: 0;
            transform: scale(0.9);
            animation: popIn 0.6s ease-out forwards;
        }

        @keyframes popIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .earn-container:hover {
            background: #44445a;
            transform: scale(1.05);
        }

        .earn-container h3, .earn-container h4 {
            font-size: 18px;
        }

        .earn-container h4 {
            color: #27ae60;
            font-weight: bold;
        }

        .salary-section {
            padding: 20px;
            background: #3a3a55;
            border-radius: 8px;
            text-align: left;
        }

        .salary-section p {
            font-size: 16px;
            margin: 10px 0;
        }

        @media (max-width: 768px) {
            .earn-container {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
    <script>
        function closePage() {
            window.location.href='profile';
        }
    </script>
</head>
<body>
    <button class="close-btn" onclick="closePage()">X</button>

    <div class="container">
        <h2>ActiveCampaign Marketing</h2>
        <h3>Register new customer activity, valid within 7 days.</h3>

        <h2>First Deposit Rewards</h2>
        
        <div class="earn-container">
            <h3>Amount: <span>300 USDT</span></h3>
            <h4>Get Extra: 20 USDT</h4>
        </div>
        <div class="earn-container">
            <h3>Amount: <span>500 USDT</span></h3>
            <h4>Get Extra: 50 USDT</h4>
        </div>
        <div class="earn-container">
            <h3>Amount: <span>1000 USDT</span></h3>
            <h4>Get Extra: 120 USDT</h4>
        </div>
        <div class="earn-container">
            <h3>Amount: <span>3000 USDT</span></h3>
            <h4>Get Extra: 400 USDT</h4>
        </div>
        <div class="earn-container">
            <h3>Amount: <span>5000 USDT</span></h3>
            <h4>Get Extra: 700 USDT</h4>
        </div>
        <div class="earn-container">
            <h3>Amount: <span>10000 USDT</span></h3>
            <h4>Get Extra: 1500 USDT</h4>
        </div>
    </div>

    <div class="container salary-section">
        <h2>Basic Salary Requirement</h2>
        <p>VIP1 - complete 3 series of orders and receive 50 USDT</p>
        <p>VIP2 - complete 4 series of orders and receive 100 USDT</p>
        <p>VIP3 - complete 5 series of orders and receive 200 USDT</p>
        <p>VIP4 - complete 6 series of orders and receive 300 USDT</p>
    </div>


</body>
</html>
