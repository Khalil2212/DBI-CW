<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $Cit = isset($_POST['staff_id']) && !empty($_POST['staff_id']) && $_POST['staff_id'] != 'auto' ? $_POST['staff_id'] : NULL;
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $Title = isset($_POST['active']) ? $_POST['active'] : '';
        $Desc = isset($_POST['username']) ? $_POST['username'] : '';
        $Release_year = isset($_POST['password']) ? $_POST['password'] : '';
        $Lang_id = isset($_POST['store_id']) ? $_POST['store_id'] : '';
    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO staff_store VALUES (?, ?, ?, ?)');
    $stmt->execute([$Cit, $Title, $Desc, $Release_year, $Lang_id]);
    // Output message
    $msg = 'Created Successfully!';
}
?>
<?=template_header('Create')?>

<div class="content update">
	<h2>Create Staff_Store</h2>
    <form action="create_staff_store.php" method="post">
        <label for="staff_id">Staff_ID</label>
        <label for="active">Active</label>
        <input type="text" name="staff_id"  id="staff_id">
        <input type="text" name="active" id="active">
        <label for="username">Username</label>
        <label for="password">Password</label>
        <input type="text" name="username"  id="username">
        <input type="text" name="password"  id="password">
        <label for="store_id">Store_Id</label>
        <input type="text" name="store_id"  id="store_id">
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>