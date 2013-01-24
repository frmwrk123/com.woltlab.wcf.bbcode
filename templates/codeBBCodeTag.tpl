<div class="container containerPadding codeBox {$highlighter|get_class|substr:30|lcfirst}">
	<hgroup>
		<h1>{@$highlighter->getTitle()}{if $filename}: {@$filename}{/if}</h1>
	</hgroup>
	
	<div>
		<ol start="{$startLineNumber}" style="list-style-type: decimal;">
			{foreach from=$content item=line}
				<li style="white-space: pre; font-family: monospace;">{@$line}</li>
			{/foreach}
		</ol>
	</div>
</div>
