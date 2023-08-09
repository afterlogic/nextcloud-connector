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
				<?php p($l->t('Afterlogic WebMail authentication method')); ?>:
				<br />(<a href="https://afterlogic.com/docs/webmail-lite/configuring-webmail/nextcloud-integration" target="_blank"><?php p($l->t('check this documentation page for details')); ?></a>)<br />
				<br /><input style="vertical-align: middle;" type="radio" id="path-1" name="afterlogic-path" value="web" <?php echo(($_['afterlogic-path']!="") ? 'checked="checked" ' : ''); ?>/>&nbsp;<label for="path-1">Web API (recommended option)</label>
				<br /><input style="vertical-align: middle;" type="radio" id="path-2" name="afterlogic-path" value="" <?php echo(($_['afterlogic-path']=="") ? 'checked="checked" ' : ''); ?>/>&nbsp;<label for="path-2">POST (for diff. domains/servers)</label>
				<br />
				<br />
				<input type="button" class="afterlogic-save-button"
					value="<?php p($l->t('Save')); ?>" data-ajax-button-value="<?php p($l->t('Saving...')); ?>" />
				
				&nbsp;&nbsp;<span class="afterlogic-result"></span>
			</p>
		</fieldset>
	</form>
</div>