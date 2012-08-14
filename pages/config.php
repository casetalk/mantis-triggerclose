<?php

auth_reauthenticate();
access_ensure_global_level(config_get('manage_plugin_threshold'));

html_page_top('TriggerClose');

print_manage_menu();

$saved_categories = plugin_config_get('categories');
if(!$saved_categories) {
	$saved_categories = array();
}

$saved_statuses = plugin_config_get('statuses');
if(!$saved_statuses) {
	$saved_statuses = array();
}

$api = new TriggerCloseApi();

?>

<br />
<form action="<?php echo plugin_page('config_edit')?>" method="post">
<?php echo form_security_field('plugin_format_config_edit') ?>
<table class="width100" cellspacing="1">

<tr>
	<td class="form-title" colspan="2">
		TriggerClose
	</td>
</tr>

<tr <?php echo helper_alternate_class()?>>
	<td valign="top">
		<label for="maybe_close_active">Trigger check on page loads</label>
		<br /><span class="small">@todo note about cron job here</span>
	</td>
	<td valign="top">
		<input type="checkbox" id="maybe_close_active" name="maybe_close_active" value="1" <?php echo plugin_config_get('maybe_close_active')? 'checked="checked"' : null ?> />
	</td>
</tr>

<tr <?php echo helper_alternate_class()?>>
	<td valign="top">
		<label for="after_seconds">Close a ticket that haven't been modified after this many seconds</label>
		<br /><span class="small">0 means it's disabled, <?php echo TriggerCloseApi::MIN_SECONDS ?> is minimum</span>
	</td>
	<td valign="top">
		<input type="text" id="after_seconds" name="after_seconds" value="<?php echo plugin_config_get('after_seconds') ?>" />
	</td>
</tr>

<tr <?php echo helper_alternate_class()?>>
	<td valign="top">
		<label for="message">Note that signs an automatically closed issue</label>
	</td>
	<td valign="top">
		<textarea name="message" cols="80" rows="10"><?php echo plugin_config_get('message') ?></textarea>
	</td>
</tr>

<tr <?php echo helper_alternate_class()?>>
	<td valign="top">
		<label for="categories">Categories to look for inactive issues in</label>
	</td>
	<td valign="top">
		<select multiple="multiple" size="10" name="categories[]" id="categories">
		<?php foreach($api->available_categories() as $category_id => $label) {?>
			<option <?php if(in_array($category_id, $saved_categories)) { ?>selected="selected"<?php }?> value="<?php echo $category_id ?>"><?php echo $label ?></option>
		<?php } ?>
		</select>
	</td>
</tr>

<tr <?php echo helper_alternate_class()?>>
	<td valign="top">
		<label for="statuses">Issues with these statuses will be checked for inactivity</label>
	</td>
	<td valign="top">
		<select multiple="multiple" size="<?php echo count($api->available_statuses()) ?>" name="statuses[]" id="statuses">
		<?php foreach($api->available_statuses() as $status => $label) { ?>
			<option <?php if(in_array($status, $saved_statuses)) { ?>selected="selected"<?php }?> value="<?php echo $status ?>"><?php echo $label ?></option>
		<?php } ?>
		</select>
	</td>
</tr>

<tr>
	<td class="center" colspan="2">
		<input type="submit" class="button" value="Save" />
	</td>
</tr>

</table>
</form>

<?php
html_page_bottom();