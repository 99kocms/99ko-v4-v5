<?php defined('ROOT') OR exit('No direct script access allowed'); ?>
		</div>
	</div>
	<div id="footer">
		<div id="footer_content">
			<?php $core->callHook('footer'); ?>
			<p>
				<a target='_blank' href='https://github.com/99kocms/'>Just using 99ko</a> - Thème <?php show::theme(); ?> - <a rel="nofollow" href="<?= ADMIN_PATH ?>">Administration</a>
			</p>
			<?php $core->callHook('endFooter'); ?>
		</div>
	</div>
</div>
<?php $core->callHook('endFrontBody'); ?>
</body>
</html>
