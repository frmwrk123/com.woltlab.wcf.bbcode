{include file='header'}

<header class="mainHeading">
	<img src="{@RELATIVE_WCF_DIR}icon/{$action}1.svg" alt="" />
	<hgroup>
		<h1>{lang}wcf.acp.bbcode.videoprovider.{$action}{/lang}</h1>
		<h2>{lang}wcf.acp.bbcode.videoprovider.subtitle{/lang}</h2>
	</hgroup>
</header>

{if $errorField}
	<p class="error">{lang}wcf.global.form.error{/lang}</p>
{/if}

{if $success|isset}
	<p class="success">{lang}wcf.global.form.{$action}.success{/lang}</p>	
{/if}

<div class="contentHeader">
	<nav>
		<ul class="largeButtons">
			<li><a href="{link controller='BBCodeVideoProviderList'}{/link}" title="{lang}wcf.acp.menu.link.bbcode.videoprovider.list{/lang}"><img src="{@RELATIVE_WCF_DIR}icon/bbcode1.svg" alt="" /> <span>{lang}wcf.acp.menu.link.bbcode.videoprovider.list{/lang}</span></a></li>
		</ul>
	</nav>
</div>

<form method="post" action="{if $action == 'add'}{link controller='BBCodeVideoProviderAdd'}{/link}{else}{link controller='BBCodeVideoProviderEdit'}{/link}{/if}">
	<div class="border content">
		<fieldset>
			<legend>{lang}wcf.acp.bbcode.videoprovider.data{/lang}</legend>
			
			<dl{if $errorField == 'regex'} class="formError"{/if}>
				<dt><label for="regex">{lang}wcf.acp.bbcode.videoprovider.regex{/lang}</label></dt>
				<dd>
					<textarea id="regex" name="regex" cols="40" rows="10">{$regex}</textarea>
					<small>{lang}wcf.acp.bbcode.videoprovider.regex.description{/lang}</small>
					{if $errorField == 'regex'}
						<small class="innerError">
							{if $errorType == 'empty'}
								{lang}wcf.global.form.error.empty{/lang}
							{elseif $errorType == 'invalid'}
								{lang}wcf.acp.bbcode.videoprovider.error.regex.invalid{/lang}
							{/if}
						</small>
					{/if}
				</dd>
			</dl>
			
			<dl{if $errorField == 'html'} class="formError"{/if}>
				<dt><label for="html">{lang}wcf.acp.bbcode.videoprovider.html{/lang}</label></dt>
				<dd>
					<textarea id="html" name="html" cols="40" rows="10">{$html}</textarea>
					<small>{lang}wcf.acp.bbcode.videoprovider.html.description{/lang}</small>
					{if $errorField == 'html'}
						<small class="innerError">
							{if $errorType == 'empty'}
								{lang}wcf.global.form.error.empty{/lang}
							{/if}
						</small>
					{/if}
				</dd>
			</dl>
		</fieldset>
	</div>
	
	<div class="formSubmit">
		<input type="reset" value="{lang}wcf.global.button.reset{/lang}" accesskey="r" />
		<input type="submit" value="{lang}wcf.global.button.submit{/lang}" accesskey="s" />
		{@SID_INPUT_TAG}
 		{if $providerID|isset}<input type="hidden" name="id" value="{@$providerID}" />{/if}
	</div>
</form>

{include file='footer'}