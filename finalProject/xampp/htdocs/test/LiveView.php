<?php
    session_start();
    include 'select.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <style> body{background-color: black}</style>
        <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="style.css">
        <title>Live View</title>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
        <script>
            //Run the jQuery after loading the rest of the document
            $(document).ready(function(){
                var pricesCount = 1;
                setInterval (function(){
                    pricesCount++;
                    $("#prices").load("load-prices.php", {
                        pricesNewCount: pricesCount
                    });
                }, 4500);
            });        
        </script>
    </head>
    <body>    
        <div id="prices">
            <?php
                $myArray = include 'load-prices.php';
            ?>
        </div>
    </body>
</html>
