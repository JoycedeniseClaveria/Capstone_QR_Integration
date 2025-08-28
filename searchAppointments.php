<?php
include 'connection.php';

$search = isset($_GET['search']) ? trim($_GET['search']) : "";

$sql = "SELECT s.id, s.title, s.description, s.start_datetime, s.end_datetime, s.status,
               u.firstName, u.lastName
        FROM schedule_list s
        JOIN users u ON s.userId = u.userId
        WHERE u.firstName LIKE ? OR u.lastName LIKE ?
        ORDER BY s.start_datetime DESC";

$stmt = $conn->prepare($sql);
$searchParam = "%$search%";
$stmt->bind_param("ss", $searchParam, $searchParam);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        echo '<tr>
            <td data-label="Name">'.htmlspecialchars($row['firstName'].' '.$row['lastName']).'</td>
            <td data-label="Title">'.htmlspecialchars($row['title']).'</td>
            <td data-label="Description">'.htmlspecialchars($row['description']).'</td>
            <td data-label="Schedule">'
                .date("M d, Y h:i A", strtotime($row['start_datetime'])).'<br>to<br>'
                .date("M d, Y h:i A", strtotime($row['end_datetime'])).'
            </td>
            <td data-label="Status">
                <span class="badge '.($row['status']=="Pending"?"bg-warning text-dark":($row['status']=="Approved"?"bg-success":"bg-danger")).'">'
                .$row['status'].
                '</span>
            </td>
            <td data-label="Action">
                <button type="button" class="btn btn-primary btn-sm" 
                        data-bs-toggle="modal" 
                        data-bs-target="#updateModal" 
                        data-id="'.$row['id'].'">
                    <i class="fas fa-edit"></i> Update
                </button>
                <button type="submit" class="btn btn-danger btn-sm">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </td>
        </tr>';
    }
} else {
    echo '<tr><td colspan="6" class="text-center text-muted">No appointments found.</td></tr>';
}

$stmt->close();
$conn->close();
?>
