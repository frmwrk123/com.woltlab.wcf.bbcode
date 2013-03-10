{include file='header' pageTitle='wcf.acp.bbcode.list'}

<header class="boxHeadline">
	<hgroup>
		<h1>{lang}wcf.acp.bbcode.list{/lang}</h1>
	</hgroup>
	
	<script type="text/javascript">
		//<![CDATA[
		$(function() {
			new WCF.Action.Delete('wcf\\data\\bbcode\\BBCodeAction', '.jsBBCodeRow');
			new WCF.Action.Toggle('wcf\\data\\bbcode\\BBCodeAction', $('.jsBBCodeRow'));
		});
		//]]>
	</script>
</header>

<div class="contentNavigation">
	{pages print=true assign=pagesLinks controller="BBCodeList" link="pageNo=%d&sortField=$sortField&sortOrder=$sortOrder"}
	
	{if $__wcf->session->getPermission('admin.content.bbcode.canAddBBCode')}
		<nav>
			<ul>
				<li><a href="{link controller='BBCodeAdd'}{/link}" title="{lang}wcf.acp.bbcode.add{/lang}" class="button"><span class="icon icon16 icon-plus"></span> <span>{lang}wcf.acp.bbcode.add{/lang}</span></a></li>
			</ul>
		</nav>
	{/if}
</div>

{hascontent}
	<div class="tabularBox tabularBoxTitle marginTop">
		<hgroup>
			<h1>{lang}wcf.acp.bbcode.list{/lang} <span class="badge badgeInverse">{#$items}</span></h1>
		</hgroup>
		
		<table class="table">
			<thead>
				<tr>
					<th class="columnID columnBBCodeID{if $sortField == 'bbcodeID'} active {@$sortOrder}{/if}" colspan="2"><a href="{link controller='BBCodeList'}pageNo={@$pageNo}&sortField=bbcodeID&sortOrder={if $sortField == 'bbcodeID' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{/link}">{lang}wcf.global.objectID{/lang}</a></th>
					<th class="columnTitle columnBBCode{if $sortField == 'bbcodeTag'} active {@$sortOrder}{/if}"><a href="{link controller='BBCodeList'}pageNo={@$pageNo}&sortField=bbcodeTag&sortOrder={if $sortField == 'bbcodeTag' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{/link}">{lang}wcf.acp.bbcode.bbcodeTag{/lang}</a></th>
					<th class="columnText columnClassName{if $sortField == 'className'} active {@$sortOrder}{/if}"><a href="{link controller='BBCodeList'}pageNo={@$pageNo}&sortField=className&sortOrder={if $sortField == 'className' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{/link}">{lang}wcf.acp.bbcode.className{/lang}</a></th>
					
					{event name='headColumns'}
				</tr>
			</thead>
			
			<tbody>
				{content}
					{foreach from=$objects item=bbcode}
						<tr class="jsBBCodeRow">
							<td class="columnIcon">
								{* toggle, edit, delete *}
								{if $__wcf->session->getPermission('admin.content.bbcode.canEditBBCode')}
									<span class="icon icon16 icon-{if $bbcode->isDisabled}off{else}circle-blank{/if} jsToggleButton jsTooltip pointer" title="{lang}wcf.global.button.{if $bbcode->isDisabled}enable{else}disable{/if}{/lang}" data-object-id="{@$bbcode->bbcodeID}" data-disable-message="{lang}wcf.global.button.disable{/lang}" data-enable-message="{lang}wcf.global.button.enable{/lang}"></span>
								{else}
									{if $bbcode->isDisabled}
										<span class="icon icon16 icon-off disabled" title="{lang}wcf.global.button.enable{/lang}"></span>
									{else}
										<span class="icon icon16 icon-circle-blank disabled" title="{lang}wcf.global.button.disable{/lang}"></span>
									{/if}
								{/if}
								{if $__wcf->session->getPermission('admin.content.bbcode.canEditBBCode')}
									<a href="{link controller='BBCodeEdit' id=$bbcode->bbcodeID}{/link}" title="{lang}wcf.global.button.edit{/lang}" class="jsTooltip"><span class="icon icon16 icon-pencil"></span></a>
								{/if}
								{if $__wcf->session->getPermission('admin.content.bbcode.canDeleteBBCode')}
									<span class="icon icon16 icon-remove jsDeleteButton jsTooltip pointer" title="{lang}wcf.global.button.delete{/lang}" data-object-id="{@$bbcode->bbcodeID}" data-confirm-message="{lang}wcf.acp.bbcode.delete.sure{/lang}"></span>
								{/if}
								
								{event name='buttons'}
							</td>
							<td class="columnID"><p>{@$bbcode->bbcodeID}</p></td>
							<td class="columnTitle columnBBCode"><p>{if $__wcf->session->getPermission('admin.content.bbcode.canEditBBCode')}<a href="{link controller='BBCodeEdit' id=$bbcode->bbcodeID}{/link}">[{$bbcode->bbcodeTag}]</a>{else}[{$bbcode->bbcodeTag}]{/if}</p></td>
							<td class="columnText columnClassName"><p>{$bbcode->className}</p></td>
							
							{event name='columns'}
						</tr>
					{/foreach}
				{/content}
			</tbody>
		</table>
		
	</div>
	
	<div class="contentNavigation">
		{@$pagesLinks}
		
		{if $__wcf->session->getPermission('admin.content.bbcode.canAddBBCode')}
			<nav>
				<ul>
					<li><a href="{link controller='BBCodeAdd'}{/link}" title="{lang}wcf.acp.bbcode.add{/lang}" class="button"><span class="icon icon16 icon-plus"></span> <span>{lang}wcf.acp.bbcode.add{/lang}</span></a></li>
				</ul>
			</nav>
		{/if}
	</div>
{hascontentelse}
	<p class="info">{lang}wcf.acp.bbcode.noneAvailable{/lang}</p>
{/hascontent}

{include file='footer'}
