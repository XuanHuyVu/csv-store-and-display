<?php
try {
    $conn = new PDO("mysql:host=localhost;dbname=account;charset=utf8mb4", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_FILES["csv_file"])) {
            $fileName = $_FILES["csv_file"]["tmp_name"];
            
            if ($_FILES["csv_file"]["size"] > 0) {
                $file = fopen($fileName, "r");
                
                // Bỏ qua dòng đầu (header)
                fgetcsv($file);

                // Chuẩn bị câu lệnh SQL
                $sql = "INSERT INTO accounts (username, password, lastname, firstname, city, email, course1) 
                        VALUES (:username, :password, :lastname, :firstname, :city, :email, :course1)";
                $stmt = $conn->prepare($sql);

                // Đọc dữ liệu từng dòng và lưu vào cơ sở dữ liệu
                while (($row = fgetcsv($file, 1000, ",")) !== FALSE) {
                    $stmt->execute([
                        ':username' => $row[0],
                        ':password' => $row[1],
                        ':lastname' => $row[2],
                        ':firstname' => $row[3],
                        ':city' => $row[4],
                        ':email' => $row[5],
                        ':course1' => $row[6]
                    ]);
                }
                
                fclose($file);
                echo "Tệp CSV đã được import thành công!";
            } else {
                echo "Tệp rỗng!";
            }
        }
    }
} catch (PDOException $e) {
    echo "Kết nối thất bại: " . $e->getMessage();
}
?>
