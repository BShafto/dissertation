<?php     
    include 'select.php';
    
    if(isset($_POST['pricesNewCount'])){
        $pricesNewCount = $_POST['pricesNewCount'];
    }else{
        $pricesNewCount = 1;
    }
    
    //SQL query for live.prices = SELECT * FROM stockexchange.drink_prices ORDER BY fiveMin_id DESC, D1p DESC LIMIT 1
    $sql = "SELECT * FROM stockexchange.drink_prices WHERE fiveMin_id = $pricesNewCount"; 
    $sql2 = "SELECT * FROM stockexchange.drink_movements WHERE fiveMin_id = $pricesNewCount";

    $dText = [];
    
    $result = mysqli_query($conn, $sql);
    $result2 = mysqli_query($conn, $sql2);
    if(mysqli_num_rows($result) > 0 and mysqli_num_rows($result2) > 0){
        //mysqli_fetch_assoc fetches a result row as an associative array (arrays that use named keys that I assign them too).
        while($row = mysqli_fetch_assoc($result) 
            and $row2 = mysqli_fetch_assoc($result2)){
                for($i=0; $i<=34;$i++){
                    $dText[$i] = '£'.$row['D'.($i+1).'p'];
                    $dMovements[$i] = $row2['D'.($i+1).'m'];
                    
                    if($dMovements[$i] > 0){
                        $dColour[$i] = "red";
                        $mText[$i] = '+'.$dMovements[$i].'%';
                    }elseif($dMovements[$i] < 0){
                        $dColour[$i] = "green";
                        $mText[$i] = $dMovements[$i].'%';
                    }else{
                        $dColour[$i] = "orange";
                        $mText[$i] = $dMovements[$i].'%';
                    }       
                }
                echo '        
                <div id="beerContainer">
                    <div id="c1">Beer</div>
                        <div id="name">Stella</div>
                            <div id="price">'.$dText[0].'</div>
                                <div id="movement" style="Color:'.$dColour[0].'">'.$mText[0].'</div>
                        <div id="name">Carling</div>
                            <div id="price">'.$dText[1].'</div>
                                <div id="movement" style="Color:'.$dColour[1].'">'.$mText[1].'</div>
                        <div id="name">Carlsberg</div>
                            <div id="price">'.$dText[2].'</div>
                                <div id="movement" style="Color:'.$dColour[2].'">'.$mText[2].'</div>
                        <div id="name">Becks</div>
                            <div id="price">'.$dText[3].'</div>
                                <div id="movement" style="Color:'.$dColour[3].'">'.$mText[3].'</div>
                        <div id="name">Mahou</div>
                            <div id="price">'.$dText[4].'</div>
                                <div id="movement" style="Color:'.$dColour[4].'">'.$mText[4].'</div>
                        <div id="name">Heineken</div>
                            <div id="price">'.$dText[5].'</div>
                                <div id="movement" style="Color:'.$dColour[5].'">'.$mText[5].'</div>
                </div>
                <div id="ciderContainer">
                    <div id="c1">Cider</div>
                        <div id="name">Strongbow</div>
                            <div id="price">'.$dText[6].'</div>
                                <div id="movement" style="Color:'.$dColour[6].'">'.$mText[6].'</div>
                        <div id="name">Strongbow Dark Fruits</div>
                            <div id="price">'.$dText[7].'</div>
                                <div id="movement" style="Color:'.$dColour[7].'">'.$mText[7].'</div>
                        <div id="name">Bulmers</div>
                            <div id="price">'.$dText[8].'</div>
                                <div id="movement" style="Color:'.$dColour[8].'">'.$mText[8].'</div>
                        <div id="name">Magners</div>
                            <div id="price">'.$dText[9].'</div>
                                <div id="movement" style="Color:'.$dColour[9].'">'.$mText[9].'</div>
                        <div id="name">Old Mout</div>
                            <div id="price">'.$dText[10].'</div>
                                <div id="movement" style="Color:'.$dColour[10].'">'.$mText[10].'</div>
                </div>                
                <div id="spiritsContainer">
                    <div id="c1">Spirit-Mixers</div>
                        <div id="name">Vodka Coke</div>
                            <div id="price">'.$dText[11].'</div>
                                <div id="movement" style="Color:'.$dColour[11].'">'.$mText[11].'</div>
                        <div id="name">Gin Tonic</div>
                            <div id="price">'.$dText[12].'</div>
                                <div id="movement" style="Color:'.$dColour[12].'">'.$mText[12].'</div>
                        <div id="name">Rum Coke</div>
                            <div id="price">'.$dText[13].'</div>
                                <div id="movement" style="Color:'.$dColour[13].'">'.$mText[13].'</div>
                        <div id="name">Spiced Rum Coke</div>
                            <div id="price">'.$dText[14].'</div>
                                <div id="movement" style="Color:'.$dColour[14].'">'.$mText[14].'</div>
                        <div id="name">Gin Lemonade</div>
                            <div id="price">'.$dText[15].'</div>
                                <div id="movement" style="Color:'.$dColour[15].'">'.$mText[15].'</div>
                        <div id="name">Malibu Coke</div>
                            <div id="price">'.$dText[16].'</div>
                                <div id="movement" style="Color:'.$dColour[16].'">'.$mText[16].'</div>
                </div>
                <div id="shotsContainer">
                    <div id="c1">Spirits</div>
                        <div id="name">Tequila</div>
                            <div id="price">'.$dText[17].'</div>
                                <div id="movement" style="Color:'.$dColour[17].'">'.$mText[17].'</div>
                        <div id="name">Jägerbomb</div>
                            <div id="price">'.$dText[18].'</div>
                                <div id="movement" style="Color:'.$dColour[18].'">'.$mText[18].'</div>
                        <div id="name">Sambuca</div>
                            <div id="price">'.$dText[19].'</div>
                                <div id="movement" style="Color:'.$dColour[19].'">'.$mText[19].'</div>
                        <div id="name">Vodka</div>
                            <div id="price">'.$dText[20].'</div>
                                <div id="movement" style="Color:'.$dColour[20].'">'.$mText[20].'</div>
                        <div id="name">Fireball</div>
                            <div id="price">'.$dText[21].'</div>
                                <div id="movement" style="Color:'.$dColour[21].'">'.$mText[21].'</div>
                        <div id="name">Dark Rum</div>
                            <div id="price">'.$dText[22].'</div>
                                <div id="movement" style="Color:'.$dColour[22].'">'.$mText[22].'</div>
                </div>
                <div id="cocktailsContainer">
                    <div id="c1">Cocktails</div>
                        <div id="name">Sex on the beach</div>
                            <div id="price">'.$dText[23].'</div>
                                <div id="movement" style="Color:'.$dColour[23].'">'.$mText[23].'</div>
                        <div id="name">Mojito</div>
                            <div id="price">'.$dText[24].'</div>
                                <div id="movement" style="Color:'.$dColour[24].'">'.$mText[24].'</div>
                        <div id="name">Long Island Iced Tea</div>
                            <div id="price">'.$dText[25].'</div>
                                <div id="movement" style="Color:'.$dColour[25].'">'.$mText[25].'</div>
                        <div id="name">Martini</div>
                            <div id="price">'.$dText[26].'</div>
                                <div id="movement" style="Color:'.$dColour[26].'">'.$mText[26].'</div>
                        <div id="name">Daiquiri</div>
                            <div id="price">'.$dText[27].'</div>
                                <div id="movement" style="Color:'.$dColour[27].'">'.$mText[27].'</div>
                        <div id="name">Old Fashioned</div>
                            <div id="price">'.$dText[28].'</div>
                                <div id="movement" style="Color:'.$dColour[28].'">'.$mText[28].'</div>
                </div>
                <div id="wineContainer">
                    <div id="c1">Wine</div>
                        <div id="name">Chardonnay</div>
                            <div id="price">'.$dText[29].'</div>
                                <div id="movement" style="Color:'.$dColour[29].'">'.$mText[29].'</div>
                        <div id="name">Rioja</div>
                            <div id="price">'.$dText[30].'</div>
                                <div id="movement" style="Color:'.$dColour[30].'">'.$mText[30].'</div>
                        <div id="name">Rosé</div>
                            <div id="price">'.$dText[31].'</div>
                                <div id="movement" style="Color:'.$dColour[31].'">'.$mText[31].'</div>
                        <div id="name">Merlot</div>
                            <div id="price">'.$dText[32].'</div>
                                <div id="movement" style="Color:'.$dColour[32].'">'.$mText[32].'</div>
                        <div id="name">Sauvignon Blanc</div>
                            <div id="price">'.$dText[33].'</div>
                                <div id="movement" style="Color:'.$dColour[33].'">'.$mText[33].'</div>
                        <div id="name">Pinot Noir</div>
                            <div id="price">'.$dText[34].'</div>
                                <div id="movement" style="Color:'.$dColour[34].'">'.$mText[34].'</div>
                </div>'; 
            }
    }
    return $dText;
?>