<div class="section">
	<form action="#" method="post" class="afterlogic-ajax-form" data-ajax-file="admin.php">
		<input type="hidden" name="requesttoken" value="<?php echo $_['requesttoken'] ?>" id="requesttoken">
		<input type="hidden" name="appname" value="afterlogic">

		<fieldset class="personalblock">
			<h2><?php p($l->t('Afterlogic WebMail')); ?></h2>
			<br />
			<p>
				<?php p($l->t('Web URL to Afterlogic WebMail installation')); ?>:
				<br />
				<input type="text" style="width: 350px;" name="afterlogic-url"
					value="<?php echo $_['afterlogic-url']; ?>" placeholder="https://" />
				<br />
				<br />
				<?php p($l->t('File path to Afterlogic WebMail installation')); ?>:
				<br />
				<input type="text" style="width: 350px;" name="afterlogic-path"
					value="<?php echo $_['afterlogic-path']; ?>" />
				<br />
				<br />
				<input type="button" class="afterlogic-save-button"
					value="<?php p($l->t('Save')); ?>" data-ajax-button-value="<?php p($l->t('Saving...')); ?>" />
				
				&nbsp;&nbsp;<span class="afterlogic-result"></span>
			</p>
		</fieldset>
	</form>
</div>