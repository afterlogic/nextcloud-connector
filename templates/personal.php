<div class="section">
	<form action="#" method="post" class="afterlogic-ajax-form" data-ajax-file="personal.php">
		<input type="hidden" name="requesttoken" value="<?php echo $_['requesttoken'] ?>" id="requesttoken">
		<input type="hidden" name="appname" value="afterlogic">

		<fieldset class="personalblock">
			<h2><?php p($l->t('Afterlogic WebMail')); ?></h2>
			<p>
				<input type="text" name="afterlogic-email" style="width: 250px"
					value="<?php echo $_['afterlogic-email']; ?>" placeholder="<?php p($l->t('Email')); ?>" />

				<br />
				
				<input type="password" name="afterlogic-password" style="width: 250px"
					value="<?php echo $_['afterlogic-password']; ?>" placeholder="<?php p($l->t('Password')); ?>" />
				
				<br />

				<input type="button" class="afterlogic-save-button"
					value="<?php p($l->t('Save')); ?>" data-ajax-button-value="<?php p($l->t('Saving...')); ?>" />
				
				&nbsp;&nbsp;<span class="afterlogic-result"></span>
			</p>
		</fieldset>
	</form>
</div>