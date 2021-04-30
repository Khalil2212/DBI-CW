<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact id exists, for example update.php?id=1 will get the contact with the id of 1
if (isset($_GET['film_id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $f_ID = isset($_POST['film_id']) ? $_POST['film_id'] : NULL;
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
        // Update the record
        $stmt = $pdo->prepare('UPDATE film SET film_id = ?, title = ?, description = ?, release_year = ?,  language_id= ?, original_language_id = ?, rental_duration = ?, rental_rate = ?,length = ? , replacement_cost = ? , rating = ? , special_features = ?, last_update = ? WHERE film_id = ?');
        $stmt->execute([$f_ID, $Title, $Desc,$Release_year,$Lang_id,$O_Lang, $Ren, $Rent_Rate,$Leng, $Rep, $Rating ,$Spec, $Last_update,$_GET['film_id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM film WHERE film_id = ?');
    $stmt->execute([$_GET['film_id']]);
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
	<h2>Update film #<?=$A['film_id']?></h2>
    <form action="update_film.php?film_id=<?=$A['film_id']?>" method="post">
    <label for="film_id">Film_ID</label>
        <label for="title">Title</label>
        <input type="text" name="film_id" value=<?=$A['film_id']?> id="film_id">
        <input type="text" name="title" value=<?=$A['title']?> id="title">
        <label for="description">Description</label>
        <label for="release_year">Release_Year</label>
        <input type="text" name="description" value=<?=$A['description']?> id="description">
        <input type="text" name="release_year" value=<?=$A['release_year']?> id="release_year">
        <label for="language_id">LanguageId</label>
        <label for="original_language_id">Original_Language_id</label>
        <input type="text" name="language_id" value= <?=$A['language_id']?> id="language_id">
        <input type="text" name="original_language_id" value= <?=$A['original_language_id']?> id="original_language_id">
        <label for="rental_duration">rental_duration</label>
        <label for="rental_rate">Rental_Rate</label>
        <input type="text" name="rental_duration" value= <?=$A['rental_duration']?> id="rental_duration">
        <input type="text" name="rental_rate" value= <?=$A['rental_rate']?> id="rental_rate">
        <label for="length">Length</label>
        <label for="replacement_cost">Replacement_Cost</label>
        <input type="text" name="length"value= <?=$A['length']?> id="length">
        <input type="text" name="replacement_cost" value=<?=$A['replacement_cost']?> id="replacement_cost">
        <label for="rating">Rating</label>
        <label for="special_features">Special_Feature</label>
        <input type="text" name="rating" value=<?=$A['rating']?> id="rating">
        <input type="text" name="special_features" value= <?=$A['special_features']?> id="special_features">
        <label for="last_update">Last_Update</label>
        <input type="datetime-local" name="last_update" value="<?=date('Y-m-d\TH:i', strtotime($A['last_update']))?>" id="last_update">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>