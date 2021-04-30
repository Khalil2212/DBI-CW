<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $f_ID = isset($_POST['film_id']) && !empty($_POST['film_id']) && $_POST['film_id'] != 'auto' ? $_POST['film_id'] : NULL;
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $Title = isset($_POST['title']) ? $_POST['title'] : '';
    $Desc = isset($_POST['description']) ? $_POST['description'] : '';
    $Release_year = isset($_POST['release_year']) ? $_POST['release_year'] : '';
    $Lang_id = isset($_POST['language_id']) ? $_POST['language_id'] : '';
    $O_Lang = isset($_POST['original_language_id']) ? $_POST['original_language_id'] : '';
    $Ren = isset($_POST['rental_duration']) ? $_POST['rental_duration'] : '';
    $Rent_Rate = isset($_POST['rental_rate']) ? $_POST['rental_rate'] :'';
    $Leng = isset($_POST['length']) ? $_POST['length'] :'';
    $Rep = isset($_POST['replacement_cost']) ? $_POST['replacement_cost'] :'';
    $Rating = isset($_POST['rating']) ? $_POST['rating'] :'';
    $Spec = isset($_POST['special_features']) ? $_POST['special_features'] :'';
    $Last_update = isset($_POST['last_update']) ? $_POST['last_update'] :date('Y-m-d H:i:s');
    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO film VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$f_ID, $Title, $Desc, $Release_year, $Lang_id, $O_Lang, $Ren, $Rent_Rate,$Leng,$Rep,$Rating,$Spec, $Last_update]);
    // Output message
    $msg = 'Created Successfully!';
}
?>
<?=template_header('Create')?>

<div class="content update">
	<h2>Create Film</h2>
    <form action="create_film.php" method="post">
        <label for="film_id">Film_ID</label>
        <label for="title">Title</label>
        <input type="text" name="film_id" value="auto" id="film_id">
        <input type="text" name="title" id="title">
        <label for="description">Description</label>
        <label for="release_year">Release_Year</label>
        <input type="text" name="description" id="description">
        <input type="text" name="release_year" id="release_year">
        <label for="language_id">LanguageId</label>
        <label for="original_language_id">Original_Language_id</label>
        <input type="text" name="language_id" id="language_id">
        <input type="text" name="original_language_id" id="original_language_id">
        <label for="rental_duration">rental_duration</label>
        <label for="rental_rate">Rental_Rate</label>
        <input type="text" name="rental_duration" id="rental_duration">
        <input type="text" name="rental_rate" id="rental_rate">
        <label for="length">Length</label>
        <label for="replacement_cost">Replacement_Cost</label>
        <input type="text" name="length" id="length">
        <input type="text" name="replacement_cost" id="replacement_cost">
        <label for="rating">Rating</label>
        <label for="special_features">Special_Feature</label>
        <input type="text" name="rating" id="rating">
        <input type="text" name="special_features" id="special_features">
        <label for="last_update">Last_Update</label>
        <input type="datetime-local" name="last_update" value="<?=date('Y-m-d\TH:i')?>" id="last_update">
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>