<div class="container containerPadding spoilerBox" id="{@$spoilerID}">
	<!-- begin:parser_nonessential -->
	<header class="javascriptOnly">
		<a class="button jsSpoilerToggle">{if $buttonTitle}{$buttonTitle}{else}{lang}wcf.bbcode.spoiler.show{/lang}{/if}</a>
	</header>
	<!-- end:parser_nonessential -->
	
	<div>
		{@$content}
	</div>
</div>

<!-- begin:parser_nonessential -->
<script type="text/javascript">
	//<![CDATA[
	$(function() {
		$('#{@$spoilerID} > div').hide();
		$('#{@$spoilerID} > header > .jsSpoilerToggle').click(function() {
			$(this).toggleClass('active');
			$('#{@$spoilerID} > div').slideToggle();
		});
	});
	//]]>
</script>
<!-- end:parser_nonessential -->