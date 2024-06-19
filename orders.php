<!DOCTYPE html>
<html lang="en">
  <?php
  require_once "checkUserAuth.php";
  ?>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Restaurant Billing system</title>
    <link rel="stylesheet" href="style.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
      integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  </head>
  <style>
    #popup {
            display: none;
 position: fixed;
 top: 0;
 left: 0;
 width: 100%;
 height: 100%;
 z-index: 100;
}

.overlay {
 position: fixed;
 top: 0;
 left: 0;
 width: 100vw;
 height: 100vh;
 background: rgba(0, 0, 0, 0.5);
 z-index: 5;
}

.reg-form {
 position: absolute;
 z-index: 10;
 background-color: #eef4fc;
 top: 50%;
 left: 50%;
 transform: translate(-50%, -50%);
 padding: 20px;
 border-radius: 5px;
}
#close{
    cursor: pointer;
}
#updatePopup {
            display: none;
 position: fixed;
 top: 0;
 left: 0;
 width: 100%;
 height: 100%;
 z-index: 100;
}
 
  </style>
  <body>
    <section class="main">
      <div class="headbar">
        <div class="head">
          <h1><i class="fa-solid fa-desktop"></i> RBS</h1>
          <nav>
            <ul>
              <?php if($_SESSION["role"] == "admin"){ ?>
              <li>
                <a href="home.php"><i class="fa-solid fa-house"></i> Home</a>
              </li>
              <li>
                <a href="insert.php"
                  ><i class="fa-solid fa-list"></i> Items Details</a
                >
              </li>
             
              <li>
                <a href="users.php"
                  ><i class="fa-solid fa-users"></i> Users</a
                >
              </li>
              <?php } ?>
              <li>
                <a href="orders.php" class="active"
                  ><i class="fa-solid fa-users"></i> Orders</a
                >
              </li>
              <li>
                <a href="info.php"
                  ><i class="fa-solid fa-barcode"></i> About Us</a
                >
              </li>
              <li>
                <a href="logout.php"
                  ><i class="fa-solid fa-right-from-bracket"></i> Logout</a
                >
              </li>
            </ul>
          </nav>
        </div>
      </div>
      <div class="pro-it">
        <div class="so-in">
          <h1>Orders</h1>
        </div>
       
        <div style="max-width: 1000px;
    width: 100%;
    display: flex;
    margin: 0 auto;">
        <a href="create-order.php" style="width: 100px; padding: 5px; font-size: 20px; background: chocolate; font-weight: bold; color: #fff; border: none;"><i class="fa-solid fa-plus"></i> Add Order</a>
        </div>

        <?php
    if (isset($_SESSION['message'])) {
        echo '<div class="alert alert-info">' . $_SESSION['message'] . '</div>';
        unset($_SESSION['message']);
    }
    ?>
        
        <div class="re-fo">
          <div class="form-list">
            <table>
              <thead>
                <tr>
                  <th>Table No</th>
                  <th>Bill No.</th>
                  <th>Sub Total</th>
                  <th>Discount</th>
                  <th>Vat</th>
                  <th>Tax</th>
                  <th>Grand Total</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
            <?php
            include "connection.php";
            $billQuery = "SELECT * FROM bills";
            $billResult = mysqli_query($con, $billQuery);

            while ($billRow = mysqli_fetch_assoc($billResult)) {
                echo "<tr>
                        <td >".$billRow['table_no']."</td>
                        <td>".$billRow['bill_no']."</td>
                        <td>".$billRow['sub_total']."</td>
                        <td class='bill_name'>".$billRow['discount']."</td>
                        <td>".$billRow['tax']."</td>
                        <td>".$billRow['vat']."</td>
                        <td>".$billRow['grand_total']."</td>
                        <td>".$billRow['status']."</td>
                        <td>
                        <a href='edit-order.php?bill_no=".$billRow['bill_no']."'><button><i class='fas fa-edit'></i></button></a>
                        </td>
                    </tr>";
            }
            ?>
        </tbody>
             
            </table>
          </div>
        </div>
         <div class="modal" id="myModal">
 <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" id="closeModal">&times;</button>
        <h4 class="modal-title" style="font-size:24px;">User Details</h4>
      </div>
      <div class="modal-body" style="font-size:20px; text-align:left;">
        <div class="users_viewing" >

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="closeModal">Close</button>
      </div>
    </div>
 </div>
</div>
<!-- close view model -->


<!-- Include the update popup model -->
<div id="updatePopup" style="display: none;" class="editpopupmodel">
    <div class="overlay"></div>
    <div class="reg-form">
        <header>
            <div id="closeUpdatePopup">✖</div>
        </header>
        <form action="viewcode.php" method="POST">
            <!-- Input fields for update -->

            <div class="emp-fo-co">
                <label for="">Username</label><input type="text" id="updateUsername" name="username" />
            </div>
            <div class="emp-fo-co">
                <label for="">Name</label><input type="text" id="updateName" name="name" />
            </div>
            <div class="emp-fo-co">
                <label for="">Email</label><input type="text" id="updateEmail" name="email" />
            </div>
            <div class="emp-fo-co">
                <label for="">Phone</label><input type="phone" id="updatePhone" name="phone" />
            </div>
            <div class="emp-fo-co">
                <label for="updateGender">Gender:</label>
                <select id="updateGender" name="gender" required>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="emp-fo-co">
                <label for="">Password</label><input type="text" id="updatePassword" name="password" />
            </div>
            <div class="emp-fo-co">
                <label for="">Role</label>
                <select id="updateRole" name="role" required>
                    <option value="Admin">Admin</option>
                    <option value="User">User</option>
                </select>
            </div>
            <div class="emp-fo-co">
                <input type="hidden" id="Id" name="id" />
                <input type="submit" value="Update" name="update_user" style="width:100px" />
                <button type="button" id="cancelUpdate" style="margin-left:10px;border:none; width:100px; border-radius:20px; background-color:orange;font-size:18px; font-weight:bold; color:#fff; ">Cancel</button>
            </div>
        </form>
    </div>
</div>

      </div>
    </section>
    <script>
$(document).ready(function() {
    $('#show').on('click', function() {
        $('#popup').show();
    });

    $('#close, #cancel').on('click', function() {
        $('#popup').hide();
    });

    $('.view_btn').click(function (e) { 
        e.preventDefault();
        
        var user_name = $(this).closest('tr').find('.user_name').text();

        $.ajax({
            type: "POST",
            url: "viewcode.php",
            data: {
                'check_viewbtn': true,
                'user_name': user_name,
            },
            success: function (response) {
                $('.users_viewing').html(response);
                $('#myModal').fadeIn();
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });  
    });
    
    $('.update_btn').click(function (e) { 
        e.preventDefault();
        
        var user_name = $(this).closest('tr').find('.user_name').text();

        $.ajax({
            type: "POST",
            url: "viewcode.php",
            data: {
                'check_updatebtn': true,
                'user_name': user_name,
            },
            dataType: 'json', // Expect JSON response
            success: function (response) {
                $('#updateUsername').val(response.username);
                $('#updateName').val(response.name);
                $('#updateEmail').val(response.email);
                $('#updatePhone').val(response.phone);
                $('#updateGender').val(response.gender);
                $('#updateRole').val(response.role);
                $('#updatePassword').val(response.password); // You may not want to display password in the form
                $('#Id').val(response.id);
                $('#updatePopup').fadeIn();
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        }); 
    });

    // Close the view popup when the close button is clicked
    $('#closeModal, .close').click(function() {
        $('#myModal').fadeOut();
    });

    // Close the update popup when the close button or cancel button is clicked
    $('#closeUpdatePopup, #cancelUpdate').click(function() {
        $('#updatePopup').fadeOut();
    });
});
</script>

  </body>
</html>
