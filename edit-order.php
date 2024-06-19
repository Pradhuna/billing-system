<!DOCTYPE html>
<?php
require_once "checkUserAuth.php";

?>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Billing</title>
    <link rel="stylesheet" href="admin.css" />
    <link rel="stylesheet" href="modal.css" />
    <!-- <link rel="stylesheet" href="itemlist.css" /> -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
      integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script
      src="https://code.jquery.com/jquery-3.7.1.min.js"
      integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
      crossorigin="anonymous"
    ></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
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


    <?php
    include "connection.php";
    if (isset($_GET['bill_no'])) {
        $bill_no = $_GET['bill_no'];
        $bill_query = "SELECT * FROM Bills WHERE bill_no = ?";
        $stmt = $con->prepare($bill_query);
        $stmt->bind_param("i", $bill_no);
        $stmt->execute();
        $bill_result = $stmt->get_result();
        $bill_data = $bill_result->fetch_assoc();

        $billProducts_query = "SELECT * FROM BillProducts WHERE bill_no = ?";
        $stmt = $con->prepare($billProducts_query);
        $stmt->bind_param("i", $bill_no);
        $stmt->execute();
        $billProducts_result = $stmt->get_result();
        $billProducts_data = $billProducts_result->fetch_all(MYSQLI_ASSOC);
    }
    
    if (isset($_SESSION['message'])) {
        echo '<p class="success">' . $_SESSION['message'] . '</p>';
        unset($_SESSION['message']);
    }

    ?>
<?php if($bill_data['status'] == 'pending'){ ?>
  <div class="modal-wrapper hidden">
    
    <div class="invoice-container">
      <button class="close" onclick="closeModal()">X</button>
      <div  id="printableArea">
        <div class="invoice-header">
            <h1>INVOICE</h1>
            <!-- <p>123 Main Street, Anytown, USA</p>
            <p>(555) 123-4567</p> -->
            <p>info@restaurant.com</p>
        </div>
        <div class="invoice-details">
                <div class="invoice-date">
                    <p><strong>Date:</strong> 2024-06-17</p>
                    
                </div>
            <div class="invoice-customer">
                <p><strong>Table:</strong><?php echo $bill_data['table_no']; ?> </p>
                <!-- <p><strong>Customer Name:</strong> John Doe</p> -->
            </div>
        </div>
        <table  class="invoice-table">
          <tr style="background-color: #b5b5ae; height: 30px">
            <th>SN</th>
            <th>Particular</th>
            <th>QTY</th>
            <th>Price</th>
            <th>Amount</th>
          </tr>
          <?php
          $sn = 1;
          foreach ($billProducts_data as $billProduct) {
              $product_id = $billProduct['product_id'];
              $check_product_query = "SELECT * FROM products WHERE id = ? LIMIT 1";
              $stmt = $con->prepare($check_product_query);
              $stmt->bind_param("i", $product_id);
              $stmt->execute();
              $result = $stmt->get_result();
              $product_data = $result->fetch_assoc();
              if ($product_data) {
          ?>
          <tr>
            <td><?php echo $sn; ?></td>
            <td><?php echo $product_data['name']; ?></td>
            <td><?php echo $billProduct['qty']; ?></td>
            <td><?php echo $product_data['price']; ?></td>
            <td><?php echo number_format($billProduct['qty'] * $product_data['price']); ?></td>
            <?php if($bill_data['status'] == 'pending'){ ?>
            
            <?php } ?>

          </tr>
          
          <?php
              $sn++;
              }
          }
          ?>
          <tfoot>
                <tr>
                    <td colspan="4" class="right">Subtotal:</td>
                    <td><?php echo $bill_data['sub_total']; ?></td>
                </tr>
                <tr>
                    <td colspan="4" class="right">Discount:</td>
                    <td><?php echo $bill_data['discount']; ?></td>
                </tr>
                <tr>
                    <td colspan="4" class="right">Vat[%]:</td>
                    <td><?php echo $bill_data['vat']; ?></td>
                </tr>
                <tr>
                    <td colspan="4" class="right"><strong>Total:</strong></td>
                    <td><strong><?php echo $bill_data['grand_total']; ?></strong></td>
                </tr>
            </tfoot>
        </table>
        <div class="invoice-footer">
            <p>Thank you for dining with us!</p>
            <p>Please visit again.</p>
        </div>
    </div>
    <div class="print-button">
      <button onclick="printDiv('printableArea')">Print</button>
    </div>
</div>
        </div>
<section>
      <div style="margin: 10px auto; width: 90%; text-align: end">
        <label for="" style="font-weight: bold">Bill No.</label>
        <input type="text" name="bill_no" disabled value="<?php echo $bill_data['bill_no']; ?>" id="" style="width: 40px; padding: 4px" />
      </div>
    </section>
    <form action="bill_management.php?bill_no=<?php echo $bill_no; ?>" class="" method="POST">
      <section>
        <div class="c-details">
          <!-- <h2>Customer Detail</h2> -->
          <div class="form-control">
            <label for="">Table No.:</label>
            <?php if (isset($_GET['bill_no'])) { ?>
                <input type="number" name="table_no" id="cid" value="<?php echo $bill_data['table_no']; ?>" />
            <?php } else { ?>
                <input type="text" name="table_no" id="cid" />
            <?php } ?>
            <input type="hidden" name="action" value="update">
          </div>
      </div>
    </section>
    <section>
      <div class="p-details">
        <h2>Product Details</h2>
          <div class="form-control">
            <label for="">Product ID:</label>
            <input type="text" name="product_id" id="pid" readonly />
          </div>
          <div class="form-control">
            <label for="">Product Name:</label>
            <input type="text" name="pname" id="pname"  placeholder="Enter the Product Name"/>
            <div id="productList"></div>
          </div>
          <div class="form-control">
            <label for="">Price:</label>
            <input type="text" id="price" name="product_price"  readonly/>
          </div>
          <div class="form-control">
            <label for="">Quantity:</label>
            <input type="number" id="qty" name="product_qty"/>
          </div>
         
      </div>
    </section>
    
    <div class="up-dt-ac">
      <!-- <button><i class="fa fa-edit" aria-hidden="true"></i> Update</button> -->
      <!-- <button><i class="fa fa-trash" aria-hidden="true"></i> Delete</button> -->
      <button type="submit" name="add_button">
        <i class="fa fa-shopping-cart" aria-hidden="true"></i> Add
      </button>
    </div>
    </form>
<?php
}
?>
    <section>
      <div class="cart">
        <table>
          <tr style="background-color: #b5b5ae; height: 30px">
            <th>SN</th>
            <th>Particular</th>
            <th>QTY</th>
            <th>Price</th>
            <th>Amount</th>
            <?php if($bill_data['status'] == 'pending'){ ?><th>Action</th><?php } ?>
          </tr>
          <?php
          $sn = 1;
          foreach ($billProducts_data as $billProduct) {
              $product_id = $billProduct['product_id'];
              $check_product_query = "SELECT * FROM products WHERE id = ? LIMIT 1";
              $stmt = $con->prepare($check_product_query);
              $stmt->bind_param("i", $product_id);
              $stmt->execute();
              $result = $stmt->get_result();
              $product_data = $result->fetch_assoc();
              if ($product_data) {
          ?>
          <tr>
            <td><?php echo $sn; ?></td>
            <td><?php echo $product_data['name']; ?></td>
            <td><?php echo $billProduct['qty']; ?></td>
            <td><?php echo $product_data['price']; ?></td>
            <td><?php echo number_format($billProduct['qty'] * $product_data['price']); ?></td>
            <?php if($bill_data['status'] == 'pending'){ ?>
            <td>
            <button type="button" class="btn-sm fa fa-edit " data-toggle="modal" data-target="#editModal" data-id = "<?php echo $product_data['id']; ?>" data-qty="<?php echo $billProduct['qty']; ?>" data-bill_no = "<?php echo $bill_no; ?>">
            </button>
            <button type="button" class="btn-sm btn-danger fa fa-trash " data-toggle="modal" data-target="#deleteModal" data-id = "<?php echo $product_data['id']; ?>"  data-bill_no = "<?php echo $bill_no; ?>">
            </button>
            </td>
            <?php } ?>

          </tr>
          
          <?php
              $sn++;
              }
          }
          ?>
        </table>
      </div>
    </section>

    <section>
      <form action="bills/calculate-order.php?bill_no=<?php echo $bill_no; ?>" method="post">
      <div class="total">
          <div class="control-form">
            <label for="">SubTotal</label>
            <input type="text" id="" name="sub_total" value="<?php echo $bill_data['sub_total']; ?>" disabled/>
          </div>
          <div class="control-form">
            <label for="">Discount[%]</label>
            <input type="text" id="" name="discount" value="<?php echo $bill_data['discount']; ?>"/>
          </div>
          <div class="control-form">
            <label for="">Tax Amount</label>
            <input type="text" id="" name="tax" value="<?php echo $bill_data['tax']; ?>"/>
          </div>
          <div class="control-form">
            <label for="">VAT[%]</label>
            <input type="text" id="" name="vat" value="<?php echo $bill_data['vat']; ?>"/>
          </div>
          <div class="control-form">
            <label for="">Total</label>
            <input type="text" id="" name="grand_total" value="<?php echo $bill_data['grand_total']; ?>" disabled/>
          </div>
      </div>
    </section>    

    <?php if($bill_data['status'] == 'pending'){ ?>
    <div class="print">
      <button type="submit"><i class="fa fa-print" aria-hidden="true"></i>Calculate</button>
      <button type="button" class="btn-sm fa fa-money-bill" data-toggle="modal" data-target="#changeStatusModal">
      Change Status
      </button>
      <button type="button" class="btn-sm fa fa-money-bill"  onClick="openModal()">
      Print
      </button>
    </div>

    <?php } ?>
    </form>

    <!-- Modals -->
    <div class="modal fade" id="changeStatusModal" tabindex="-1" role="dialog" aria-labelledby="changeStatusModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changeStatusModalLabel">Update Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="bills/update-status.php?bill_no=<?php echo $bill_no; ?>" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="product_id" id="edit_product_id">
                        <div class="form-group">
                            <label for="status">Change Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="pending">Pending</option>
                                <option value="paid">Paid</option>
                            </select>
                            <input type="hidden" name="bill_no" id="bill_no">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="bills/edit-product.php" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="product_id" id="edit_product_id">
                        <div class="form-group">
                            <label for="product_qty">Product Quantity</label>
                            <input type="number" class="form-control" id="product_qty" name="product_qty" value="">
                            <input type="hidden" name="bill_no" id="bill_no">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this product?
            </div>
            <div class="modal-footer">
          <form id="deleteForm" action="bills/delete-product.php" method="post">
                    <input type="hidden" name="bill_no" id="delete_bill_no">
                    <input type="hidden" name="product_id" id="delete_product_id">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>

    
    
</div>

    <script>
      function printDiv(divId) {
     var printContents = document.getElementById(divId).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var productId = button.data('id');
            var productQty = button.data('qty');
            var billNo = button.data('bill_no');
            var modal = $(this);
            modal.find('#edit_product_id').val(productId);
            modal.find('#product_qty').val(productQty);
            modal.find('#bill_no').val(billNo);
        });

        $('#deleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var productId = button.data('id');
            var billNo = button.data('bill_no');
            var modal = $(this);
            modal.find('#delete_product_id').val(productId);
            modal.find('#delete_bill_no').val(billNo);
        });
    </script>
    <script>
      function openModal() {
        $(".modal-wrapper").removeClass("hidden")
      }
      function closeModal() {
        $(".modal-wrapper").addClass("hidden")
      }

      
      
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
