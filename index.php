<?php
    
    include 'connection.php';

?>


<?php
    
    //write query for all orders
     $sqlOUT = 'SELECT * FROM outgoing_orders ORDER BY Ship_Date';

    //make query & get result
    if ($resultOUT = $conn -> query($sqlOUT)) {
	
	}
	

    $ordersOUT = array();
    //fetch resulting rows as an array
    while($order = mysqli_fetch_array($resultOUT)){
        $ordersOUT[] = $order;
    }
   

    if(isset($_POST['delete'])){
        $order_to_delete = mysqli_real_escape_string($conn, $_POST['ID_Delete']);

        $sqlOUTDEL = "DELETE FROM outgoing_orders WHERE ID = $order_to_delete";

        $sqlCheckTOD = "SELECT ID FROM shipping_today WHERE ID = $order_to_delete";
        $resultTOD = mysqli_query($conn, $sqlCheckTOD);

        $sqlCheckTOM= "SELECT ID FROM shipping_tomorrow WHERE ID = $order_to_delete";
        $resultTOM = mysqli_query($conn, $sqlCheckTOM);

        
        
        if(mysqli_query($conn, $sqlOUTDEL)){
            if(mysqli_num_rows($resultTOD)>0){
                $sqlTODDEL = "DELETE FROM shipping_today WHERE ID = $order_to_delete";
                mysqli_query($conn, $sqlTODDEL);
                header('Location: todTomOrders.php');
            }elseif(mysqli_num_rows($resultTOM)>0){
                $sqlTOMDEL = "DELETE FROM shipping_tomorrow WHERE ID = $order_to_delete";
                mysqli_query($conn, $sqlTOMDEL);
                header('Location: todTomOrders.php');
            }else{
                header('Location: index.php');
            }
            
        }else{
            echo 'query error: ' . mysqli_error($conn);
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
        <meta http-equiv="refresh" content="3600">
        
        
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
  <body >
    <nav class= "grey lighten-3 z-depth-0">
        <div class="container">
            <a href="todTomOrders.php" class="brand-logo brand-text"><b>TPM Orders</b></a>
            <ul id="nav-mobile" class="right">
                <li><a href="addOrder.php" class="btn brand z-depth-0">Add an Order</a></li>
            </ul>
        </div>
    </nav>
    <div class="tableContainer">
        <div class ="title">
                <h2 id="OOTitle"><b>Outgoing Orders</b></h2>
        </div>
        <div class="outTable">
            <table id= "outgoingOrders" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <td>Job Number</td>
                        <td>Company Name</td>
                        <td>Quantity</td>
                        <td>Shipping Date</td>
                        <td>Remove Order</td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($ordersOUT as $order): ?>
                            <tr>
                            <td><?php echo htmlspecialchars($order['Job_Number']); ?></td>
                            <td><?php echo htmlspecialchars($order['Company']); ?></td>
                            <td><?php echo htmlspecialchars($order['Quantity']); ?></td>
                            <td><?php echo htmlspecialchars($order['Ship_Date']); ?></td>
                            <td>
                                <form action="index.php" method="POST">
                                    <input type="hidden" name="ID_Delete" value="<?php echo $order['ID'] ?>">
                                    <input type="submit" name="delete" value="Delete" class="btn brand z-depth-0">
                                </form>
                            </td>
                            </tr> 
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    
  </body>
</html>