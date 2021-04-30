<?php
include 'functions.php';
// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 20;
// Prepare the SQL statement and get records from our contacts table, LIMIT will determine the page
$stmt = $pdo->prepare('SELECT * FROM store ORDER BY store_id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$Stores = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Get the total number of contacts, this is so we can determine whether there should be a next and previous button
$num_Stores = $pdo->query('SELECT COUNT(*) FROM store')->fetchColumn();
?>
<?=template_header('Read')?>

<div class="content read">
	<h2>Read Store File</h2>
	<a href="create_store.php" class="create-button">Create a Store</a>
	<table>
        <thead>
            <tr>
                <td>Store_ID</td>
                <td>Manager_Staff_ID</td>
                <td>Address_ID</td>
                <td>Last_Update</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($Stores as $Store): ?>
            <tr>
                <td><?=$Store['store_id']?></td>
                <td><?=$Store['manager_staff_id']?></td>
                <td><?=$Store['Address_id']?></td>
                <td><?=$Store['last_update']?></td>
                <td class="actions">
                    <a href="update_store.php?store_id=<?=$Store['store_id']?>" class="edit"><i class="fas fa-pen fa-xs"></i>Edit</a>
                    <a href="delete_store.php?store_id=<?=$Store['store_id']?>" class="trash"><i class="fas fa-trash fa-xs"></i>Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="read_store.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_Stores): ?>
		<a href="read_store.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>