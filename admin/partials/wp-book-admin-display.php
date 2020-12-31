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

<h1>Book Setting</h1>
<?php settings_errors(); ?>
<form method="post" action="options.php">
	<?php settings_fields( 'books-setting-group' ); ?>
	<?php do_settings_sections( 'book_settings' ); ?> 
	<?php submit_button(); ?>
</form>


