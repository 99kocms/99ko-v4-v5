	</div>
	<div id="footer">
	</div>
</div>
<script type="text/javascript">
function openPlugins(){
	var obj = document.getElementById('pluginsList');
	obj.style.display = 'block';
}
function closePlugins(){
	var obj = document.getElementById('pluginsList');
	obj.style.display = 'none';
}
function openConfig(){
	var obj = document.getElementById('configForm');
	obj.style.display = 'block';
}
function closeConfig(){
	var obj = document.getElementById('configForm');
	obj.style.display = 'none';
}
<?php if($data['openTab']){ ?>open<?php echo $data['openTab']; ?>();<?php } ?>
</script>
<?php eval(callHook('endAdminBody')); ?>
</body>
</html>
