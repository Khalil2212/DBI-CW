<?php
include 'functions.php';
// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 20;
// Prepare the SQL statement and get records from our contacts table, LIMIT will determine the page
$stmt = $pdo->prepare('SELECT * FROM rental ORDER BY rental_id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$Rentals = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Get the total number of contacts, this is so we can determine whether there should be a next and previous button
$num_Rentals = $pdo->query('SELECT COUNT(*) FROM rental')->fetchColumn();
?>
<?=template_header('Read')?>

<div class="content read">
	<h2>Read Rental File</h2>
	<a href="create_rental.php" class="create-button">Create Rental</a>
	<table>
        <thead>
            <tr>
                <td>Rental_ID</td>
                <td>Rental_Date</td>
                <td>Inventory_ID</td>
                <td>Customer_ID</td>
                <td>Return_Date</td>
                <td>Staff_ID</td>
                <td>Last_Update</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($Rentals as $Rental): ?>
            <tr>
                <td><?=$Rental['rental_id']?></td>
                <td><?=$Rental['rental_date']?></td>
                <td><?=$Rental['inventory_id']?></td>
                <td><?=$Rental['customer_id']?></td>
                <td><?=$Rental['return_date']?></td>
                <td><?=$Rental['staff_id']?></td>
                <td><?=$Rental['last_update']?></td>
                <td class="actions">
                    <a href="update_rental.php?rental_id=<?=$Rental['rental_id']?>" class="edit"><i class="fas fa-pen fa-xs"></i>Edit</a>
                    <a href="delete_rental.php?rental_id=<?=$Rental['rental_id']?>" class="trash"><i class="fas fa-trash fa-xs"></i>Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="read_rental.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_Rentals): ?>
		<a href="read_rental.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>