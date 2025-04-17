<?php
define('APP_STARTED', true);
require_once '../includes/db.php';
require_once '../includes/core.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $father_name = $_POST['father_name'];
    $cnic_number = $_POST['cnic_number'];
    $mobile_number = $_POST['mobile_number'];
    $mobile_number_2 = $_POST['mobile_number_2'];
    $account_number = $_POST['account_number'];
    $occupation = $_POST['occupation'];
    $previous_account_number = $_POST['previous_account_number'];
    $reference = $_POST['reference'];

    $guarantors = [];

    for ($i = 1; $i <= 4; $i++) {
        $guarantors[$i]['name'] = $_POST["guarantor{$i}_name"];
        $guarantors[$i]['cnic'] = $_POST["guarantor{$i}_cnic"];

        $picPath = '';
        if (isset($_FILES["guarantor{$i}_picture"]) && $_FILES["guarantor{$i}_picture"]['error'] === UPLOAD_ERR_OK) {
            $targetDir = "../uploads/";
            if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

            $fileName = uniqid() . '_' . basename($_FILES["guarantor{$i}_picture"]["name"]);
            $targetFile = $targetDir . $fileName;

            if (move_uploaded_file($_FILES["guarantor{$i}_picture"]["tmp_name"], $targetFile)) {
                $picPath = "uploads/" . $fileName;
            }
        }

        $guarantors[$i]['picture'] = $picPath;
    }

    $stmt = $conn->prepare("INSERT INTO user_profiles 
        (name, father_name, cnic_number, mobile_number, mobile_number_2, account_number, occupation, previous_account_number, reference,
        guarantor1_name, guarantor1_cnic, guarantor1_picture,
        guarantor2_name, guarantor2_cnic, guarantor2_picture,
        guarantor3_name, guarantor3_cnic, guarantor3_picture,
        guarantor4_name, guarantor4_cnic, guarantor4_picture)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?,
                ?, ?, ?,
                ?, ?, ?,
                ?, ?, ?,
                ?, ?, ?)");

    $stmt->bind_param(
        "sssssssss" . str_repeat("sss", 4),
        $name, $father_name, $cnic_number, $mobile_number, $mobile_number_2, $account_number, $occupation, $previous_account_number, $reference,
        $guarantors[1]['name'], $guarantors[1]['cnic'], $guarantors[1]['picture'],
        $guarantors[2]['name'], $guarantors[2]['cnic'], $guarantors[2]['picture'],
        $guarantors[3]['name'], $guarantors[3]['cnic'], $guarantors[3]['picture'],
        $guarantors[4]['name'], $guarantors[4]['cnic'], $guarantors[4]['picture']
    );

    if ($stmt->execute()) {
        echo "<p style='color: green;'>Profile added successfully!</p>";
    } else {
        echo "<p style='color: red;'>Error: " . $stmt->error . "</p>";
    }
}
?>

<h2>Add User Profile</h2>
<form method="post" enctype="multipart/form-data">
    <label>Name: <input type="text" name="name" required></label><br>
    <label>Father Name: <input type="text" name="father_name" required></label><br>
    <label>CNIC Number: <input type="text" name="cnic_number" required></label><br>
    <label>Mobile Number: <input type="text" name="mobile_number" required></label><br>
    <label>Additional Mobile Number: <input type="text" name="mobile_number_2"></label><br>
    <label>Account Number: <input type="text" name="account_number"></label><br>
    <label>Occupation: <input type="text" name="occupation"></label><br>
    <label>Previous Account Number: <input type="text" name="previous_account_number"></label><br>
    <label>Reference: <input type="text" name="reference"></label><br><br>

    <h3>Guarantors:</h3>
    <?php for ($i = 1; $i <= 4; $i++): ?>
        <fieldset>
            <legend>Guarantor <?= $i ?></legend>
            <label>Name: <input type="text" name="guarantor<?= $i ?>_name"></label><br>
            <label>CNIC: <input type="text" name="guarantor<?= $i ?>_cnic"></label><br>
            <label>Picture: <input type="file" name="guarantor<?= $i ?>_picture" accept="image/*"></label>
        </fieldset><br>
    <?php endfor; ?>

    <input type="submit" value="Save Profile">
</form>

<hr>

<h2>Saved User Profiles</h2>
<?php
$result = $conn->query("SELECT * FROM user_profiles ORDER BY created_at DESC");

while ($row = $result->fetch_assoc()):
?>
    <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
        <strong>Name:</strong> <?= htmlspecialchars($row['name']) ?><br>
        <strong>Father:</strong> <?= htmlspecialchars($row['father_name']) ?><br>
        <strong>CNIC:</strong> <?= htmlspecialchars($row['cnic_number']) ?><br>
        <strong>Mobile:</strong> <?= htmlspecialchars($row['mobile_number']) ?><br>
        <strong>Additional Mobile:</strong> <?= htmlspecialchars($row['mobile_number_2']) ?><br>
        <strong>Account #:</strong> <?= htmlspecialchars($row['account_number']) ?><br>
        <strong>Occupation:</strong> <?= htmlspecialchars($row['occupation']) ?><br>
        <strong>Previous Account #:</strong> <?= htmlspecialchars($row['previous_account_number']) ?><br>
        <strong>Reference:</strong> <?= htmlspecialchars($row['reference']) ?><br>

        <div style="margin-top:10px;">
            <strong>Guarantors:</strong><br>
            <?php for ($i = 1; $i <= 4; $i++): ?>
                <?php if (!empty($row["guarantor{$i}_name"])): ?>
                    <div style="margin: 5px 0;">
                        <?= $i ?>) <?= htmlspecialchars($row["guarantor{$i}_name"]) ?> (<?= htmlspecialchars($row["guarantor{$i}_cnic"]) ?>)
                        <?php if (!empty($row["guarantor{$i}_picture"])): ?>
                            <br><img src="../<?= htmlspecialchars($row["guarantor{$i}_picture"]) ?>" width="100" alt="Guarantor Image">
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php endfor; ?>
        </div>
    </div>
<?php endwhile; ?>