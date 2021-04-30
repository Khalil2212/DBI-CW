<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $lang = isset($_POST['customer_id']) && !empty($_POST['customer_id']) && $_POST['customer_id'] != 'auto' ? $_POST['customer_id'] : NULL;
    // Check if POST variable "store_id" exists, if not default the value to blank, basically the same for all variables
    $Na = isset($_POST['store_id']) ? $_POST['store_id'] : '';
    $create_date = isset($_POST['create_date']) ? $_POST['create_date'] :date('Y-m-d H:i:s');
    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO customer_store VALUES (?, ?, ?)');
    $stmt->execute([$lang, $Na, $create_date]);
    // Output message
    $msg = 'Created Successfully!';
}
?>
<?=template_header('Create')?>

<div class="content update">
	<h2>Create Record</h2>
    <form action="create_customer_store.php" method="post">
        <label for="customer_id">Customer_Id</label>
        <input type="text" name="customer_id"value="auto" id="customer_id">
        <label for="store_id">Store_Id</label>
        <input type="text" name="store_id" id="store_id">
        <label for="create_date">Create_Date</label>
        <input type="datetime-local" name="create_date" value="<?=date('Y-m-d\TH:i')?>" id="create_date">
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>