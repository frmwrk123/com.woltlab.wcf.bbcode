{include file='header'}
{capture assign='attributeTemplate'}
	<fieldset>
		<legend><img src="{@RELATIVE_WCF_DIR}icon/delete1.svg" alt="" class="deleteButton" />{lang}wcf.acp.bbcode.attribute{/lang} {ldelim}#$attributeNo}</legend>
		<dl>
			<dt><label for="attributes[{ldelim}@$attributeNo}][attributeHtml]">{lang}wcf.acp.bbcode.attribute.attributeHtml{/lang}</label></dt>
			<dd>
				<input type="text" id="attributes[{ldelim}@$attributeNo}][attributeHtml]" name="attributes[{ldelim}@$attributeNo}][attributeHtml]" value="" class="long" />
			</dd>
		</dl>
		
		<dl>
			<dt><label for="attributes[{ldelim}@$attributeNo}][attributeText]">{lang}wcf.acp.bbcode.attribute.attributeText{/lang}</label></dt>
			<dd>
				<input type="text" id="attributes[{ldelim}@$attributeNo}][attributeText]" name="attributes[{ldelim}@$attributeNo}][attributeText]" value="" class="long" />
			</dd>
		</dl>
		
		<dl>
			<dt><label for="attributes[{ldelim}@$attributeNo}][validationPattern]">{lang}wcf.acp.bbcode.attribute.validationPattern{/lang}</label></dt>
			<dd>
				<input type="text" id="attributes[{ldelim}@$attributeNo}][validationPattern]" name="attributes[{ldelim}@$attributeNo}][validationPattern]" value="" class="long" />
			</dd>
		</dl>
		
		<dl>
			<dt class="reversed"><label for="attributes[{ldelim}@$attributeNo}][required]">{lang}{lang}wcf.acp.bbcode.attribute.required{/lang}{/lang}</label></dt>
			<dd>
				<input type="checkbox" id="attributes[{ldelim}@$attributeNo}][required]" name="attributes[{ldelim}@$attributeNo}][required]" value="1" />
			</dd>
		</dl>
		
		<dl>
			<dt class="reversed"><label for="attributes[{ldelim}@$attributeNo}][useText]">{lang}{lang}wcf.acp.bbcode.attribute.useText{/lang}{/lang}</label></dt>
			<dd>
				<input type="checkbox" id="attributes[{ldelim}@$attributeNo}][useText]" name="attributes[{ldelim}@$attributeNo}][useText]" value="1" />
				<small>{lang}wcf.acp.bbcode.attribute.useText.description{/lang}</small>
			</dd>
		</dl>
	</fieldset>
{/capture}
<script type="text/javascript">
//<![CDATA[
	$(function() {
		$('.deleteButton').click(function (event) {
			$(event.target).parent().parent().remove();
		});
		
		var attributeNo = {if !$attributes|count}0{else}{assign var='lastAttribute' value=$attributes|end}{$lastAttribute->attributeNo+1}{/if};
		var attributeTemplate = new WCF.Template('{@$attributeTemplate|encodeJS}');
		
		$('.addButton').click(function (event) {
			html = $(attributeTemplate.fetch({ attributeNo: attributeNo++ }));
			html.find('.deleteButton').click(function (event) {
				$(event.target).parent().parent().remove();
			});
			$('#attributeFieldset').append(html);
		});
	});
//]]>
</script>

<header class="wcf-mainHeading">
	<img src="{@RELATIVE_WCF_DIR}icon/{$action}1.svg" alt="" />
	<hgroup>
		<h1>{lang}wcf.acp.bbcode.{$action}{/lang}</h1>
	</hgroup>
</header>

{if $errorField}
	<p class="wcf-error">{lang}wcf.global.form.error{/lang}</p>
{/if}

{if $success|isset}
	<p class="wcf-success">{lang}wcf.global.form.{$action}.success{/lang}</p>	
{/if}

<div class="wcf-contentHeader">
	<nav>
		<ul class="largeButtons">
			<li><a href="{link controller='BBCodeList'}{/link}" title="{lang}wcf.acp.menu.link.bbcode.list{/lang}" class="button"><img src="{@RELATIVE_WCF_DIR}icon/bbCode1.svg" alt="" /> <span>{lang}wcf.acp.menu.link.bbcode.list{/lang}</span></a></li>
		</ul>
	</nav>
</div>

<form method="post" action="{if $action == 'add'}{link controller='BBCodeAdd'}{/link}{else}{link controller='BBCodeEdit'}{/link}{/if}">
	<div class="wcf-border wcf-content">
		<fieldset>
			<legend>{lang}wcf.acp.bbcode.data{/lang}</legend>
			
			<dl{if $errorField == 'bbcodeTag'} class="formError"{/if}>
				<dt><label for="bbcodeTag">{lang}wcf.acp.bbcode.bbcodeTag{/lang}</label></dt>
				<dd>
					<input type="text" id="bbcodeTag" name="bbcodeTag" value="{$bbcodeTag}" required="required" autofocus="autofocus" pattern="^[a-zA-Z0-9]+$" class="medium" />
					{if $errorField == 'bbcodeTag'}
						<small class="wcf-innerError">
							{if $errorType == 'empty'}
								{lang}wcf.global.form.error.empty{/lang}
							{elseif $errorType == 'invalid'}
								{lang}wcf.acp.bbcode.error.bbcodeTag.invalid{/lang}
							{elseif $errorType == 'inUse'}
								{lang}wcf.acp.bbcode.error.bbcodeTag.inUse{/lang}
							{/if}
						</small>
					{/if}
				</dd>
			</dl>
			
			<dl{if $errorField == 'htmlOpen'} class="formError"{/if}>
				<dt><label for="htmlOpen">{lang}wcf.acp.bbcode.htmlOpen{/lang}</label></dt>
				<dd>
					<input type="text" id="htmlOpen" name="htmlOpen" value="{$htmlOpen}" class="long" />
				</dd>
			</dl>
			
			<dl{if $errorField == 'htmlClose'} class="formError"{/if}>
				<dt><label for="htmlClose">{lang}wcf.acp.bbcode.htmlClose{/lang}</label></dt>
				<dd>
					<input type="text" id="htmlClose" name="htmlClose" value="{$htmlClose}" class="long" />
				</dd>
			</dl>
			
			<dl{if $errorField == 'textOpen'} class="formError"{/if}>
				<dt><label for="textOpen">{lang}wcf.acp.bbcode.textOpen{/lang}</label></dt>
				<dd>
					<input type="text" id="textOpen" name="textOpen" value="{$textOpen}" class="long" />
				</dd>
			</dl>
			
			<dl{if $errorField == 'textClose'} class="formError"{/if}>
				<dt><label for="textClose">{lang}wcf.acp.bbcode.textClose{/lang}</label></dt>
				<dd>
					<input type="text" id="textClose" name="textClose" value="{$textClose}" class="long" />
				</dd>
			</dl>
			
			<dl{if $errorField == 'allowedChildren'} class="formError"{/if}>
				<dt><label for="allowedChildren">{lang}wcf.acp.bbcode.allowedChildren{/lang}</label></dt>
				<dd>
					<input type="text" id="allowedChildren" name="allowedChildren" value="{$allowedChildren}" class="long" required="required" pattern="^((all|none)\^)?([a-zA-Z0-9]+,?)*[a-zA-Z0-9]+$" />
					{if $errorField == 'allowedChildren'}
						<small class="wcf-innerError">
							{if $errorType == 'empty'}
								{lang}wcf.global.form.error.empty{/lang}
							{elseif $errorType == 'invalid'}
								{lang}wcf.acp.bbcode.error.allowedChildren.invalid{/lang}
							{/if}
						</small>
					{/if}
				</dd>
			</dl>
			
			<dl{if $errorField == 'isSourceCode'} class="formError"{/if}>
				<dt class="reversed"><label for="isSourceCode">{lang}wcf.acp.bbcode.isSourceCode{/lang}</label></dt>
				<dd>
					<input type="checkbox" id="isSourceCode" name="isSourceCode" value="1"{if $isSourceCode} checked="checked"{/if} />
					<small>{lang}wcf.acp.bbcode.isSourceCode.description{/lang}</small>
				</dd>
			</dl>
			
			<dl{if $errorField == 'className'} class="formError"{/if}>
				<dt><label for="className">{lang}wcf.acp.bbcode.className{/lang}</label></dt>
				<dd>
					<input type="text" id="className" name="className" value="{$className}" class="long" pattern="^\\?([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*\\)*[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$" />
					{if $errorField == 'className'}
						<small class="wcf-innerError">
							{if $errorType == 'notFound'}
								{lang}wcf.acp.bbcode.error.className.notFound{/lang}
							{/if}
						</small>
					{/if}
				</dd>
			</dl>
		</fieldset>
		
		<fieldset id="attributeFieldset">
			<legend><img src="{@RELATIVE_WCF_DIR}icon/add1.svg" alt="" title="{lang}wcf.global.button.add{/lang}" class="addButton" /> {lang}wcf.acp.bbcode.attributes{/lang}</legend>
			
			{foreach from=$attributes item='attribute'}
				<fieldset>
					<legend><img src="{@RELATIVE_WCF_DIR}icon/delete1.svg" alt="" title="{lang}wcf.global.button.delete{/lang}" class="deleteButton" />{lang}wcf.acp.bbcode.attribute{/lang} {#$attribute->attributeNo}</legend>
					<dl{if $errorField == 'attributeHtml'|concat:$attribute->attributeNo} class="formError"{/if}>
						<dt><label for="attributes[{@$attribute->attributeNo}][attributeHtml]">{lang}wcf.acp.bbcode.attribute.attributeHtml{/lang}</label></dt>
						<dd>
							<input type="text" id="attributes[{@$attribute->attributeNo}][attributeHtml]" name="attributes[{@$attribute->attributeNo}][attributeHtml]" value="{$attribute->attributeHtml}" class="long" />
						</dd>
					</dl>
					
					<dl{if $errorField == 'attributeText'|concat:$attribute->attributeNo} class="formError"{/if}>
						<dt><label for="attributes[{@$attribute->attributeNo}][attributeText]">{lang}wcf.acp.bbcode.attribute.attributeText{/lang}</label></dt>
						<dd>
							<input type="text" id="attributes[{@$attribute->attributeNo}][attributeText]" name="attributes[{@$attribute->attributeNo}][attributeText]" value="{$attribute->attributeText}" class="long" />
						</dd>
					</dl>
					
					<dl{if $errorField == 'attributeValidationPattern'|concat:$attribute->attributeNo} class="formError"{/if}>
						<dt><label for="attributes[{@$attribute->attributeNo}][validationPattern]">{lang}wcf.acp.bbcode.attribute.validationPattern{/lang}</label></dt>
						<dd>
							<input type="text" id="attributes[{@$attribute->attributeNo}][validationPattern]" name="attributes[{@$attribute->attributeNo}][validationPattern]" value="{$attribute->validationPattern}" class="long" />
							{if $errorField == 'attributeValidationPattern'|concat:$attribute->attributeNo}
								<small class="innerError">
									{if $errorType == 'invalid'}
										{lang}wcf.acp.bbcode.attribute.error.validationPattern.invalid{/lang}
									{/if}
								</small>
							{/if}
						</dd>
					</dl>
					
					<dl{if $errorField == 'attributeRequired'|concat:$attribute->attributeNo} class="formError"{/if}>
						<dt class="reversed"><label for="attributes[{@$attribute->attributeNo}][required]">{lang}wcf.acp.bbcode.attribute.required{/lang}</label></dt>
						<dd>
							<input type="checkbox" id="attributes[{@$attribute->attributeNo}][required]" name="attributes[{@$attribute->attributeNo}][required]" value="1"{if $attribute->required} checked="checked"{/if} />
						</dd>
					</dl>
					
					<dl{if $errorField == 'attributeUseText'|concat:$attribute->attributeNo} class="formError"{/if}>
						<dt class="reversed"><label for="attributes[{@$attribute->attributeNo}][useText]">{lang}wcf.acp.bbcode.attribute.useText{/lang}</label></dt>
						<dd>
							<input type="checkbox" id="attributes[{@$attribute->attributeNo}][useText]" name="attributes[{@$attribute->attributeNo}][useText]" value="1"{if $attribute->useText} checked="checked"{/if} />
							<small>{lang}wcf.acp.bbcode.attribute.useText.description{/lang}</small>
						</dd>
					</dl>
				</fieldset>
			{/foreach}
		</fieldset>
	</div>
	
	<div class="formSubmit">
		<input type="reset" value="{lang}wcf.global.button.reset{/lang}" accesskey="r" />
		<input type="submit" value="{lang}wcf.global.button.submit{/lang}" accesskey="s" />
		{@SID_INPUT_TAG}
 		{if $bbcodeID|isset}<input type="hidden" name="id" value="{@$bbcodeID}" />{/if}
	</div>
</form>

{include file='footer'}