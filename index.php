<?php
//include("/db_connect.php");
include("/home/ubuntu/workspace/classes/MySqlArray.php");
include("/home/ubuntu/workspace/pizzaSql.php");
include ("/home/ubuntu/workspace/db_connect.php");
$quality = new MySqlArrayBasic($qualityRatingSql);
$qualityArray = $quality->getArray();
$thickness = new MySqlArrayBasic($crustRatingSql);
$thicknessArray = $thickness->getArray();
$pizzeria = new MySqlArrayBasic($pizzeriaSql);
$pizzeriaArray = $pizzeria->getArray();

if(isset($_POST['pName']) && !empty($_POST['pName']) && isset($_POST['pCity']) && !empty($_POST['pCity'])){
    $addPizzeriaSql = "INSERT INTO PIZZERIA (NAME, CITY) VALUES (\"".$_POST['pName']."\", \"".$_POST['pCity']."\")";
    $addPizzeria = mysqli_query($mysqli, $addPizzeriaSql);
}

if(isset($_POST['pzRateID']) && !empty($_POST['pzRateID']) && isset($_POST['pRateName']) && !empty($_POST['pRateName'])
    && isset($_POST['style']) && !empty($_POST['style']) && isset($_POST['sauce']) && isset($_POST['dough']) && isset($_POST['crust']) 
    && isset($_POST['cheese']) && isset($_POST['authenticity']) && isset($_POST['overall'])){
    
    $addPizzaSql = "INSERT INTO PIZZA (PIZZERIA_ID, NAME, STYLE) VALUES (\"".$_POST['pzRateID']."\", \"".$_POST['pRateName']."\", \"".$_POST['style']."\")";
    $addpizza = mysqli_query($mysqli, $addPizzaSql);
    
    $pizzaIdSql = 
    "SELECT P.ID FROM PIZZA P, PIZZERIA PZ WHERE PZ.ID = P.PIZZERIA_ID AND PZ.ID = ".$_POST['pzRateID']." AND P.NAME = \"".$_POST['pRateName']."\"";
    $getPizzaID = new MySqlArrayBasic($pizzaIdSql);
    $pizzaIDArray = $getPizzaID->getArray();
    $pizzaID = $pizzaIDArray[0]["ID"];
    
    $addRatingsSql = 
        "INSERT INTO PIZZA_QUALITY (PIZZERIA_ID, PIZZA_ID, SAUCE_RATING, DOUGH_RATING, CRUST_THICKNESS, CHEESE_RATING, AUTHENTICITY, OVERALL)
            VALUES (".$_POST['pzRateID'].", ".$pizzaID.", ".$_POST['sauce'].", ".$_POST['dough'].", ".$_POST['crust'].", ".$_POST['cheese'].", ".$_POST['authenticity'].", ".$_POST['overall'].")";
    $addRatings = mysqli_query($mysqli, $addRatingsSql);
}

?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="pizza_style.css">
    </head>
    <body>
        <div class = "centerDiv">
            <p></p><h2 align = "center">Lemme Give you a Pizza my Mind</h2>
            <h4 align = "center">A Pizza Database and Ratings System by Bradley Allen</h4></p>
            <br/>
            <?php
            $pizzaSummary = new MySqlArrayBasic($pizzaSql);
            $pizzaSummary->createTable();
            ?>
            <br/>
            <table>
                <thead>
                    <h3 align = "center">Recommend a new pizzeria to be rated:</h3>
                    <th border = "hidden">Pizzeria Name</th><th>City</th><th></th>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <?php echo "<form name = 'pizzeria' method = \"POST\" ACTION=\"\">"; ?>
                            <input type = 'text' name = 'pName'>
                        </td>
                        <td>
                            <input type = 'text' name = 'pCity'>
                        </td>
                        <td>
                            <input type = 'submit' value = 'Submit'>
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
            <br/>
            <h4 align = "center">Pizzerias Awaiting Pizza Ratings:</h4>
            <?php
            $recSummary = new MySqlArrayBasic($recommendedSql);
            $recSummary->createTable();
            ?>
            <br/>
            <table>
                <thead>
                    <h3 align = "center">Rate a New Pizza</h3>
                    <th>Pizzeria Name</th><th>Pizza Name</th><th>Pizza Style</th><th>Sauce</th><th>Dough</th>
                        <th>Crust Thickness</th><th>Cheese</th><th>Authenticity</th><th>Overall Rating</th><th></th>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <?php echo "<form name = 'pizzeria' method = \"POST\" ACTION=\"\">"; ?>
                            <select name = 'pzRateID'>
                                <?php
                                for($i = 0; $i < $pizzeria->getRows(); $i++){
                                    echo "<option value = ".$pizzeriaArray[$i]["ID"].">".$pizzeriaArray[$i]["NAME"]."</option>\n";
                                }
                                ?>
                            </select>
                        </td>
                        <td>
                            <input type = 'text' name = 'pRateName'>
                        </td>
                        <td>
                            <input type = 'text' name = 'style'>
                        </td>                             
                        <td>
                            <select name = 'sauce'>
                                <?php
                                for($i = 0; $i < $quality->getRows(); $i++){
                                    echo "<option value = ".$qualityArray[$i]["ID"].">".$qualityArray[$i]["NAME"]."</option>\n";
                                }
                                ?>
                            </select>
                        </td>
                        <td>
                            <select name = 'dough'>
                                <?php
                                for($i = 0; $i < $quality->getRows(); $i++){
                                    echo "<option value = ".$qualityArray[$i]["ID"].">".$qualityArray[$i]["NAME"]."</option>\n";
                                }
                                ?>
                            </select>
                        </td>
                        <td>
                            <select name = 'crust'>
                                <?php
                                for($i = 0; $i < $thickness->getRows(); $i++){
                                    echo "<option value = ".$thicknessArray[$i]["ID"].">".$thicknessArray[$i]["NAME"]."</option>\n";
                                }
                                ?>
                            </select>
                        </td>                        
                        <td>
                            <select name = 'cheese'>
                                <?php
                                for($i = 0; $i < $quality->getRows(); $i++){
                                    echo "<option value = ".$qualityArray[$i]["ID"].">".$qualityArray[$i]["NAME"]."</option>\n";
                                }
                                ?>
                            </select>
                        </td>
                        <td>
                            <select name = 'authenticity'>
                                <?php
                                for($i = 0; $i < $quality->getRows(); $i++){
                                    echo "<option value = ".$qualityArray[$i]["ID"].">".$qualityArray[$i]["NAME"]."</option>\n";
                                }
                                ?>
                            </select>
                        </td>
                        <td>
                            <select name = 'overall'>
                                <?php
                                for($i = 0; $i < $quality->getRows(); $i++){
                                    echo "<option value = ".$qualityArray[$i]["ID"].">".$qualityArray[$i]["NAME"]."</option>\n";
                                }
                                ?>
                            </select>
                        </td>                        
                        <td>
                            <input type = 'submit' value = 'Submit'>
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
            <br/><br/><br/><br/><br/>
            <table>
                <tr>
                    <td>
                        <img src = "http://media.giphy.com/media/BYV7OzfoaFjl6/giphy.gif" width="350" height="225">
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>