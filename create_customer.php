<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $Cust_id = isset($_POST['customer_id']) && !empty($_POST['customer_id']) && $_POST['customer_id'] != 'auto' ? $_POST['customer_id'] : NULL;
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $Store_id = isset($_POST['store_id']) ? $_POST['store_id'] : '';
    $First = isset($_POST['first_name']) ? $_POST['first_name'] : '';
    $Last = isset($_POST['last_name']) ? $_POST['last_name'] : '';
    $Email = isset($_POST['email']) ? $_POST['email'] : '';
    $Address = isset($_POST['address_id']) ? $_POST['address_id'] : '';
    $Active = isset($_POST['active']) ? $_POST['active'] : '';
    $Create = isset($_POST['create_date']) ? $_POST['create_date'] :date('Y-m-d H:i:s');
    $Last_update = isset($_POST['last_update']) ? $_POST['last_update'] :date('Y-m-d H:i:s');
    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO customer VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$Cust_id, $Store_id, $First, $Last, $Email, $Address, $Active, $Create, $Last_update]);
    // Output message
    $msg = 'Created Successfully!';
}
?>
<?=template_header('Create')?>

<div class="content update">
	<h2>Create Customer</h2>
    <form action="create_customer.php" method="post">
        <label for="customer_id">Customer_ID</label>
        <label for="store_id">Store_id</label>
        <input type="text" name="customer_id" value="auto" id="customer_id">
        <input type="text" name="store_id" id="store_id">
        <label for="first_name">First_Name</label>
        <label for="last_name">Last_Name</label>
        <input type="text" name="first_name" id="first_name">
        <input type="text" name="last_name" id="last_name">
        <label for="email">Email</label>
        <label for="address_id">Address_ID</label>
        <input type="text" name="email" id="email">
        <input type="text" name="address_id" id="address_id">
        <label for="active">Active</label>
        <label for="create_date">Create_Date</label>
        <label for="last_update">Last_Update</label>
        <input type="text" name="active" id="active">
        <input type="datetime-local" name="creat_date" value="<?=date('Y-m-d\TH:i')?>" id="create_date">
        <input type="datetime-local" name="last_update" value="<?=date('Y-m-d\TH:i')?>" id="last_update">
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>