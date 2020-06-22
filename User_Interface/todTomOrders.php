<?php

    include 'connection.php';

    

?>

<?php

    //write query for all orders
    $sqlTOD = 'SELECT * FROM shipping_today ORDER BY Ship_Date';
    $sqlTOM = 'SELECT * FROM shipping_tomorrow ORDER BY Ship_Date';

    //make query & get result
    if ($resultTOD = $conn -> query($sqlTOD)) {
        //echo "Select returned:" . $resultTOD->num_rows;
        
    }

    if ($resultTOM = $conn -> query($sqlTOM)) {
        //echo "Select returned:" . $resultTOM->num_rows;
        
    }
    
    $ordersTOD = array();
    $ordersTOM = array();


    //fetch resulting rows as an array
    while($orderTOD = mysqli_fetch_array($resultTOD)){
        $ordersTOD[] = $orderTOD;
    }

    while($orderTOM = mysqli_fetch_array($resultTOM)){
        $ordersTOM[] = $orderTOM;
    }

    $resultTOD -> free_result();
    $resultTOM -> free_result();

    $conn -> close();
        
    header("Refresh:3600;");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="description" content="Table display for out going TPM orders for the next two weeks">
        <meta name="viewport" content="width=device-width, initial-scale = 1.0">
        <meta http-equiv="refresh" content="300">
        
        
        <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <script src = "https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
        <script src = "https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
        <link rel = "stylesheet" href = "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
        <link rel = "stylesheet" href = "TPMOrderInterface.css">
        <link rel = "stylesheet" href = "https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
        <link href = "https://fonts.googleapis.com/css?family=Merriweather|Playfair+Display|Raleway:400,700|Vollkorn:700&display=swap" rel="stylesheet">

        <title>Outgoing Orders</title>
    </head>
  <body>
    <div class="tableContainer">
        <div class ="title">
                <h2 id="todayTitle"><b>Shipping Today</b></h2>
        </div>
        <div class="outTodayTable">
            <table id= "outgoingOrdersToday" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <td>Job Number</td>
                        <td>Company Name</td>
                        <td>Quantity</td>
                        <td>Shipping Date</td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($ordersTOD as $order): ?>
                        <tr id="todayFont">
                        <td><b><?php echo htmlspecialchars($order['Job_Number']); ?></b></td>
                        <td><b><?php echo htmlspecialchars($order['Company']); ?></b></td>
                        <td><b><?php echo htmlspecialchars($order['Quantity']); ?></b></td>
                        <td><b><?php echo htmlspecialchars($order['Ship_Date']); ?></b></td>
                        </tr> 
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class ="title">
                <h2 id="tomorrowTitle"><b>Shipping Tomorrow</b></h2>
        </div>
        <div class="outTomTable">
            <table id= "outgoingOrdersTom" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <td>Job Number</td>
                        <td>Company Name</td>
                        <td>Quantity</td>
                        <td>Shipping Date</td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($ordersTOM as $order): ?>
                        <tr>
                        <td><?php echo htmlspecialchars($order['Job_Number']); ?></td>
                        <td><?php echo htmlspecialchars($order['Company']); ?></td>
                        <td><?php echo htmlspecialchars($order['Quantity']); ?></td>
                        <td><?php echo htmlspecialchars($order['Ship_Date']); ?></td>
                        </tr> 
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="container" id="bottomNav">
        <a href="index.php" class="brand-logo brand-text"><b>TPM Orders</b></a>
        <ul id="nav-mobile" class="right">
            <li><a href="addOrder.php" class="btn brand z-depth-0">Add an Order</a></li>
        </ul>
    </div>
    
  </body>
</html>