<?php
include 'functions.php';
// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 20;
// Prepare the SQL statement and get records from our contacts table, LIMIT will determine the page
$stmt = $pdo->prepare('SELECT * FROM payment ORDER BY payment_id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$Payments = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Get the total number of contacts, this is so we can determine whether there should be a next and previous button
$num_Payments = $pdo->query('SELECT COUNT(*) FROM payment')->fetchColumn();
?>
<?=template_header('Read')?>

<div class="content read">
	<h2>Read Payment File</h2>
	<a href="create_payment.php" class="create-button">Create Payment</a>
	<table>
        <thead>
            <tr>
                <td>Payment_ID</td>
                <td>Customer_ID</td>
                <td>Staff_ID</td>
                <td>Rental_ID</td>
                <td>Amount</td>
                <td>Payment_Date</td>
                <td>Last_Update</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($Payments as $Payment): ?>
            <tr>
                <td><?=$Payment['payment_id']?></td>
                <td><?=$Payment['customer_id']?></td>
                <td><?=$Payment['staff_id']?></td>
                <td><?=$Payment['rental_id']?></td>
                <td><?=$Payment['amount']?></td>
                <td><?=$Payment['payment_date']?></td>
                <td><?=$Payment['last_update']?></td>
                <td class="actions">
                    <a href="update_payment.php?payment_id=<?=$Payment['payment_id']?>" class="edit"><i class="fas fa-pen fa-xs"></i>Edit</a>
                    <a href="delete_payment.php?payment_id=<?=$Payment['payment_id']?>" class="trash"><i class="fas fa-trash fa-xs"></i>Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="read_payment.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_Payments): ?>
		<a href="read_payment.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>