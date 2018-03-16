<?php
defined('ROOT') OR exit('No direct script access allowed');
include_once(THEMES.$core->getConfigVal('theme').'/functions.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<?php eval($core->callHook('frontHead')); ?>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?php show::titleTag(); ?></title>
	<base href="<?php show::siteUrl(); ?>/" />
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1" />
	<meta name="description" content="<?php show::metaDescriptionTag(); ?>" />
	<link rel="icon" href="data:image/gif;base64,R0lGODlhQABAALMAAENKWU5XaDlATTA1QFVfc0tUZTM5RDY8SUBHVVBZbFNcb0hQYT1DUUVNXVhidiwxOyH/C1hNUCBEYXRhWE1QPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4gPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNS4zLWMwMTEgNjYuMTQ1NjYxLCAyMDEyLzAyLzA2LTE0OjU2OjI3ICAgICAgICAiPiA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPiA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIiB4bWxuczpzdFJlZj0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3NUeXBlL1Jlc291cmNlUmVmIyIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ1M2IChXaW5kb3dzKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpDMDA4QzM0QkQ0MUMxMUU1OEVGMzhGN0Y5QzUyNThGRiIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDpDMDA4QzM0Q0Q0MUMxMUU1OEVGMzhGN0Y5QzUyNThGRiI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOkMwMDhDMzQ5RDQxQzExRTU4RUYzOEY3RjlDNTI1OEZGIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOkMwMDhDMzRBRDQxQzExRTU4RUYzOEY3RjlDNTI1OEZGIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+Af/+/fz7+vn49/b19PPy8fDv7u3s6+rp6Ofm5eTj4uHg397d3Nva2djX1tXU09LR0M/OzczLysnIx8bFxMPCwcC/vr28u7q5uLe2tbSzsrGwr66trKuqqainpqWko6KhoJ+enZybmpmYl5aVlJOSkZCPjo2Mi4qJiIeGhYSDgoGAf359fHt6eXh3dnV0c3JxcG9ubWxramloZ2ZlZGNiYWBfXl1cW1pZWFdWVVRTUlFQT05NTEtKSUhHRkVEQ0JBQD8+PTw7Ojk4NzY1NDMyMTAvLi0sKyopKCcmJSQjIiEgHx4dHBsaGRgXFhUUExIREA8ODQwLCgkIBwYFBAMCAQAAIfkEAAAAAAAsAAAAAEAAQAAABP/wyUmrvTjrzbv/YCiOZGmeaKqubOu+cCwLtCCfwuLsfIDcogZvyFPYgJxBgsjc/ZCaAjEBADQUxAMUAxgSGBUGobi1DMY7gtZyQDueZUmXB+byCp7aEYXdBTQDQxs5TD4mBkNwGAE8axdCTTtGJHM7HIw7exRKkUSKHzp+lzwAF1JDVFZ9jSKYDqUbrrAUlQ5fYW4KraQcQ7MSZzxqF208n6M7v8RDmg+1dReVeCCyG5CZFat/GYE8IacO0xjBPAYUiMaxrB8IQ+Z2grTxGq7NG+QO2xYCRPoSofmQvQpRq8CACgjc7GhQoZq6ZCE4DVkAQACAJUygSXCowZcIiZ34iBykwBHDAWYjBgBkUgBcAgslH6EkYWDBqnAC8Cl7AE7cBXwO3h2iMaFdOQtGdwi1UMvBi1U+J+DzR4HfEKopkjqwJ2eIQYQKHTBkMUAbN4w8KFpEO0SjBgOONKzkKpVtyB0jOQC4pUHrWEAribTk8dLDqQJL5RHOu6HmzQI53ezMQGQBg5EDENwcFsIAUQlaE2cwEDYk5xNQQRhwFTJB3BJa6WoQwJoIAQCMS5TtUeIAANYBcHOA22FuHDl8M/g9LuGw6K6LmT+ofBmYZi+vt5C+i126hNXcHbj2XrW2F+HkK/gGjj69+/fw48ufT7++/fv48+uXEQEAOw==" />
	<?php show::linkTags(); ?>
	<?php show::scriptTags(); ?>
	<?php eval($core->callHook('endFrontHead')); ?>
</head>
<body>
<div id="container">
	<div id="header">
		<div id="header_content">
			<div id="mobile_menu"></div>
			<p id="siteName"><a href="<?php show::siteUrl(); ?>"><?php show::siteName(); ?></a></p>
			<ul id="navigation">
				<?php show::mainNavigation(); ?>
			</ul>
		</div>
	</div>
	<div id="banner"></div>
	<div id="body">
		<div id="content" class="<?php show::pluginId(); ?>">
			<?php show::mainTitle(); ?>