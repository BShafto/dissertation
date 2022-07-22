<html>
   <head>
      <title>Google Charts Tutorial</title>
      <script type = "text/javascript" src = "https://www.gstatic.com/charts/loader.js"></script>
      <script type = "text/javascript">
         google.charts.load('current', {packages: ['corechart','line']});  
      </script>
   </head>
   
   <body>
      <div id = "container" style = "width: 550px; height: 400px; margin: 0 auto">
      </div>
      <script language = "JavaScript">
         function drawChart() {
            // Define the chart to be drawn.
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Month');
            data.addColumn('number', 'Tokyo');
            data.addColumn('number', 'New York');
            data.addColumn('number', 'Berlin');
            data.addColumn('number', 'London');
            data.addRows([
               ['Jan',  7.0, -0.2, -0.9, 3.9],
               ['Feb',  6.9, 0.8, 0.6, 4.2],
               ['Mar',  9.5,  5.7, 3.5, 5.7],
               ['Apr',  14.5, 11.3, 8.4, 8.5],
               ['May',  18.2, 17.0, 13.5, 11.9],
               ['Jun',  21.5, 22.0, 17.0, 15.2],
               
               ['Jul',  25.2, 24.8, 18.6, 17.0],
               ['Aug',  26.5, 24.1, 17.9, 16.6],
               ['Sep',  23.3, 20.1, 14.3, 14.2],
               ['Oct',  18.3, 14.1, 9.0, 10.3],
               ['Nov',  13.9,  8.6, 3.9, 6.6],
               ['Dec',  9.6,  2.5,  1.0, 4.8]
            ]);
            
            // Set chart options
            var options = {
               chart: {
                  title: 'Average Temperatures of Cities',
                  subtitle: 'Source: worldclimate.com'
               },   
               hAxis: {
                  title: 'Month',         
               },
               vAxis: {
                  title: 'Temperature',        
               }, 
               'width':550,
               'height':400      
            };

            // Instantiate and draw the chart.
            var chart = new google.charts.Line(document.getElementById('container'));
            chart.draw(data, options);
         }
         google.charts.setOnLoadCallback(drawChart);
      </script>
   </body>
</html>


                            parseFloat(allDataArray[i][0]),
                            parseFloat(allDataArray[i][1]),
                            parseFloat(allDataArray[i][2]),
                            parseFloat(allDataArray[i][3]),
                            parseFloat(allDataArray[i][4]),
                            parseFloat(allDataArray[i][5]),
                            parseFloat(allDataArray[i][6]),
                            parseFloat(allDataArray[i][7]),
                            parseFloat(allDataArray[i][8]),
                            parseFloat(allDataArray[i][9]),
                            parseFloat(allDataArray[i][10]),
                            parseFloat(allDataArray[i][11]),
                            parseFloat(allDataArray[i][12]),
                            parseFloat(allDataArray[i][13]),
                            parseFloat(allDataArray[i][14]),
                            parseFloat(allDataArray[i][15]),
                            parseFloat(allDataArray[i][16]),
                            parseFloat(allDataArray[i][17]),
                            parseFloat(allDataArray[i][18]),
                            parseFloat(allDataArray[i][19]),
                            parseFloat(allDataArray[i][20]),
                            parseFloat(allDataArray[i][21]),
                            parseFloat(allDataArray[i][22]),
                            parseFloat(allDataArray[i][23]),
                            parseFloat(allDataArray[i][24]),
                            parseFloat(allDataArray[i][25]),
                            parseFloat(allDataArray[i][26]),
                            parseFloat(allDataArray[i][27]),
                            parseFloat(allDataArray[i][28]),
                            parseFloat(allDataArray[i][29]),
                            parseFloat(allDataArray[i][30]),
                            parseFloat(allDataArray[i][31]),
                            parseFloat(allDataArray[i][32]),
                            parseFloat(allDataArray[i][33]),
                            parseFloat(allDataArray[i][34])                