<?php

    $con = mysqli_connect('127.0.0.1', 'root', '', 'WebTech');
    //$sql = "select * from users";
    //$result = mysqli_query($con, $sql);
    //$row = mysqli_fetch_assoc($result);
    //print_r($row);
    //print_r($result);

    // for($i=0; $i<mysqli_num_rows($result); $i++){
    //     $row = mysqli_fetch_assoc($result);
    //     print_r($row);
    //     echo "<br>";
    // }

    // while($row = mysqli_fetch_assoc($result)){
    //     print_r($row);
    //     echo "<br>";
    // }
   
    $incomeSource = $_POST['incomeSource'];
    $incomeAmount = $_POST['incomeAmount'];
    $sql = "INSERT INTO `Income Table` (`incomeID`, `incomeAmount`, `incomeSource`) VALUES (NULL, '{$incomeAmount}', '{$incomeSource}');";
    if(mysqli_query($con, $sql)){
        echo "success!";
    }else{
        echo "DB error";
    }
?>