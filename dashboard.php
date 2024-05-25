<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Billing</title>
    <link rel="stylesheet" href="admin.css" />
    <!-- <link rel="stylesheet" href="itemlist.css" /> -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
      integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <script
      src="https://code.jquery.com/jquery-3.7.1.min.js"
      integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
      crossorigin="anonymous"
    ></script>
    <style>  
           ul{  
                background-color:#fff;  
                cursor:pointer;  
           }  
           li{  
            list-style: none;
                padding:12px;  
           }  
           li:hover{
            background-color: #f1f2f2 ;
           }
           </style>  
  </head>
  <body>
    <header>
      <div class="header">
        <div><h1>Billing</h1></div>
        <div class="d-t"><div id="datetime"></div></div>
        <div style="width: 230px; margin: auto 0px">
          <nav>
            <ul class="top-right">
              <!-- <li class="top-li">
                <button class="view-item">
                  <i class="fa-solid fa-list"></i> View Item
                </button>
              </li> -->
              <li class="top-li">
                <a href=""><i class="fa fa-sign-out-alt"></i> logout</a>
              </li>
            </ul>
          </nav>
        </div>
      </div>
    </header>

    <!-- popup start -->
    <div class="popup hidden">
      <div class="screen">
        <div class="itemhead">
          <h1><i class="fa-sharp fa-solid fa-list-check"></i> Add Items</h1>
          <div class="search">
            <input type="text" /><a href=""
              ><i class="fa-solid fa-magnifying-glass"></i>Search</a
            >
            <button class="close">
              <i class="fa-solid fa-x"></i>
            </button>
          </div>
        </div>
        <div class="itemtable">
          <table>
            <thead>
              <tr>
                <th>Id</th>
                <th>Product Name</th>
                <th>Price</th>
              </tr>
            </thead>
            <?php
                    include "connection.php";
                    $query = "SELECT * FROM products";
                    $result = mysqli_query($con, $query);

                    while($row = mysqli_fetch_assoc($result))
                    {
                        
                        $id = $row['id'];
                        $name = $row['name'];
                        $price = $row['price'];
                        
                        echo "<tr style='height:25px; text-align:center;'>
                        <td>".$id."</td>
                        <td>".$name."</td>
                        <td>".$price."</td>
                        </tr>";
                    }
                        
                    ?>
          </table>
        </div>
      </div>
    </div>
    <!-- popup end -->

    <section>
      <div style="margin: 10px auto; width: 90%; text-align: end">
        <label for="" style="font-weight: bold">Bill No.</label>
        <input type="text" name="" id="" style="width: 40px; padding: 4px" />
      </div>
    </section>
    <section>
      <div class="c-details">
        <!-- <h2>Customer Detail</h2> -->
        <form action="" class="form">
          <div class="form-control">
            <label for="">Table No.:</label>
            <input type="text" id="cid" />
          </div>
          <!-- <div class="form-control">
            <label for="">Name:</label>
            <input type="text" id="cname" />
          </div>
          <div class="form-control">
            <label for="">Email:</label>
            <input type="text" id="cemail" />
          </div>
          <div class="form-control">
            <label for="">Address:</label>
            <input type="text" id="caddress" />
          </div> -->
        </form>
      </div>
    </section>
    <section>
      <div class="p-details">
        <h2>Product Details</h2>
        <form action="" class="form" method="POST">
          <div class="form-control">
            <label for="">Product ID:</label>
            <input type="text" id="pid" />
          </div>
          <div class="form-control">
            <label for="">Product Name:</label>
            <input type="text" name="pname" id="pname"  placeholder="Enter the Product Name"/>
            <div id="productList"></div>
          </div>
          <div class="form-control">
            <label for="">Price:</label>
            <input type="text" id="price" />
          </div>
          <div class="form-control">
            <label for="">Quantity:</label>
            <input type="number" id="qty" />
          </div>
         
        </form>
      </div>
    </section>
    <div class="up-dt-ac">
      <!-- <button><i class="fa fa-edit" aria-hidden="true"></i> Update</button> -->
      <!-- <button><i class="fa fa-trash" aria-hidden="true"></i> Delete</button> -->
      <button type="submit" name="add_button">
        <i class="fa fa-shopping-cart" aria-hidden="true"></i> Add
      </button>
    </div>
    <section>
      <div class="cart">
        <table>
          <tr style="background-color: #b5b5ae; height: 30px">
            <th>SN</th>
            <th>Particular</th>
            <th>QTY</th>
            <th>Price</th>
            <th>Amount</th>
            <th>Action</th>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
        </table>
      </div>
    </section>
    <section>
      <div class="total">
        <form action="" class="grandtotal">
          <div class="control-form">
            <label for="">SubTotal</label>
            <input type="text" id="" />
          </div>
          <div class="control-form">
            <label for="">Discount[%]</label>
            <input type="text" id="" />
          </div>
          <div class="control-form">
            <label for="">Tax Amount</label>
            <input type="text" id="" />
          </div>
          <div class="control-form">
            <label for="">VAT[%]</label>
            <input type="text" id="" />
          </div>
          <div class="control-form">
            <label for="">Total</label>
            <input type="text" id="" />
          </div>
        </form>
      </div>
    </section>
    <div class="print">
      <button><i class="fa fa-print" aria-hidden="true"></i> Bill</button>
    </div>
    <script>
      function updateDateTime() {
        var dateTimeElement = document.getElementById("datetime");
        var currentDate = new Date();

        // Format date
        var day = currentDate.getDate().toString().padStart(2, "0");
        var month = (currentDate.getMonth() + 1).toString().padStart(2, "0"); // Months are 0-based
        var year = currentDate.getFullYear().toString().slice(-2); // Get last two digits of the year

        var formattedDate = day + "-" + month + "-" + year;

        // Format time
        var hours = currentDate.getHours().toString().padStart(2, "0");
        var minutes = currentDate.getMinutes().toString().padStart(2, "0");
        var seconds = currentDate.getSeconds().toString().padStart(2, "0");

        var formattedTime = hours + ":" + minutes + ":" + seconds;

        // Update content
        dateTimeElement.textContent =
          "Date: " + formattedDate + " | Time: " + formattedTime;
      }

      // Initial call to display date and time
      updateDateTime();

      // Update date and time every second
      setInterval(updateDateTime, 1000);

      // pupup model open
      $(document).ready(function () {
        $(".view-item").on("click", function () {
          $(".popup").removeClass("hidden");
        });
        $(".close").on("click", function () {
          $(".popup").addClass("hidden");
        });
        $('#pname').keyup(function(){  
           var query = $(this).val();  
           if(query != '')  
           {  
                $.ajax({  
                     url:"livesearch.php",  
                     method:"POST",  
                     data:{query:query},  
                     success:function(data)  
                     {  
                          $('#productList').fadeIn();  
                          $('#productList').html(data);  
                     }  
                });  
           } else { // Clear ID and Price fields when product name is empty
            $('#pid').val('');
            $('#price').val('');
            // Hide product list when product name is empty
            $('#productList').fadeOut();
        }
      });  
      $(document).on('click', 'li', function(){  
           $('#pname').val($(this).text()); 
           
            // Fetch corresponding ID and Price
            var id = $(this).data('id');
                var price = $(this).data('price');

                // Set the fetched values in the respective fields
                $('#pid').val(id);
                $('#price').val(price);



           $('#productList').fadeOut();  
      });

       
      });
    </script>
  </body>
</html>
