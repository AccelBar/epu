<?php
$db_server = "LOCALHOST";
$db_username = "school";
$db_password = "Aa123456Bb654321";
$db_name = "school";
$conn = new mysqli($db_server, $db_username, $db_password, $db_name);

class Db{
    public function CheckAvailability($date, $time, $customers){
        $sql = "SELECT SUM(customers) AS total_customers FROM rezervace WHERE date = ? AND time = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $date, $time);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $totalCustomers = $row['total_customers'];
        
            $availableSeats = 20 - ($totalCustomers + $customers);
        
            if ($availableSeats >= 0) {
                $check = "1";
                return $check;
            } else {
                $check = "0";
                return $check;
            }
        } else {
            $check = "1";
            return $check;
        }
    }
}
?>