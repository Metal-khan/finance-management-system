<?php
define('APP_STARTED', true);
require_once '../includes/db.php';
require_once '../includes/core.php';

// Handle loan form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entry_date = $_POST['entry_date'];
    $month = $_POST['month'];
    $khata_number = $_POST['khata_number'];
    $description = $_POST['description'];
    $debit = $_POST['debit'] ?? 0;
    $credit = $_POST['credit'] ?? 0;
    $balance = $_POST['balance'] ?? 0;

    $stmt = $conn->prepare("INSERT INTO loan (entry_date, month, khata_number, description, debit, credit, balance)
                            VALUES (?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("ssssddd", $entry_date, $month, $khata_number, $description, $debit, $credit, $balance);

    if ($stmt->execute()) {
        echo "<p style='color: green;'>Loan record added successfully!</p>";
    } else {
        echo "<p style='color: red;'>Error: " . $stmt->error . "</p>";
    }
}
?>

<h2>Add Loan Record</h2>
<form method="post">
    <label>Date: <input type="date" name="entry_date" required></label><br>
    <label>Month: <input type="text" name="month" required></label><br>
    <label>Khata Number: <input type="text" name="khata_number" required></label><br>
    <label>Description: <textarea name="description"></textarea></label><br>
    <label>Debit: <input type="number" name="debit" step="0.01" value="0"></label><br>
    <label>Credit: <input type="number" name="credit" step="0.01" value="0"></label><br>
    <label>Balance: <input type="number" name="balance" step="0.01" value="0"></label><br>

    <input type="submit" value="Save Loan Entry">
</form>

<hr>

<h2>Loan Entries</h2>
<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>#</th>
            <th>Date</th>
            <th>Month</th>
            <th>Khata Number</th>
            <th>Description</th>
            <th>Debit</th>
            <th>Credit</th>
            <th>Balance</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $result = $conn->query("SELECT * FROM loan ORDER BY entry_date DESC, id DESC");
    $sr = 1;
    while ($row = $result->fetch_assoc()):
    ?>
        <tr>
            <td><?= $sr++ ?></td>
            <td><?= htmlspecialchars($row['entry_date']) ?></td>
            <td><?= htmlspecialchars($row['month']) ?></td>
            <td><?= htmlspecialchars($row['khata_number']) ?></td>
            <td><?= htmlspecialchars($row['description']) ?></td>
            <td><?= htmlspecialchars($row['debit']) ?></td>
            <td><?= htmlspecialchars($row['credit']) ?></td>
            <td><?= htmlspecialchars($row['balance']) ?></td>
            <td><?= htmlspecialchars($row['created_at']) ?></td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>
