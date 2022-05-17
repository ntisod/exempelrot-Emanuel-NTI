<?php
/**
 * Olika egna funktioner som vi använder i kursen wsp1
 * 
 *  //TL testUser 7/4
 */
    function testDbField($dbTable, $dbCol, $value){
        //Hämta hemliga värden
        require("../includes/settings.php");
    
        //Testa om det går att ansluta till databasen
        try {
            //Skapa anslutningsobjekt
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbuser, $dbpw);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            //Förbered SQL-kommando
            $sql = "SELECT $dbCol FROM $dbTable WHERE $dbCol = :value  LIMIT 1";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":value", $value);
            //Skicka frågan till databasen
            $stmt->execute();
    
            // Ta emot resultatet från databasen
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    
            $row1 = $stmt->fetch();
            if(empty($row1))
                return false;
            else
                return true;
        }
        catch(PDOException $e) {
            //Om något i anslutningen går fel
            echo "Error: " . $e->getMessage();
        }
        //Stäng anslutningen
        $conn = null;

    }

    function testUserExist($userName){
        return testDbField('users', 'username', $userName);
    }


?>