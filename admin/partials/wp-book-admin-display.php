<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/SaurabhBagde
 * @since      1.0.0
 *
 * @package    Wp_Book
 * @subpackage Wp_Book/admin/partials
 */

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="jumbotron">
<h1>Book Setting</h1>
<form>
<div class="form-group">
	<label for="exampleFormControlInput1">Email address</label>
	<input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
</div>
<div class="form-group">
	<label for="exampleFormControlSelect1">Example select</label>
	<select class="form-control" id="exampleFormControlSelect1">
	<option>1</option>
	<option>2</option>
	<option>3</option>
	<option>4</option>
	<option>5</option>
	</select>
</div>
<div class="form-group">
	<label for="exampleFormControlSelect2">Example multiple select</label>
	<select multiple class="form-control" id="exampleFormControlSelect2">
	<option>1</option>
	<option>2</option>
	<option>3</option>
	<option>4</option>
	<option>5</option>
	</select>
</div>
<div class="form-group">
	<label for="exampleFormControlTextarea1">Example textarea</label>
	<textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
</div>
<button type="submit" class="btn btn-primary mb-2">Submit Settings</button>
</form>
</div>

