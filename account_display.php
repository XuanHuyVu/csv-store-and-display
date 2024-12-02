<?php
try {
    $conn = new PDO("mysql:host=localhost;dbname=account", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare(query: "SELECT * FROM accounts");
    $stmt->execute();

    // Kiểm tra và hiển thị dữ liệu
    if ($stmt->rowCount() > 0) {
        echo "<table border='1'>
                <tr>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Lastname</th>
                    <th>Firstname</th>
                    <th>City</th>
                    <th>Email</th>
                    <th>Course</th>
                </tr>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                    <td>{$row['username']}</td>
                    <td>{$row['password']}</td>
                    <td>{$row['lastname']}</td>
                    <td>{$row['firstname']}</td>
                    <td>{$row['city']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['course1']}</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "Không có dữ liệu!";
    }
} catch (PDOException $e) {
    echo "Kết nối thất bại: " . $e->getMessage();
}
?>
