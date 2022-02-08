<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>


<?php 
header("Content-type: text/html; charset=utf-8"); 
if(empty($_GETUnamn1)){
    echo '<h1>Valkommen!</h1>'; 
} 
else{ 
$namn=filter_input(INPUT_GET, 'namn'); 
echo "<h1>Valkommen ${namn}!</hl>"; 
echo "<p>Namnet $namn innehaller ", strlen($namn), " tecken.<p>"; 
} 
?>



</body>
</html>