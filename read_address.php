<?php
include 'functions.php';
// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 20;
// Prepare the SQL statement and get records from our contacts table, LIMIT will determine the page
$stmt = $pdo->prepare('SELECT * FROM address ORDER BY address_id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$Addresses = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Get the total number of contacts, this is so we can determine whether there should be a next and previous button
$num_Addresses = $pdo->query('SELECT COUNT(*) FROM address')->fetchColumn();
?>
<?=template_header('Read')?>

<div class="content read">
	<h2>Read Address File</h2>
	<a href="create_address.php" class="create-button">Create Address</a>
	<table>
        <thead>
            <tr>
                <td>Address_ID</td>
                <td>Address</td>
                <td>District</td>
                <td>City_ID</td>
                <td>Postal_Code</td>
                <td>Phone</td>
                <td>Last_Update</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($Addresses as $Address): ?>
            <tr>
                <td><?=$Address['address_id']?></td>
                <td><?=$Address['address']?></td>
                <td><?=$Address['district']?></td>
                <td><?=$Address['city_id']?></td>
                <td><?=$Address['postal_code']?></td>
                <td><?=$Address['phone']?></td>
                <td><?=$Address['last_update']?></td>
                <td class="actions">
                    <a href="update_address.php?address_id=<?=$Address['address_id']?>" class="edit"><i class="fas fa-pen fa-xs"></i>Edit</a>
                    <a href="delete_address.php?address_id=<?=$Address['address_id']?>" class="trash"><i class="fas fa-trash fa-xs"></i>Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="read_address.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_Addresses): ?>
		<a href="read_address.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>