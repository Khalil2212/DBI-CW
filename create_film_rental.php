<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $Cit = isset($_POST['film_id']) && !empty($_POST['film_id']) && $_POST['film_id'] != 'auto' ? $_POST['film_id'] : NULL;
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $Ci = isset($_POST['rental_duration']) ? $_POST['rental_duration'] : '';
    $COuntry = isset($_POST['rent_rate']) ? $_POST['rent_rate'] : '';
    $staf = isset($_POST['replacement_cost']) ? $_POST['replacement_cost'] :'';
    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO film_rental VALUES (?, ?, ?, ?)');
    $stmt->execute([$Cit, $Ci,$COuntry, $staf]);
    // Output message
    $msg = 'Created Successfully!';
}
?>
<?=template_header('Create')?>

<div class="content update">
	<h2>Create record</h2>
    <form action="create_film_rental.php" method="post">
        <label for="film_id">film_id</label>
        <input type="text" name="film_id"value="auto" id="film_id">
        <label for="rental_duration">rental_duration</label>
        <input type="text" name="rental_duration" id="rental_duration">
        <label for="rent_rate">rent_rate</label>
        <input type="text" name="rent_rate" id="rent_rate">
        <label for="replacement_cost">replacement_cost</label>
        <input type="text" name="replacement_cost" id="replacement_cost">
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>