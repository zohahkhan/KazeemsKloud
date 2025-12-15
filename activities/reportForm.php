<!DOCTYPE html>
<html>
<head>
    <title>Reports</title>
    <link rel="stylesheet" type="text/css" href="main1.css">
</head>
<body>

<h1>Reports</h1>
<!-- dropdown to select report type (weekly or monthly) -->
<form method="get" action="report.php">
    <label>Report Type:</label>
    <select name="type" required>
        <option value="">Select</option>
        <option value="week" <?= $type === 'week' ? 'selected' : '' ?>>Weekly</option>
        <option value="month" <?= $type === 'month' ? 'selected' : '' ?>>Monthly</option>
    </select>

    <!-- user selects the date -->
    <label>Date:</label>
    <input type="date" name="date" value="<?= htmlspecialchars($date ?? '') ?>" required>
   
   <!-- submit  -->
    <button type="submit">Generate Report</button>
</form>

<!-- displays the report  -->
<?php if ($startDate): ?><br>

 <!-- summary -->
<h2><?= ucfirst($type) ?> Summary</h2>
<p>
    <?= date('M d, Y', strtotime($startDate)) ?> – <?= date('M d, Y', strtotime($endDate)) ?>
</p>

<!-- table showing activities per category -->
<table>
    <tr>
        <th>Category</th>
        <th>Total Activities</th>
    </tr>
    <?php foreach ($summary as $row): ?>
        <tr>
            <td><?= htmlspecialchars($row['categoryName']) ?></td>
            <td><?= $row['total'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<h2>Activity Details</h2>
<!-- table showing individual activities  -->
<table>
    <tr>
        <th>Date & Time</th>
        <th>Category</th>
        <th>Description</th>
    </tr>
    <?php foreach ($activities as $activity): ?>
        <tr>
		<!-- the format date and time -->
            <td><?= date('M d, Y g:i A', strtotime($activity['time'])) ?></td>
            <td><?= htmlspecialchars($activity['categoryName']) ?></td>
            <td><?= htmlspecialchars($activity['description']) ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<?php endif; ?>
        <!-- link for homepage activities page -->
		<p><a href="index.php">Back to Activities Homepage</a></p>
</body>
</html>
