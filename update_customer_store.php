<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact id exists, for example update.php?id=1 will get the contact with the id of 1
if (isset($_GET['customer_id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $Lang = isset($_POST['customer_id']) ? $_POST['customer_id'] : NULL;
        $Name = isset($_POST['store_id']) ? $_POST['store_id'] : '';
        $create_date = isset($_POST['create_date']) ? $_POST['create_date'] :date('Y-m-d H:i:s');
        // Update the record
        $stmt = $pdo->prepare('UPDATE customer_store SET customer_id = ?, store_id = ?, create_date = ? WHERE customer_id = ?');
        $stmt->execute([$Lang, $Name, $create_date,$_GET['customer_id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM customer_store WHERE customer_id = ?');
    $stmt->execute([$_GET['customer_id']]);
    $Cat = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$Cat) {
        exit('Contact doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>
<?=template_header('Read')?>

<div class="content update">
	<h2>Update Customer_store #<?=$Cat['customer_id']?></h2>
    <form action="update_customer_store.php?customer_id=<?=$Cat['customer_id']?>" method="post">
        <label for="customer_id">customer_id</label>
        <label for="store_id">Store_id</label>
        <input type="text" name="customer_id" placeholder="1" value="<?=$Cat['customer_id']?>" id="customer_id">
        <input type="text" name="store_id" value="<?=$Cat['store_id']?>" id="store_id">
        <label for="create_date">Create_Date</label>
        <input type="datetime-local" name="create_date" value="<?=date('Y-m-d\TH:i', strtotime($Cat['create_date']))?>" id="create_date">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>