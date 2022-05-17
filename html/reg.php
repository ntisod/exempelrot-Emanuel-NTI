<?php
include("../templates/head.php");
require("../includes/wsp1-functions.php"); //TL testUser 7/4

// define variables and set to empty values
$pwErr = $pwTestErr = $usernameErr = "";
$pw = $pwTest = $username = "";
//Antal fel
$errors = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["username"])) {
    $usernameErr = "Du måste skriva användarnamn";
    $errors++;
  } else {
    $username = test_input($_POST["username"]);
    // check if name only contains letters, numbers and underscores
    if (!preg_match("/^[a-zA-Z-_åäöÅÄÖ0123456789]*$/",$username)) {
      $usernameErr = "Endast bokstäver, siffor och understrykning.";
      $errors++;
    }else{   //TL testUser 7/4
      if(testUserExist($username)){
        $usernameErr = "Användarnamnet existerar redan i databasen. Välj ett nytt.";
        $errors++;  
      }
    }
  }

  if(empty($_POST["pw"])){
    $pwErr = "Du måste ange lösenord!";
    $errors++;
  } else{
    $pw = $_POST["pw"];
    if($pw!=$_POST["pwTest"]){
      $pwErr = "Dina lösenord stämmer inte överens.";
      $errors++;
    }
  }

  echo "Antal fel: $errors" ;
    
  //Kontrollera om det inte finns errors
  if($errors<1){
    //Skicka data till databasen
    require("../includes/settings.php");
    
    try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbuser, $dbpw);
      // set the PDO error mode to exception
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $hashed_pw = password_hash($pw, PASSWORD_DEFAULT);
      $sql = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_pw');";
      // use exec() because no results are returned
      $conn->exec($sql);
      echo "Ny post skapad.";


    } catch(PDOException $e) {
      echo $sql . "<br>" . $e->getMessage();
    }

    $conn = null;
    //Ta oss till en annan sida
    header("Location: welcome.php");   
  }

}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
} 

?>

<h2>Registrera ny användare</h2>
<p><span class="error">* Obligatorisk uppgift</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  
  <p>
    <label for="username"> Användarnamn:</label> 
    <input type="text" name="username" value="<?php echo $username;?>">
    <span class="error">* <?php echo $usernameErr;?></span>
  </p>
  
  <p>
    <label for="pw"> Lösenord:</label> 
    <input type="password" name="pw" value="<?php echo $pw;?>">
    <span class="error">* <?php echo $pwErr;?></span>
  </p>

  <p>
    <label for="pwTest"> Lösenord en gång till:</label> 
    <input type="password" name="pwTest" value="<?php echo $pwTest;?>">
    <span class="error">* <?php echo $pwTestErr;?></span>
  </p>
  <br><br>
  <input type="submit" name="submit" value="Registrera"> 
</form>

<?php
echo "<h2>Din inmatning:</h2>";
echo $username;
echo "<br>";
echo $pw;
echo "<br>";
echo $pwTest;

include "../templates/foot.php";

?>

</body>
</html>

