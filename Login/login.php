<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <style>
    body {
      background-color: #f2f2f2;
      font-family: Arial, sans-serif;
    }

    h1 {
      text-align: center;
      color: #333;
    }

    form {
      width: 300px;
      margin: 0 auto;
      background-color: #fff;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    label {
      display: block;
      margin-bottom: 5px;
      color: #550808;
    }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    input[type="submit"] {
      width: 100%;
      padding: 8px;
      background-color: #4CAF50;
      border: none;
      color: #fff;
      font-weight: bold;
      cursor: pointer;
      border-radius: 4px;
    }

    input[type="submit"]:hover {
      background-color: #45a049;
    }
  </style>
</head>

<body>
  <h1>Login</h1>

  <form method="post">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required><br><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br><br>

    <input type="submit" value="Login">
  </form>
  <p>Don't have an account? <a href="register.html">Sign up</a> here.</p>
  <?php
    // Kiểm tra nếu có dữ liệu được gửi từ form
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Kết nối tới cơ sở dữ liệu
        $DATABASE_HOST = 'localhost';
        $DATABASE_USER = 'root';
        $DATABASE_PASS = '';
        $DATABASE_NAME = 'code_and_punch';

        $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

        if (mysqli_connect_error()) {
            exit('Cannot connect to database. Contact lead Nguyen Hoang Quan for more details.');
        }

        // Lấy thông tin đăng nhập từ form
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Kiểm tra xem người dùng có tồn tại trong cơ sở dữ liệu không
        $query = 'SELECT id, password FROM users WHERE username = ?';
        if ($statement = $con->prepare($query)) {
            $statement->bind_param('s', $username);
            $statement->execute();
            $statement->store_result();

            if ($statement->num_rows > 0) {
                $statement->bind_result($id, $hashed_password);
                $statement->fetch();

                // Kiểm tra mật khẩu
                if (password_verify($password, $hashed_password)) {
                    echo 'Login successful. Welcome!';
                    
                    header('Location: Homepage/home.php');
                    exit;
                } else {
                    var_dump($hashed_password);
                    var_dump($username);
                    var_dump($password);
                    var_dump(password_hash($password, PASSWORD_DEFAULT));
                    var_dump(password_verify($password, password_hash($password, PASSWORD_DEFAULT)));
                    echo 'Incorrect password.';
                }
            } else {
                echo 'User not found.';

                
            }

            $statement->close();
        } else {
            echo 'Something went wrong. Contact lead Nguyen Hoang Quan for more details.';
        }

        $con->close();
    }
  ?>
</body>

</html>
