<?php

//Get all of the already booked days form the database
$hostname_conp = "localhost";
$database_conp = "ejdev_db";
$username_conp = "ejdev_db";
$password_conp = "autoSquared01_db";




      $servername = "localhost";
      $username = "ejdev_db";
      $password = "autoSquared01_db";
      $dbname = "ejdev_db";

      // Create connection
      $conn = new mysqli($servername, $username, $password, $dbname);
      // Check connection
      if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
      }

      $sql = "SELECT id, quote, invoice FROM qc_job_data LIMIT 374,375" ;

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      //  echo  "quote: " . $row["quote"]. "invoice:" . $row["invoice"]. "<br>";
        echo "<pre>";
        print_r($row);
        echo "</pre>";
    }
    } else {
    echo "0 results";
    }
    echo "<pre>";
    print_r($row);
    echo "</pre>";

      $conn->close();

    ?>



    <div class="contact-page-area">
             <div class="container">
               <div class="row">
                 <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                   <div class="contact-form-area">
                     <h2>Form</h2>
                       <form method="post" name="upload_to_db.php" action="upload_to_db.php">
                         <fieldset>
                           <div class="col-sm-12">
                             <div class="form-group">
                               <label>Price</label>
                               <textarea cols="40" rows="1" name="price" class="form-control" style="margin-left: 50%;
    margin-right: 50%;"></textarea>
                             </div>
                           </div>
                           <div class="col-sm-12">
                             <div class="form-group">
                               <label>Company infomation </label>
                               <textarea cols="40" rows="1" name="company_infomation" class="form-control" style="margin-left: 50%;
    margin-right: 50%;"></textarea>
                             </div>
                           </div>
                           <div class="col-sm-12">
                             <div class="form-group">
                               <label>Product name/infomation</label>
                               <textarea cols="40" rows="1" name="product_name_infomation" class="form-control" style="margin-left: 50%;
    margin-right: 50%;"></textarea>
  </div>
                           </div>
                           <div class="col-sm-12">
                             <div class="form-group">
                               <label>Customer Order No </label>
                               <textarea cols="40" rows="1" name="customer_order_no" class="form-control" style="margin-left: 50%;
    margin-right: 50%;"></textarea>
                             </div>
                           </div>
                           <div class="col-sm-12">
                             <div class="form-group">
                               <label>Invoice total </label>
                               <textarea cols="40" rows="1" name="invoice_total" class="form-control" style="margin-left: 50%;
    margin-right: 50%;"></textarea>
                             </div>
                           </div>

                           <div class="col-sm-12">
                             <div class="form-group">
                               <label>Quote total </label>
                               <textarea cols="40" rows="1" name="quote_total" class="form-control" style="margin-left: 50%;
    margin-right: 50%;"></textarea>
                             </div>
                           </div>
                           <div class="col-sm-12">
                             <div class="form-group">
                               <label>Quantity</label>
                               <textarea cols="40" rows="1" name="quantity" class="form-control" style="margin-left: 50%;
    margin-right: 50%;"></textarea>
                             </div>
                           </div>

                             <div class="form-group">
                               <button class="btn-send submit-buttom " type="submit">do something?</button>
                             </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
