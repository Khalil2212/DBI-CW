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
    $Title = isset($_POST['first_name']) ? $_POST['first_name'] : '';
        $Desc = isset($_POST['last_name']) ? $_POST['last_name'] : '';
        $Release_year = isset($_POST['address_id']) ? $_POST['address_id'] : '';
        $Lang_id = isset($_POST['picture']) ? $_POST['picture'] : '';
        $O_Lang = isset($_POST['email']) ? $_POST['email'] : '';
        $Ren = isset($_POST['store_id']) ? $_POST['store_id'] : '';
        $Rent_Rate = isset($_POST['active']) ? $_POST['active'] :'';
        $Leng = isset($_POST['username']) ? $_POST['username'] :'';
        $Rep = isset($_POST['password']) ? $_POST['password'] :'';
        $Last_update = isset($_POST['last_update']) ? $_POST['last_update'] :date('Y-m-d H:i:s');
    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO staff VALUES (?, ?, ?, ?, ? , ? , ? , ? , ? , ? , ?)');
    $stmt->execute([$Cit, $Title, $Desc, $Release_year, $Lang_id, $O_Lang, $Ren, $Rent_Rate, $Leng, $Rep , $Last_update]);
    // Output message
    $msg = 'Created Successfully!';
}
?>
<?=template_header('Create')?>

<div class="content update">
	<h2>Create Staff</h2>
    <form action="create_staff.php" method="post">
        <label for="staff_id">staff_ID</label>
        <label for="first_name">First_Name</label>
        <input type="text" name="staff_id"  id="staff_id">
        <input type="text" name="first_name" id="first_name">
        <label for="last_name">Last_Name</label>
        <label for="address_id">Address_id</label>
        <input type="text" name="last_name"  id="last_name">
        <input type="text" name="address_id"  id="address_id">
        <label for="picture">Picture</label>
        <label for="email">Email</label>
        <input type="text" name="picture"  id="picture">
        <input type="text" name="email"  id="email">
        <label for="active">Active</label>
        <label for="username">Username</label>
        <input type="text" name="active"  id="active">
        <input type="text" name="username" id="username">
        <label for="password">Password</label>
        <label for="last_update">Last_Update</label>
        <input type="text" name="password"  id="password">
        <input type="datetime-local" name="last_update" value="<?=date('Y-m-d\TH:i')?>" id="last_update">
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>