<php page language="java" contentType="text/html" pageEncoding="UTF-8" ?>
<?php /* 
    Document   : index
    Created on : 15-Mar-2018, 18:30:01
    Author     : bshafto
*/ ?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
<body>
    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="LiveView.php">Live Prices</a>
        <a href="Trends.php"> Trend Analysis</a>
        <a href="Home.php">Home</a>
        <a href="#"style="bottom: 0;">Logout</a>
    </div>
    <div id="main">
        <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; open</span>
        <h2><center>Stock Exchange Bar Homepage</center></h2>
        <p>Navigate to live prices or view trend analysis.</p>         
    </div>
    <script>
        function openNav() {
            document.getElementById("mySidenav").style.width = "250px";
            document.getElementById("main").style.marginLeft = "250px";
        }

        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
            document.getElementById("main").style.marginLeft= "0";
        }
    </script>
</body>
</html>

