<?phpadd_action( 'admin_menu', 'um_register_admin_page' );function um_register_admin_page(){	add_submenu_page( 'options-general.php' , 'Post Type URL Changer', 'Post Type URL Changer', 'manage_options', 'post_type_url_changer', 'um_admin_page_render'); }function um_admin_page_render(){	save_post_data();	$args = array(		"public" => true,		"show_ui" => true	);	$post_types = get_post_types( $args, 'objects' );	$post_types_active = get_option("um_post_type_url_changer_post_types");	?>	<div class="wrap">	<h2>Post Type URL Changer Settings</h2>	<form method="post" action="options-general.php?page=post_type_url_changer">		<?php wp_nonce_field( 'um_post_types_nonce', 'um_save_post_types' ); ?>		<table class="form-table">			<tbody>				<tr class="option-site-visibility">				<th scope="row">Enable on post types : </th>					<td>						<fieldset>							<?php foreach($post_types as $p): ?>							<label>								<input name="post_types[]" type="checkbox" <?php echo is_array($post_types_active) && in_array($p->name,$post_types_active) ? 'checked' : ''; ?> value="<?php echo $p->name; ?>">								<?php echo $p->labels->name; ?>							</label><br/>							<?php endforeach; ?>						</fieldset>					</td>				</tr>			</tbody>		</table>		<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>	</form></div>		<?php}function save_post_data(){	if(isset($_REQUEST['post_types'])){		if ( !isset($_REQUEST['um_save_post_types']) || !check_admin_referer('um_post_types_nonce','um_save_post_types')){			print 'Sorry, your nonce did not verify.';			exit;		}		$post_types_to_save = $_REQUEST['post_types'];		if($post_types_to_save){			update_option('um_post_type_url_changer_post_types',$post_types_to_save);			?> 				<div id="setting-error-settings_updated" class="updated settings-error"> 				<p><strong>Settings saved.</strong></p></div>			<?php		}	}}?>