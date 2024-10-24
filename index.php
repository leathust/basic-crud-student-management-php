<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin sinh viên</title>
    <style>
        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: lightgreen;
        }

        h1, h2 {
            text-align: center;
            margin-bottom: 10px;
        }

        input {
            padding: 10px;
            width: 300px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-top: -15px;
            margin-bottom: 15px;
            display: none;
        }

        button {
            padding: 10px 20px;
            background-color: #008CBA;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 10px;
        }

        button:hover {
            background-color: #005f73;
        }

        .flex-button {
            display: flex;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Vui lòng nhập đầy đủ thông tin tên và MSSV</h1>

        <form method="post" action="">
            <div>
                <h2>Họ Tên</h2>
                <input type="text" id="name" name="name" placeholder="Ví dụ: Nguyễn Văn A">
                <div id="nameError" class="error">Họ tên là bắt buộc</div>
            </div>

            <div>
                <h2>Mã số sinh viên</h2>
                <input type="text" id="mssv" name="mssv" placeholder="Ví dụ: 20001234">
                <div id="mssvError" class="error">Mã số sinh viên là bắt buộc</div>
                <div id="mssvFormatError" class="error">Mã số sinh viên phải là 8 chữ số</div>
            </div>

            <div class=>
                <button type="submit" name="submit">Submit</button>
                <form method="post" action="">
                    <button type="submit" name="list">Danh sách sinh viên</button>
                </form>
            </div>
        </form>

    </div>

    <!-- KẾT NỐI VỚI DATABASE POSTGRES-->
    <?php
    $host = "localhost";
    $port = "5432";
    $dbname = "sinhvien";
    $user = "NHẬP USERNAME VÀO ĐÂY";
    $password = "NHẬP PASSWORD VÀO ĐÂY NHÉ"; 

    $connect_string = "host=$host port=$port dbname=$dbname user=$user password=$password";
    $connect = pg_connect($connect_string);

    if (!$connect) {
        echo "<p style='color:red; text-align:center;'>Kết nối thất bại!</p>";
    }

    if (isset($_POST['submit'])) {
        $name = trim($_POST['name']);
        $mssv = trim($_POST['mssv']);

        if ($name == "") {
            echo "<p style='color:red; text-align:center;'>Họ tên là bắt buộc!</p>";
        } elseif (!preg_match('/^[0-9]{8}$/', $mssv)) {
            echo "<p style='color:red; text-align:center;'>MSSV phải gồm 8 chữ số!</p>";
        } else {
            $query = "INSERT INTO sinhvien (hoten, mssv) VALUES ('$name', '$mssv')";
            $result = pg_query($connect, $query);

            if ($result) {
                echo "<p style='color:green; text-align:center;'>Thêm sinh viên thành công!</p>";
            } else {
                echo "<p style='color:red; text-align:center;'>Có lỗi xảy ra khi thêm sinh viên!</p>";
            }
        }
    }

    if (isset($_POST['list'])) {
        $query = "SELECT * FROM sinhvien";
        $result = pg_query($connect, $query);

        if ($result) {
            echo "<div style='text-align:center;'>";
            echo "<h2>Danh sách sinh viên</h2>";
            echo "<table border='1' style='margin: 0 auto;'>
                    <tr>
                        <th>ID</th>
                        <th>Họ Tên</th>
                        <th>Mã số sinh viên</th>
                    </tr>";

            while ($row = pg_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['hoten']}</td>
                        <td>{$row['mssv']}</td>
                      </tr>";
            }

            echo "</table>";
            echo "</div>";
        } else {
            echo "<p style='color:red; text-align:center;'>Không thể truy vấn danh sách sinh viên!</p>";
        }
    }

    pg_close($connect);
    ?>
</body>
</html>
