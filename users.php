<!DOCTYPE html>
<html lang="en">
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
              <li>
                <a href="home.php"><i class="fa-solid fa-house"></i> Home</a>
              </li>
              <li>
                <a href="insert.php"
                  ><i class="fa-solid fa-list"></i> Items Details</a
                >
              </li>
              <li>
                <a href=""
                  ><i class="fa-solid fa-book"></i> Sales Report</a
                >
              </li>
              <li>
                <a href="users.php" class="active"
                  ><i class="fa-solid fa-users"></i> Users</a
                >
              </li>
              <li>
                <a href="info.php"
                  ><i class="fa-solid fa-barcode"></i> About Us</a
                >
              </li>
              <li>
                <a href=""
                  ><i class="fa-solid fa-right-from-bracket"></i> Logout</a
                >
              </li>
            </ul>
          </nav>
        </div>
      </div>
      <div class="pro-it">
        <div class="so-in">
          <h1>Users Registration</h1>
        </div>
       
        <div style="max-width: 1000px;
    width: 100%;
    display: flex;
    margin: 0 auto;">
        <button id="show" style="width: 100px; padding: 5px; font-size: 20px; background: chocolate; font-weight: bold; color: #fff; border: none;" >Add</button>
        </div>
        
        <div class="re-fo">
        
          <div id="popup" style="display: none;">
          <div class="overlay"></div>
          <div class="reg-form">
          <header>
                 <div id="close">✖</div>
               </header>
            <form action="" method="POST">
            <div class="emp-fo-co">
                <label for="">Username</label
                ><input type="text" id="Username" name="username"/>
              </div>
              <div class="emp-fo-co">
                <label for="">Name</label>
                <input type="text" id="name" name="name"/>
              </div>
              <div class="emp-fo-co">
                <label for="">Email</label>
                <input type="text" id="email" name="email"/>
              </div>
              <div class="emp-fo-co">
                <label for="">Phone</label>
                <input type="phone" id="phone" name="phone"/>
              </div>
              
              <div class="emp-fo-co">
                <!-- <label for="">Gender</label><input type="radio" name="gender" />Male
                <input type="radio" name="gender" />Female
                <input type="radio" name="gender" name="" id="" />Other -->
                <label for="gender">Gender:</label>
                  <select id="gender" name="gender" required>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                  </select>
              </div>
              
              <div class="emp-fo-co">
                <label for="">Password</label
                ><input type="text" id="Password" name="password"/>
              </div>
              <!-- <div class="emp-fo-co">
                <label for="">Confirm Password</label
                ><input type="text" id="cpassword" name="confirm_password"/>
              </div> -->
              <div class="emp-fo-co">
                <label for="">Role</label>
                <select id="role" name="role" required>
                  <option value="Admin">Admin</option>
                  <option value="User">User</option>
                </select>
              </div>
              <div class="emp-fo-co">
                <input type="submit" value="submit" name="submit" style="width:100px"/>
                <button type="button" id="cancel" style="margin-left:10px;border:none; width:100px; border-radius:20px; background-color:orange;font-size:18px; font-weight:bold; color:#fff; ">Cancel</button>
                <!-- <label for=""></label><input type="text" /> -->
              </div>
              <?php
                    include 'connection.php';
                    if(isset($_POST['submit'])) {
                      $name = mysqli_real_escape_string($con, $_POST['name']);
                      $email = mysqli_real_escape_string($con, $_POST['email']);
                      $phone = mysqli_real_escape_string($con, $_POST['phone']);
                      $username = mysqli_real_escape_string($con, $_POST['username']);
                      $gender = mysqli_real_escape_string($con, $_POST['gender']);
                      $password = mysqli_real_escape_string($con, $_POST['password']);
                      $confirm_password = mysqli_real_escape_string($con, $_POST['confirm_password']);
                      $role = mysqli_real_escape_string($con, $_POST['role']);
                    
                        // Validation and error checking (you may want to add more thorough validation)
                        if(empty($name) || empty($email) || empty($phone) || empty($username) || empty($gender) || empty($password) || empty($confirm_password) || empty($role)) {
                            echo "All fields are required.";
                        } elseif ($password !== $confirm_password) {
                            echo "Password and Confirm Password do not match.";
                        } else {
                            // Hash the password before storing it in the database
                            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    
                            // Insert the data into the database
                            $query = "INSERT INTO users (name, email, phone, username, gender, password, role) 
                                      VALUES ('$name', '$email', '$phone', '$username', '$gender', '$confirm_password','$role')";
                    
                            $result = mysqli_query($con, $query);
                    
                            if ($result) {
                                // echo "User registered successfully!";
                                // You can also redirect the user to another page after successful registration
                            } else {
                                echo "Error: " . mysqli_error($con);
                            }
                        }
                    }
                    
                ?>
            </form>
                  </div>
          </div>
          <div class="form-list">
            <table>
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Username</th>
                  <th>Gender</th>
                  <th>Role</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
            <?php
            include "connection.php";
            $userQuery = "SELECT * FROM users";
            $userResult = mysqli_query($con, $userQuery);

            while ($userRow = mysqli_fetch_assoc($userResult)) {
                echo "<tr>
                        <td >".$userRow['name']."</td>
                        <td>".$userRow['email']."</td>
                        <td>".$userRow['phone']."</td>
                        <td class='user_name'>".$userRow['username']."</td>
                        <td>".$userRow['gender']."</td>
                        <td>".$userRow['role']."</td>
                        <td>
                        <a href='#' class='view_btn'><button><i class='fas fa-eye'></i></button></a>
                        <a href='#' class='update_btn'><button><i class='fas fa-edit'></i></button></a>
                        <a href=''<button><i class='fa-solid fa-trash'></i></i></button></>
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
