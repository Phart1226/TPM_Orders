<?php
    include 'connection.php';
?>

<?php
    if(isset($_POST['submit'])){

        
        $jobNum = mysqli_real_escape_string($conn, $_POST['jobNum']);
        $cName = mysqli_real_escape_string($conn, $_POST['cName']);
        $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
        $shipDate = mysqli_real_escape_string($conn, $_POST['shipDate']);

        //create sql
        $sql = "INSERT INTO outgoing_orders(Job_Number, Company, Quantity, Ship_Date) VALUES('$jobNum', '$cName', '$quantity', '$shipDate')";

        //save to db
        if($conn -> query($sql)){
            $last_ID = mysqli_insert_id($conn);
            header('Location: index.php');

        }else{
            echo 'query error: ' . mysqli_error($conn);
        }



        if($shipDate == date('Y-m-d')){

            $sql = "INSERT INTO shipping_today(ID, Job_Number, Company, Quantity, Ship_Date) VALUES('$last_ID', '$jobNum', '$cName', '$quantity', '$shipDate')";
            mysqli_query($conn, $sql);
            header('Location: index.php');

        }
        
        if($shipDate == date("Y-m-d", strtotime("tomorrow"))){

            $sql = "INSERT INTO shipping_tomorrow(ID, Job_Number, Company, Quantity, Ship_Date) VALUES('$last_ID', '$jobNum', '$cName', '$quantity', '$shipDate')";
            mysqli_query($conn, $sql);
            header('Location: index.php');

        }


    }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="description" content="Table display for out going TPM orders for the next two weeks">
        <meta name="viewport" content="width=device-width, initial-scale = 1.0">
        
        
        <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <script src = "https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
        <script src = "https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
        <link rel = "stylesheet" href = "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
        <link rel = "stylesheet" href = "TPMOrderInterface.css">
        <link rel = "stylesheet" href = "https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
        <link href = "https://fonts.googleapis.com/css?family=Merriweather|Playfair+Display|Raleway:400,700|Vollkorn:700&display=swap" rel="stylesheet">

        <title>Add an Order</title>
    </head>
    <body class= "grey lighten-4">
      <nav class="white z-depth-0">
          <div class="container">
              <a href="index.php" class="brand-logo brand-text"><b>TPM Orders</b></a>
              <ul id="nav-mobile" class="right">
                  <li><a href="todTomOrders.php" class="btn brand z-depth-0">Today & Tomorrow Orders</a></li>
              </ul>
          </div>
      </nav>
        
        <section class="container grey-text">
            <div class= "title">
                <h2 id="AOrderTitle">Put in an Order</h2>
            </div>
            <form class="white" action="addOrder.php" method="POST">
                <label>Job Number:</label>
                <input type="text" name="jobNum">
                <label>Company:</label>
                <input type="text" name="cName">
                <label>Quantity:</label>
                <input type="text" name="quantity">
                <label>Ship Date:</label>
                <input type="date" name="shipDate">
                <div class="center">
                    <input type="submit" name="submit" value="submit" class="btn brand z-depth-0">
                </div>
            </form>
        </section>

    </body>
</html>