<div class="wrap">
    <h2><?php _e('PayPRLike Button', 'payprlike')?></h2>
	<div id="icon-options-general" class="icon32"><br /></div>
	<p><?php _e('Plugin options description', 'payprlike')?></p>
	<?php echo (isset($message)) ? $message : ''; ?>
	<form name="payprlike_form" method="post" action="">
		<h3></h3>
		<input type="hidden" name="payprlike_form_submitted" value="YES">
		<table class="form-table" cellpadding="5" cellspacing="5">								
			<tr>
				<th>
					<label for="payprlike_username"><?php _e('PayPRlike Username', 'payprlike')?></label>
				</th>
				<td>
					<input type="text" name="payprlike_username" id="payprlike_username" value="<?php echo (isset($payprlike_username) && !empty($payprlike_username)) ? $payprlike_username : '' ; ?>" /> 
				</td>
			</tr>
			<tr>
				<th>
					<label for="button_aligment"><?php _e('Button aligment', 'payprlike')?></label>
				</th>
				<td>
					<select name="button_aligment" id="button_aligment">
						<option value="inherit">-- <?php _e('Select direction', 'payprlike') ?> --</option>
						<?php
						$opt_items = array('left' => 'Left', 'center' => 'Center', 'right' => 'Right');
						foreach ($opt_items as $key => $value):
							$selected = (isset($button_aligment) && $button_aligment == $key) ? 'selected="selected"' : '';
							echo "<option value=" . $key . " " . $selected . ">" . $value . "</option>";
						endforeach;
						?>
					</select>
				</td>
			</tr>
		</table>
		<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e('Save Changes', 'payprlike')?>"></p>
	</form>
</div>