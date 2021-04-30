<?php
include 'functions.php';
// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 20;
// Prepare the SQL statement and get records from our contacts table, LIMIT will determine the page
$stmt = $pdo->prepare('SELECT * FROM customer_payment_rental_details ORDER BY customer_id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$C_P_R = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Get the total number of contacts, this is so we can determine whether there should be a next and previous button
$num_C_P_R = $pdo->query('SELECT COUNT(*) FROM customer_payment_rental_details')->fetchColumn();
?>
<?=template_header('Read')?>

<div class="content read">
	<h2>Read Customer_Payment_Rental_details File</h2>
	<a href="create_customer_payment_rental_details.php" class="create-button">Create a Record</a>
	<table>
        <thead>
            <tr>
                <td>Customer_ID</td>
                <td>Payment_Id</td>
                <td>Rental_ID</td>
                <td>Staff_ID</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($C_P_R as $C_P_Rs): ?>
            <tr>
                <td><?=$C_P_Rs['customer_id']?></td>
                <td><?=$C_P_Rs['payment_id']?></td>
                <td><?=$C_P_Rs['rental_id']?></td>
                <td><?=$C_P_Rs['staff_id']?></td>
                <td class="actions">
                    <a href="update_customer_payment_rental_details.php?customer_id=<?=$C_P_Rs['customer_id']?>" class="edit"><i class="fas fa-pen fa-xs"></i>Edit</a>
                    <a href="delete_customer_payment_rental_details.php?customer_id=<?=$C_P_Rs['customer_id']?>" class="trash"><i class="fas fa-trash fa-xs"></i>Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="read_customer_payment_rental_details.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_C_P_R): ?>
		<a href="read_customer_payment_rental_details.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>