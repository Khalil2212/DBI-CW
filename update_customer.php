<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact id exists, for example update.php?id=1 will get the contact with the id of 1
if (isset($_GET['customer_id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $Cust_id = isset($_POST['customer_id']) ? $_POST['customer_id'] : NULL;
        $Store_id = isset($_POST['store_id']) ? $_POST['store_id'] : '';
        $First = isset($_POST['first_name']) ? $_POST['first_name'] : '';
        $Last = isset($_POST['last_name']) ? $_POST['last_name'] : '';
        $Email = isset($_POST['email']) ? $_POST['email'] : '';
        $Address = isset($_POST['address_id']) ? $_POST['address_id'] : '';
        $Active  = isset($_POST['active']) ? $_POST['active'] : '';
        $Create = isset($_POST['create_date']) ? $_POST['create_date'] :date('Y-m-d H:i:s');
        $Last_update = isset($_POST['last_update']) ? $_POST['last_update'] :date('Y-m-d H:i:s');
        // Update the record
        $stmt = $pdo->prepare('UPDATE address SET customer_id = ?, store_id = ?, first_name = ?, last_name = ?,  email= ?, address_id = ?, active = ?, create_date = ?, last_update = ? WHERE customer_id = ?');
        $stmt->execute([$Cust_id, $Store_id, $First,$Last,$Email,$Address, $Active, $Create, $Last_update,$_GET['customer_id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM customer WHERE customer_id = ?');
    $stmt->execute([$_GET['customer_id']]);
    $A = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$A) {
        exit('Contact doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>
<?=template_header('Read')?>

<div class="content update">
	<h2>Update Customer #<?=$A['customer_id']?></h2>
    <form action="update_customer.php?customer_id=<?=$A['customer_id']?>" method="post">
        <label for="customer_id">Customer_ID</label>
        <label for="store_id">Store_ID</label>
        <input type="text" name="customer_id"value="<?=$A['customer_id']?>" id="customer_id">
        <input type="text" name="store_id" value="<?=$A['store_id']?>" id="store_id">
        <label for="first_name">First_Name</label>
        <label for="last_name">Last_Name</label>
        <input type="text" name="first_name"value="<?=$A['first_name']?>" id="first_name">
        <input type="text" name="last_name" value="<?=$A['last_name']?>" id="last_name">
        <label for="email">Email</label>
        <label for="address_id">Address_ID</label>
        <input type="text" name="email"value="<?=$A['email']?>" id="email">
        <input type="text" name="address_id" value="<?=$A['address_id']?>" id="address_id">
        <label for="active">Active</label>
        <label for="create_date">Create_Date</label>
        <label for="last_update">Last_update</label>
        <input type="text" name="active" value="<?=$A['active']?>" id="active">
        <input type="datetime-local" name="create_date" value="<?=date('Y-m-d\TH:i', strtotime($A['create_date']))?>" id="create_date">
        <input type="datetime-local" name="last_update" value="<?=date('Y-m-d\TH:i', strtotime($A['last_update']))?>" id="last_update">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>