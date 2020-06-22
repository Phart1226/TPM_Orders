<?php
    include 'connection.php';

    //Delete yesterday's orders
    $sql = 'DELETE outgoing_orders, shipping_today FROM outgoing_orders INNER JOIN shipping_today WHERE outgoing_orders.ID=shipping_today.ID';
    $results = mysqli_query($conn, $sql);


    // Insert into today table
    $sql = 'INSERT INTO shipping_today (ID, Job_Number, Company, Quantity, Ship_Date) SELECT ID, Job_Number, Company, Quantity, Ship_Date FROM shipping_tomorrow';
    $results = mysqli_query($conn, $sql);


    //Delete tomorrow table
    $sql = 'DELETE FROM shipping_tomorrow';
    $results = mysqli_query($conn, $sql);

    // Insert into tomorrow table
    $sql = 'INSERT INTO shipping_tomorrow (ID, Job_Number, Company, Quantity, Ship_Date) SELECT ID, Job_Number, Company, Quantity, Ship_Date FROM outgoing_orders WHERE DATEDIFF(Ship_Date, DATE_ADD(CURDATE(), INTERVAL 1 DAY)) = 0';
    $results = mysqli_query($conn, $sql);

    $conn -> close();

    
?>