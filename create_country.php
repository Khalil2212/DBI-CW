<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $Cat = isset($_POST['country_id']) && !empty($_POST['country_id']) && $_POST['country_id'] != 'auto' ? $_POST['country_id'] : NULL;
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $Na = isset($_POST['country']) ? $_POST['country'] : '';
    $Last_update = isset($_POST['last_update']) ? $_POST['last_update'] :date('Y-m-d H:i:s');
    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO actor VALUES (?, ?, ?)');
    $stmt->execute([$Cat, $Na, $Last_update]);
    // Output message
    $msg = 'Created Successfully!';
}
?>
<?=template_header('Create')?>

<div class="content update">
	<h2>Create Country</h2>
    <form action="create_country.php" method="post">
        <label for="country_id">Country_ID</label>
        <input type="text" name="country_id"value="auto" id="country_id">
        <label for="Country">Country</label>
        <input type="text" name="country" id="country">
        <label for="last_update">Last_Update</label>
        <input type="datetime-local" name="last_update" value="<?=date('Y-m-d\TH:i')?>" id="last_update">
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>