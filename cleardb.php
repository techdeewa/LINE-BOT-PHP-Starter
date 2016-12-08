<?php

/*
$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);
*/


$server = "us-cdbr-iron-east-04.cleardb.net";
$username = "b9edbb1bdd8a6b";
$password = "379ac343";
$db = "heroku_08be9207ed67154";

$conn = new mysqli($server, $username, $password, $db);
$conn->query("SET NAMES 'utf8'");




/* check connection */
if ($conn->connect_errno) {
    printf("Connect failed: %s\n", $conn->connect_error);
    exit();
}



//$sqlstr = "SELECT `id`,`input`,`userid`,`username`,`timestamp` FROM `heroku_08be9207ed67154`.`unknown_inputs`";

/*
$q=$conn->query($sqlstr);
while($r=$q->fetch_assoc()) {
    print_r($r);
}
*/

//Select queries return a resultset
/*
if ($result = $conn->query($sqlstr)) {
    printf("Select returned %d rows.\n", $result->num_rows);

    //free result set
    $result->close();
}


    $line = "";

    if ($result = $conn->query($sqlstr)) {
        while($obj = $result->fetch_object()){
            $line.=$obj->id;
            $line.=$obj->input;
            $line.=$obj->userid;
            $line.=$obj->username;
            $line.=$obj->timestamp;
            $line.="</br>";
        }
    }


    //$line = iconv('TIS-620','UTF-8//ignore',$line);
    //$line = iconv('UTF-8','TIS-620//ignore',$line);
    echo $line;

    $result->close();
    unset($obj);
    unset($sqlstr);
    unset($query);
*/




    //Prepare an insert statement
    $sqlstr = "INSERT INTO `heroku_08be9207ed67154`.`chatbot` (`userid`,`messageid`,`username`,`messagetext`,`replytext`,`datetimeresponse`)";
    $sqlstr .= "VALUES(?,?,?,?,?,now())";
    $stmt = $conn->prepare($sqlstr);

    $stmt->bind_param("sssss", $val1, $val2, $val3, $val4, $val5);

    $val1 = 'Stuttgart';
    $val2 = 'DEU';
    $val3 = 'Baden-Wuerttemberg';
    $val4 = 'Baden-Wuerttemberg';
    $val5 = 'Baden-Wuerttemberg';

    //Execute the statement
    $stmt->execute();

    printf("Error: %s.\n", $stmt->error);

    printf("%d Row inserted.\n", mysqli_stmt_affected_rows($stmt));

    //close statement
    $stmt->close();

    $sqlstr = "SELECT * FROM `heroku_08be9207ed67154`.`chatbot`";

    $q=$conn->query($sqlstr);
    while($r=$q->fetch_assoc()) {
        print_r($r);
        printf("</br>");
    }







    /* Prepare an insert statement */
    $sqlstr = "INSERT INTO `heroku_08be9207ed67154`.`unknown_inputs` (`input`,`userid`,`username`,`timestamp`) ";
    $sqlstr .= "VALUES (?,?,?, now())";
    $stmt = $conn->prepare($sqlstr);

    $stmt->bind_param("sss", $val1, $val2, $val3);

    //log chat to DB
    $val1 = "text"; // input
    $val2 = "userId"; // userid
    $val3 = "userName"; // username

    /* Execute the statement */
    $stmt->execute();






    ////////////////////////////////////////////////////////////////////
          // logdb unknown


          /* check connection */
          if ($conn->connect_errno) {
              printf("Connect failed: %s\n", $conn->connect_error);
              exit();
          }

              /* Prepare an insert statement */
              $sqlstr = "INSERT INTO `heroku_08be9207ed67154`.`unknown_inputs` (`input`,`userid`,`username`,`timestamp`) ";
              $sqlstr .= "VALUES (?,?,?, now())";
              $stmt = $conn->prepare($sqlstr);


              $stmt->bind_param("sss", $val1, $val2, $val3);

              //log chat to DB
              $val1 = '$text'; // input
              $val2 = '$userId'; // userid
              $val3 = '$userName'; // username

              /* Execute the statement */
              $stmt->execute();

              /* close statement */
            //  $stmt->close();

            //  $conn->close();

            $sqlstr = "SELECT * FROM `heroku_08be9207ed67154`.`unknown_inputs`";

            $q=$conn->query($sqlstr);
            while($r=$q->fetch_assoc()) {
                print_r($r);
                printf("</br>");
            }

            /* close statement */
            $stmt->close();
    $conn->close();
?>
