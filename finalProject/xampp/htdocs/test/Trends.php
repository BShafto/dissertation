<?php
    include 'select.php';
    
    //SQL query for live.prices = SELECT * FROM stockexchange.drink_prices ORDER BY fiveMin_id DESC, D1p DESC LIMIT 1
    $sql = "SELECT * FROM stockexchange.drink_prices "; 
    $sql2 = "SELECT * FROM stockexchange.drink_movements";
    $sql3 = "SELECT * FROM stockexchange.drink_quantities";
    $dPrice = array();
    $dMovement = array();
    $dQuantity = array();
    $count; 
    
    $result = mysqli_query($conn, $sql);
    $result2 = mysqli_query($conn, $sql2);
    $result3 = mysqli_query($conn, $sql3);
    if(mysqli_num_rows($result) > 0 and mysqli_num_rows($result2) > 0 and mysqli_num_rows($result3) > 0){
        while($row = mysqli_fetch_assoc($result) and $row2 = mysqli_fetch_assoc($result2)and $row3 = mysqli_fetch_assoc($result3)){
           $count = $row['fiveMin_id'];
            //echo $count.'</br>';
            for($i=0; $i<=34;$i++){
                $dPrice[$count][$i] = $row['D'.($i+1).'p'];
                $dMovement[$count][$i] = $row2['D'.($i+1).'m'];
                $dQuantity[$count][$i] = $row3['D'.($i+1)];
                //echo $dQuantity[$count][$i].'_';
            }
            //echo '</br>';
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <!--Load the AJAX and jQuery API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <!--script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script-->
    <script type="text/javascript">
        
        google.charts.load('current', {'packages':['corechart']});
        google.charts.load('current', {packages: ['corechart','line']});
        google.charts.setOnLoadCallback(drawChart);
        
        //Array to store the data for each different graph.
        var graphData = [];
        var graphOptions = [];
        var x, trendType;
        var duration = 90;
        var dPrices = <?php echo json_encode($dPrice)?>;
        var dMovements = <?php echo json_encode($dMovement)?>;
        var dQuantities = <?php echo json_encode($dQuantity)?>;
        var displayTypeArray = [dPrices, dMovements, dQuantities];
        var displayType = dPrices;
        var userInput = "0";
        var inSubCat = false;
        var cat = "Beer";
        
        var normOpt = {
                legend: { position: 'right' },
                title: 'myTitle',
                hAxis: {
                    title: '5 Minute Interval'       
                },
                vAxis: {
                    title: 'Price'       
                }
        };
        
        var normOpt2 = {
                legend: { position: 'right' },
                title: 'myTitle',
                hAxis: {
                    title: '5 Minute Interval'       
                },
                vAxis: {
                    title: 'Net Profit (£)'     
                }
        };
        
        var dNames = new Array();
        dNames[0] = ['Interval','Stella','Carling','Carlsberg','Becks','Mahou','Heineken'];
        dNames[1] = ['Interval','Strongbow','Strongbow Dark Fruits','Bulmers','Magners','Old Mout'];
        dNames[2] = ['Interval','Vodka & Coke','Gin & Tonic','Rum & Coke','Spiced Rum & Coke','Gin & Lemonade', 'Malibu & Coke'];
        dNames[3] = ['Interval','Tequila','Jägerbomb','Sambuca','Vodka','Fireball', 'Dark Rum'];
        dNames[4] = ['Interval','Sex on the beach','Mojito','Long Island Iced Tea','Martini','Daiquiri', 'Old Fashioned'];
        dNames[5] = ['Interval','Chardonnay','Rioja','Rosé','Merlot','Sauvignon Blanc', 'Pinot Noir'];

        dNames[6] = ['Interval','Stella','Carling','Carlsberg','Becks','Mahou','Heineken' //7
            ,'Strongbow','Strongbow Dark Fruits','Bulmers','Magners','Old Mout'//5
            ,'Vodka/C','G&T','Rum/C','Spiced Rum/C','G&L', 'Malibu/C' //6
            ,'Tequila','Jägerbomb','Sambuca','Vodka','Fireball', 'Dark Rum' //6
            ,'Sex on the beach','Mojito','Long Island Iced Tea','Martini','Daiquiri', 'Old Fashioned'//6
            ,'Chardonnay','Rioja','Rosé','Merlot','Sauvignon Blanc','Pinot Noir'//6
        ];
        
        function drawChart() {
            //--------------------------- Graph 1 -------------------------------------------
            var dataArray3 = [dNames[userInput]];
            for(i=1; i<duration; i++){
                dataArray3.push([i, 
                    parseFloat((dPrices[i][0])*(dQuantities[i][0])),
                    parseFloat((dPrices[i][1])*(dQuantities[i][1])),
                    parseFloat((dPrices[i][2])*(dQuantities[i][2])),
                    parseFloat((dPrices[i][3])*(dQuantities[i][3])),
                    parseFloat((dPrices[i][4])*(dQuantities[i][4])),
                    parseFloat((dPrices[i][5])*(dQuantities[i][5]))
                ]);
            } 
            normOpt2.title = cat+" net income over "+duration+" five minute intervals.";
            var demo1 = new google.visualization.arrayToDataTable(dataArray3); 
            //--------------------------- Graph 2 -------------------------------------------
            if(userInput===1){
                var dataArray2 = [dNames[userInput]];
                for(i=1; i<duration; i++){
                    dataArray2.push([i, 
                        parseFloat(displayType[i][0]),
                        parseFloat(displayType[i][1]),
                        parseFloat(displayType[i][2]),
                        parseFloat(displayType[i][3]),
                        parseFloat(displayType[i][4])
                    ]);
                } 
                var demo2 = new google.visualization.arrayToDataTable(dataArray2);                      
            }else{
                var dataArray = [dNames[userInput]];
                for(i=1; i<duration; i++){
                    dataArray.push([i, 
                        parseFloat(displayType[i][0]),
                        parseFloat(displayType[i][1]),
                        parseFloat(displayType[i][2]),
                        parseFloat(displayType[i][3]),
                        parseFloat(displayType[i][4]),
                        parseFloat(displayType[i][5])
                    ]); 
                }  
                var demo2 = new google.visualization.arrayToDataTable(dataArray);   
            }

            normOpt.title = cat+" over "+duration+" five minute intervals.";
            //console.log("There "+displayType[1][0]+" to here. User Input: "+userInput);

            var demo2 = new google.visualization.arrayToDataTable(dataArray);            
            //--------------------------- Graph 3 ----------------------------------------
            // Define the chart to be drawn.
            var demo3 = new google.visualization.DataTable();
            demo3.addColumn('string', 'Drink');
            for(i=1; i<=35;i++){
                demo3.addColumn('number', dNames[6][i]);
            }

            for(i=1; i<90; i++){
                demo3.addRows([
                    [i+'', 
                        parseFloat(dPrices[i][0]),
                        parseFloat(dPrices[i][1]),
                        parseFloat(dPrices[i][2]),
                        parseFloat(dPrices[i][3]),
                        parseFloat(dPrices[i][4]),
                        parseFloat(dPrices[i][5]),
                        parseFloat(dPrices[i][6]),
                        parseFloat(dPrices[i][7]),
                        parseFloat(dPrices[i][8]),
                        parseFloat(dPrices[i][9]),
                        parseFloat(dPrices[i][10]),
                        parseFloat(dPrices[i][11]),
                        parseFloat(dPrices[i][12]),
                        parseFloat(dPrices[i][13]),
                        parseFloat(dPrices[i][14]),
                        parseFloat(dPrices[i][15]),
                        parseFloat(dPrices[i][16]),
                        parseFloat(dPrices[i][17]),
                        parseFloat(dPrices[i][18]),
                        parseFloat(dPrices[i][19]),
                        parseFloat(dPrices[i][20]),
                        parseFloat(dPrices[i][21]),
                        parseFloat(dPrices[i][22]),
                        parseFloat(dPrices[i][23]),
                        parseFloat(dPrices[i][24]),
                        parseFloat(dPrices[i][25]),
                        parseFloat(dPrices[i][26]),
                        parseFloat(dPrices[i][27]),
                        parseFloat(dPrices[i][28]),
                        parseFloat(dPrices[i][29]),
                        parseFloat(dPrices[i][30]),
                        parseFloat(dPrices[i][31]),
                        parseFloat(dPrices[i][32]),
                        parseFloat(dPrices[i][33]),
                        parseFloat(dPrices[i][34])                       
                    ]
                ]);
            }            

            // Set chart options
            var allDataOpt = {
                title: "All drinks over a "+duration+" minute period",
                hAxis: {
                    title: '5 Minute Interval'        
                },
                vAxis: {
                    title: 'Price (£)'       
                }
            };
            //--------------------------- End of Graphs ----------------------------------
            //for the first type "general statistics", load all the drinks with their first drink price & movement data. 
            graphData[0] = demo1;    
            graphData[1] = demo2;    
            graphData[2] = demo3;    

            graphOptions[0] = normOpt2;
            graphOptions[1] = normOpt;
            graphOptions[2] = allDataOpt;

            var temp = getInput();
            data = graphData[temp];
            normOptions = graphOptions[temp];

            var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
            chart.draw(data, normOptions);
        }
          
    </script>  
        <title>Trend Analysis</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; Menu</span>
            <div id="myTitle" class="hidden">Trend Analysis</div>   
            <div>
                <div id="userInput">
                    <!--Section where user selects what trend they with to analyse.-->
                    Select the type of trend.</br></br>
                    <input id="9" type="radio" name="trend" value="Net Profit" onclick="hideTag()"/>Net Profit
                    <input id="10" type="radio" name="trend" value="Category Comparison" onclick="hideTag()"/>Category Comparison
                    <input id="11" type="radio" name="trend" value="Overall Comparison" onclick="hideTag()"/>Overall Comparison
                </div>
                <div id="userInputSub"></br>
                    <input id="6" type="radio" name="trend2" value="Price" onclick="typeChange()"/>Price
                    <input id="7" type="radio" name="trend2" value="Movement" onclick="typeChange()"/>Movement
                    <input id="8" type="radio" name="trend2" value="Quantity" onclick="typeChange()"/>Quantity 
                </div></br>
                <div id="userInputCat">Select the category of drink to analyse - 
                    <select id="mySelect" onchange="drinkCatChange(this);" > 
                        <option id="0" value="Beer" SELECTED>Beer</option>
                        <option id="1" value="Cider">Cider</option>
                        <option id="2" value="SpiritMixers">Spirit Mixers</option>
                        <option id="3" value="Spirits">Spirits</option>
                        <option id="4" value="Cocktails">Cocktails</option>
                        <option id="5" value="Wine">Wine</option>
                    </select>
                </div>
                <div id="curve_chart"></div>
            </div>
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
            
            function getInput() {
                var test = trendType;               
                
                //Check all inputs
                var chx = document.getElementsByName('trend');
                var chx2 = document.getElementsByName('trend2');
                for (var i=0; i<chx.length; i++) {
                    if (chx[i].type === 'radio' && chx[i].checked) {
                        console.log("Trend: "+i);
                        trendType = i;
                        
                        return i;
                  } 
                }
                // If nothing is selected, select the 'Category Comparison' option.
                chx[0].checked = true;
                
                //chx2[0].checked = true;
                hideTag();
                return 0;
            }       
            
            function redrawCategory(){
                //console.log("Here "+displayType[1][0]+" to here. User Input_"+userInput+"_");
                var dataArray = [dNames[userInput]];
                var dataArray2 = [dNames[userInput]];
                var chx = document.getElementById('9');
                var a, options; 
                drinkType = userInput;
                
                
                switch(userInput){
                    case "0":
                        a = 0;
                        cat = "Beer";
                        break;
                    case "1":
                        a = 6;
                        cat = "Cider";
                        break;
                    case "2":
                        a = 11;
                        cat = "Spirit / Mixers";
                        break;
                    case "3":
                        a = 17;
                        cat = "Spirits";
                        break;
                    case "4":
                        a = 23;
                        cat = "Cocktails";
                        break;
                    case "5":
                        a = 29;
                        cat = "Wine";
                        break;
                }
                
                //variable np which is 1 as normal or dQuantities[i][a]. Title would also need to change.
                if(chx.checked){
                    normOpt2.title = cat+" net income over "+duration+" five minute intervals.";
                    options = normOpt2;
                    if(a===6){
                        for(i=1; i<90; i++){
                            dataArray2.push([i, 
                                parseFloat((dPrices[i][a])*(dQuantities[i][a])),
                                parseFloat((dPrices[i][a+1])*(dQuantities[i][a+1])),
                                parseFloat((dPrices[i][a+2])*(dQuantities[i][a+2])),
                                parseFloat((dPrices[i][a+3])*(dQuantities[i][a+3])),
                                parseFloat((dPrices[i][a+4])*(dQuantities[i][a+4]))
                            ]);
                        } 
                        var demo2 = new google.visualization.arrayToDataTable(dataArray2);                      
                    }else{
                        for(i=1; i<90; i++){
                            dataArray.push([i, 
                                parseFloat((dPrices[i][a])*(dQuantities[i][a])),
                                parseFloat((dPrices[i][a+1])*(dQuantities[i][a+1])),
                                parseFloat((dPrices[i][a+2])*(dQuantities[i][a+2])),
                                parseFloat((dPrices[i][a+3])*(dQuantities[i][a+3])),
                                parseFloat((dPrices[i][a+4])*(dQuantities[i][a+4])),
                                parseFloat((dPrices[i][a+5])*(dQuantities[i][a+5]))
                            ]);
                        }  
                        var demo2 = new google.visualization.arrayToDataTable(dataArray);   
                    }
                    console.log("HEYYYYY");
                }else{
                    normOpt.title = cat+" over "+duration+" five minute intervals:";
                    options = normOpt;
                    if(a===6){
                        for(i=1; i<90; i++){
                            dataArray2.push([i, 
                                parseFloat(displayType[i][a]),
                                parseFloat(displayType[i][a+1]),
                                parseFloat(displayType[i][a+2]),
                                parseFloat(displayType[i][a+3]),
                                parseFloat(displayType[i][a+4])
                            ]);
                        } 
                        var demo2 = new google.visualization.arrayToDataTable(dataArray2);                      
                    }else{
                        for(i=1; i<90; i++){
                            dataArray.push([i, 
                                parseFloat(displayType[i][a]),
                                parseFloat(displayType[i][a+1]),
                                parseFloat(displayType[i][a+2]),
                                parseFloat(displayType[i][a+3]),
                                parseFloat(displayType[i][a+4]),
                                parseFloat(displayType[i][a+5])
                            ]);
                        }  
                        var demo2 = new google.visualization.arrayToDataTable(dataArray);   
                    }
                }                
                var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
                chart.draw(demo2, options);
            }
            
            function drinkCatChange(el){
                userInput = el.options[el.selectedIndex].id;
                redrawCategory();
            }  
            
            function typeChange(){
                var chx2 = document.getElementsByName('trend2');
                for (var i=0; i<chx2.length; i++) {
                    if (chx2[i].type === 'radio' && chx2[i].checked) {
                        displayType = displayTypeArray[i];
                        console.log("Display Type: "+displayType+ " Array value: "+i);
                        redrawCategory();
                    } 
                }
            }                 
            
            function hideTag(){
                if(document.getElementById('9').checked){
                    document.getElementById('userInputCat').style.display = "block";
                    document.getElementById('userInputSub').style.display = "none";
                    
                }else if(document.getElementById('10').checked){
                    document.getElementById('userInputSub').style.display = "block";
                    document.getElementById('userInputCat').style.display = "block";
                    document.getElementById('6').checked = true;
                    
                }else if(document.getElementById('11').checked){
                    document.getElementById('userInputSub').style.display = "none";
                    document.getElementById('userInputCat').style.display = "none";
                }
                drawChart();
            }
        </script>
    </body>
</html>
