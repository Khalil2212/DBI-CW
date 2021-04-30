<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $Cit = isset($_POST['city_id']) && !empty($_POST['city_id']) && $_POST['city_id'] != 'auto' ? $_POST['city_id'] : NULL;
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $City = isset($_POST['city']) ? $_POST['city'] : '';
    $COuntry = isset($_POST['country_id']) ? $_POST['country_id'] : '';
    $Last_update = isset($_POST['last_update']) ? $_POST['last_update'] :date('Y-m-d H:i:s');
    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO city VALUES (?, ?, ?, ?)');
    $stmt->execute([$Cit, $City,$COuntry, $Last_update]);
    // Output message
    $msg = 'Created Successfully!';
}
?>
<?=template_header('Create')?>

<div class="content update">
	<h2>Create city</h2>
    <form action="create_city.php" method="post">
        <label for="city_id">City_Id</label>
        <input type="text" name="city_id"value="auto" id="city_id">
        <label for="city">City</label>
        <input type="text" name="city" id="city">
        <label for="country_id">Country_id</label>
        <input type="text" name="country_id" id="country_id">
        <label for="last_update">Last_Update</label>
        <input type="datetime-local" name="last_update" value="<?=date('Y-m-d\TH:i')?>" id="last_update">
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>