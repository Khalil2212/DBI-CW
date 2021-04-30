<?php
include 'functions.php';
// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 20;
// Prepare the SQL statement and get records from our contacts table, LIMIT will determine the page
$stmt = $pdo->prepare('SELECT * FROM staff ORDER BY staff_id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$Staffs = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Get the total number of contacts, this is so we can determine whether there should be a next and previous button
$num_Staffs = $pdo->query('SELECT COUNT(*) FROM staff')->fetchColumn();
?>
<?=template_header('Read')?>

<div class="content read">
	<h2>Read Staff File</h2>
	<a href="create_staff.php" class="create-button">Create staff</a>
	<table>
        <thead>
            <tr>
                <td>Staff_ID</td>
                <td>First_Name</td>
                <td>Last_Name</td>
                <td>Address_ID</td>
                <td>Picture</td>
                <td>Email</td>
                <td>Store_ID</td>
                <td>Active</td>
                <td>UserName</td>
                <td>PassWord</td>
                <td>Last_Update</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($Staffs as $Staff): ?>
            <tr>
                <td><?=$Staff['staff_id']?></td>
                <td><?=$Staff['first_name']?></td>
                <td><?=$Staff['last_name']?></td>
                <td><?=$Staff['address_id']?></td>
                <td><?=$Staff['picture']?></td>
                <td><?=$Staff['email']?></td>
                <td><?=$Staff['store_id']?></td>
                <td><?=$Staff['active']?></td>
                <td><?=$Staff['username']?></td>
                <td><?=$Staff['password']?></td>
                <td><?=$Staff['last_update']?></td>
                <td class="actions">
                    <a href="update_staff.php?staff_id=<?=$Staff['staff_id']?>" class="edit"><i class="fas fa-pen fa-xs"></i>Edit</a>
                    <a href="delete_staff.php?staff_id=<?=$Staff['staff_id']?>" class="trash"><i class="fas fa-trash fa-xs"></i>Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="read_staff.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_Staffs): ?>
		<a href="read_staff.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>