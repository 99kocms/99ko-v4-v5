<?php defined('ROOT') OR exit('No direct script access allowed'); ?>
<!doctype html>
<html lang="fr">
  <head>
	<?php $core->callHook('adminHead'); ?>
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>99ko - Administration</title>	
	<link rel="icon" href="data:image/gif;base64,R0lGODlhQABAALMAAENKWU5XaDlATTA1QFVfc0tUZTM5RDY8SUBHVVBZbFNcb0hQYT1DUUVNXVhidiwxOyH/C1hNUCBEYXRhWE1QPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4gPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNS4zLWMwMTEgNjYuMTQ1NjYxLCAyMDEyLzAyLzA2LTE0OjU2OjI3ICAgICAgICAiPiA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPiA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIiB4bWxuczpzdFJlZj0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3NUeXBlL1Jlc291cmNlUmVmIyIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ1M2IChXaW5kb3dzKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpDMDA4QzM0QkQ0MUMxMUU1OEVGMzhGN0Y5QzUyNThGRiIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDpDMDA4QzM0Q0Q0MUMxMUU1OEVGMzhGN0Y5QzUyNThGRiI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOkMwMDhDMzQ5RDQxQzExRTU4RUYzOEY3RjlDNTI1OEZGIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOkMwMDhDMzRBRDQxQzExRTU4RUYzOEY3RjlDNTI1OEZGIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+Af/+/fz7+vn49/b19PPy8fDv7u3s6+rp6Ofm5eTj4uHg397d3Nva2djX1tXU09LR0M/OzczLysnIx8bFxMPCwcC/vr28u7q5uLe2tbSzsrGwr66trKuqqainpqWko6KhoJ+enZybmpmYl5aVlJOSkZCPjo2Mi4qJiIeGhYSDgoGAf359fHt6eXh3dnV0c3JxcG9ubWxramloZ2ZlZGNiYWBfXl1cW1pZWFdWVVRTUlFQT05NTEtKSUhHRkVEQ0JBQD8+PTw7Ojk4NzY1NDMyMTAvLi0sKyopKCcmJSQjIiEgHx4dHBsaGRgXFhUUExIREA8ODQwLCgkIBwYFBAMCAQAAIfkEAAAAAAAsAAAAAEAAQAAABP/wyUmrvTjrzbv/YCiOZGmeaKqubOu+cCwLtCCfwuLsfIDcogZvyFPYgJxBgsjc/ZCaAjEBADQUxAMUAxgSGBUGobi1DMY7gtZyQDueZUmXB+byCp7aEYXdBTQDQxs5TD4mBkNwGAE8axdCTTtGJHM7HIw7exRKkUSKHzp+lzwAF1JDVFZ9jSKYDqUbrrAUlQ5fYW4KraQcQ7MSZzxqF208n6M7v8RDmg+1dReVeCCyG5CZFat/GYE8IacO0xjBPAYUiMaxrB8IQ+Z2grTxGq7NG+QO2xYCRPoSofmQvQpRq8CACgjc7GhQoZq6ZCE4DVkAQACAJUygSXCowZcIiZ34iBykwBHDAWYjBgBkUgBcAgslH6EkYWDBqnAC8Cl7AE7cBXwO3h2iMaFdOQtGdwi1UMvBi1U+J+DzR4HfEKopkjqwJ2eIQYQKHTBkMUAbN4w8KFpEO0SjBgOONKzkKpVtyB0jOQC4pUHrWEAribTk8dLDqQJL5RHOu6HmzQI53ezMQGQBg5EDENwcFsIAUQlaE2cwEDYk5xNQQRhwFTJB3BJa6WoQwJoIAQCMS5TtUeIAANYBcHOA22FuHDl8M/g9LuGw6K6LmT+ofBmYZi+vt5C+i126hNXcHbj2XrW2F+HkK/gGjj69+/fw48ufT7++/fv48+uXEQEAOw==">
	<?php show::linkTags(); ?>
	<link rel="stylesheet" href="styles.css" media="all">
	<?php show::scriptTags(); ?>
	<script type="text/javascript" src="scripts.js"></script>
	<?php $core->callHook('endAdminHead'); ?>	
  </head>
  <body>
	<div id="alert"><?php show::msg($msg); ?></div>
	<div id="container">
		<div id="header">
			<div id="header_content">	
			  <ul>
				<li><h1><a class="active" href="javascript:" id="open_nav"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAYAAACqaXHeAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyJpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoV2luZG93cykiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6RUI2RDM2N0YyMDRDMTFFNzkzMDFBMTE1Nzk0RUQ5MDciIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6RUI2RDM2ODAyMDRDMTFFNzkzMDFBMTE1Nzk0RUQ5MDciPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDpFQjZEMzY3RDIwNEMxMUU3OTMwMUExMTU3OTRFRDkwNyIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDpFQjZEMzY3RTIwNEMxMUU3OTMwMUExMTU3OTRFRDkwNyIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PjUVHUcAAABwSURBVHja7NWxEQAwDAKxsP/QZIQUvlTWj6AC0vZsLgAAAAAAAAAAAAAAAAAAAAAAAAAAAJj2WzQAAAAwggAAAAAAwA0CAADACAIAAAAAADcIAAAAIwgAAAAAAAAAAAAAAAAAAAAAAAAAAIBnV4ABAOfFy4HvRdNGAAAAAElFTkSuQmCC" alt=Administration" /></a></h1></li>
				<li><a target="_blank" href="../">Voir le site</a></li>
				<li><a href="index.php?action=logout&token=<?php echo administrator::getToken(); ?>">Déconnexion</a></li>
			  </ul>
			</div>
		</div>
		<div id="body">
		  <div id="content_mask">
			<div id="content" class="<?php echo $runPlugin->getName(); ?>-admin">
			<div id="sidebar">
			<ul id="navigation">
			  <?php
				foreach($pluginsManager->getPlugins() as $k=>$v) if($v->getConfigVal('activate') && $v->getAdminFile() && $v->getIsDefaultAdminPlugin()){ ?>
			  <li><a href="index.php?p=<?php echo $v->getName(); ?>"><?php echo $v->getInfoVal('name'); ?></a></li>
			  <?php
				}
				foreach($pluginsManager->getPlugins() as $k=>$v) if($v->getConfigVal('activate') && $v->getAdminFile() && !$v->getIsDefaultAdminPlugin()){ ?>
			  <li><a href="index.php?p=<?php echo $v->getName(); ?>"><?php echo $v->getInfoVal('name'); ?></a></li>
			  <?php
				}
				?>
				<li class="site"><a href="index.php?action=logout&token=<?php echo administrator::getToken(); ?>">Déconnexion</a></li>
				<li class="site"><a target="_blank" href="../">Voir le site</a></li>
			</ul>
			<p class="just_using">
			  <a target="_blank" href="https://github.com/99kocms/">Just using 99ko <?php echo VERSION; ?></a>
			</p>
		  </div>
				<?php if($runPlugin->getParamTemplate()){ ?>
				<a id="param_link" href="javascript:"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAALEwAACxMBAJqcGAAAANFJREFUaIHt2NsKgkAUheG/nsHqBTrQAd+8ML3womeKiOo6L0ZCBgxnMLfE+mCDCOqaQWEhiIiISJQtUACvegrgYJoowA64A29vHkBqmKuzEhf4CCTADMjqc2XsTf3dGGKSxvPngdcCMI1dbU8mLcejd8HtYobb+QWQN86NXor7YP3X4gosDXMF2eN2/YlbzAlYmSYS6cavAGdgY5ooQFsFuAFrw1ydfasAuWEuYLgK0NcA8VVCFcCKKoCIfKiSWPpJJdFfiQiqJFZUSURERP5CBWNA0IcsbTB2AAAAAElFTkSuQmCC" alt="Paramètres" /></a>
				<div id="param_panel">
          <div class="content">
					<h2>Paramètres</h2>
          <?php include($runPlugin->getParamTemplate()); ?>
          </div>
				</div>
				<?php } ?>
        <?php if($runPlugin->getHelpTemplate()){ ?>
				<a id="help_link" href="javascript:"><img src="       data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyJpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoV2luZG93cykiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6OEVGOEVGMUIwQ0Q4MTFFOEJENEZBN0NGOTlFOEMxMDIiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6OEVGOEVGMUMwQ0Q4MTFFOEJENEZBN0NGOTlFOEMxMDIiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDo4RUY4RUYxOTBDRDgxMUU4QkQ0RkE3Q0Y5OUU4QzEwMiIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDo4RUY4RUYxQTBDRDgxMUU4QkQ0RkE3Q0Y5OUU4QzEwMiIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PnzDwKYAAAJWSURBVHja7JnPS1RRFMfnZdJgiYlmgZZDampNO0ls449lRPgvlOAiKCZ3blxIu0FEwaFFQYt2LfoPQhR1IxKiqBs1jCAoxp6Chcb0vXAeuJjhnXvfuW8YuAc+PHhzf5zvu/eee88dr1AoJCrZLiQq3JwAJ8AJcAKcgEh2kVPI8zydNu+Ae/Tsone7YIvY5DbE2mRVoTAYVg9egjXVZAg7YBzcEvFNQEAG+AzHizGhBrhcAprAgqHj51HT6m7cAlrADwHnA/6BnrgE1IGfgs4HnIE2XQEmYfQzaLAQEavAMj35pjkCL5hfcx88BfdBJ3gEFpl139iaQldoroY58InK14AR8Aq00rssU0TKhoDnjI59KvukyG+v6bcvjHZmbQjYZnScDUa/BNXgMaOdPyApuYjbaC6H2XX6+qWsFhww2rkE+iQX8bBAmDyiLt8xy2ckRyAtECY7wG3wjFk+JXYahbVHdP4h7dy/NepclRQQJW8YAyu0e9dq1PMkHds3dP4YTFN00t29fUkBG4YC5uk5ZFD3QFLAuqEAdUzO0eLVNVafHifjopTyG2iOMd2tg2++5OLMGTixQOnjd816H7hrQOco0WSweV2juqOa9dK2EppJTUfmQD9Y0qjzUefj6qyBIDZ/BTctzftTGulD7rWK7galWhywuHAHA+dtZWSBPQB/hXPi4bivVbrBnoDjPq2TslxsJcFMBOffgxvlvpkLjttTIM9w+gS85SQsNqJQmF0GvSRIRapGep+nnVxd7K6CX1KXu577m9UJcAKcACfACahk+y/AAC3f2jjlL560AAAAAElFTkSuQmCC" alt="Aide" /></a>
				<div id="help_panel">
          <div class="content">
            <h2>Aide</h2>
            <?php include($runPlugin->getHelpTemplate()); ?>
          </div>
				</div>
				<?php } ?>
			  <h2><?php echo $runPlugin->getInfoVal('name'); ?></h2>