<?php defined('ROOT') OR exit('No direct script access allowed'); ?>
		</div>
	</div>
	<div id="footer">
		<p>
			<a target="_blank" href="https://github.com/99kocms/">Just using 99ko</a><br>
			Thème <?php show::theme(); ?><br>
			<a rel="nofollow" href="<?php echo ADMIN_PATH ?>">Administration</a>
		</p>
	</div>
</div>
<?php eval($core->callHook('endFrontBody')); ?>
</body>
</html>
