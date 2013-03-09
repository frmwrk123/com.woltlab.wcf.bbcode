{include file='header' pageTitle='wcf.acp.bbcode.mediaProvider.list'}

<header class="boxHeadline">
	<hgroup>
		<h1>{lang}wcf.acp.bbcode.mediaProvider.list{/lang}</h1>
	</hgroup>
	
	<script type="text/javascript">
		//<![CDATA[
		$(function() {
			new WCF.Action.Delete('wcf\\data\\bbcode\\media\\provider\\BBCodeMediaProviderAction', '.jsMediaProviderRow');
		});
		//]]>
	</script>
</header>

<div class="contentNavigation">
	{pages print=true assign=pagesLinks controller="BBCodeMediaProviderList" link="pageNo=%d&sortField=$sortField&sortOrder=$sortOrder"}
	
	{if $__wcf->session->getPermission('admin.content.bbcode.canAddBBCodeMediaProvider')}
		<nav>
			<ul>
				<li><a href="{link controller='BBCodeMediaProviderAdd'}{/link}" title="{lang}wcf.acp.bbcode.mediaProvider.add{/lang}" class="button"><span class="icon icon16 icon-plus"></span> <span>{lang}wcf.acp.bbcode.mediaProvider.add{/lang}</span></a></li>
			</ul>
		</nav>
	{/if}
</div>

{hascontent}
	<div class="tabularBox tabularBoxTitle marginTop">
		<hgroup>
			<h1>{lang}wcf.acp.bbcode.mediaProvider.list{/lang} <span class="badge badgeInverse" title="{lang}wcf.acp.bbcode.mediaProvider.list.count{/lang}">{#$items}</span></h1>
		</hgroup>
		
		<table class="table">
			<thead>
				<tr>
					<th class="columnID columnMediaProviderID{if $sortField == 'providerID'} active {@$sortOrder}{/if}" colspan="2"><a href="{link controller='BBCodeMediaProviderList'}pageNo={@$pageNo}&sortField=providerID&sortOrder={if $sortField == 'providerID' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{/link}">{lang}wcf.global.objectID{/lang}</a></th>
					<th class="columnTitle columnMediaProviderTitle{if $sortField == 'title'} active {@$sortOrder}{/if}"><a href="{link controller='BBCodeMediaProviderList'}pageNo={@$pageNo}&sortField=title&sortOrder={if $sortField == 'title' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{/link}">{lang}wcf.acp.bbcode.mediaProvider.title{/lang}</a></th>
					
					{event name='headColumns'}
				</tr>
			</thead>
			
			<tbody>
				{content}
					{foreach from=$objects item='mediaProvider'}
						<tr class="jsMediaProviderRow">
							<td class="columnIcon">
								{if $__wcf->session->getPermission('admin.content.bbcode.canEditBBCodeMediaProvider')}
									<a href="{link controller='BBCodeMediaProviderEdit' id=$mediaProvider->providerID}{/link}" title="{lang}wcf.global.button.edit{/lang}" class="jsTooltip"><span class="icon icon16 icon-pencil"></span></a>
								{/if}
								{if $__wcf->session->getPermission('admin.content.bbcode.canDeleteBBCodeMediaProvider')}
									<span class="icon icon16 icon-remove jsDeleteButton jsTooltip" title="{lang}wcf.global.button.delete{/lang}" data-object-id="{@$mediaProvider->providerID}" data-confirm-message="{lang}wcf.acp.bbcode.mediaProvider.delete.sure{/lang}"></span>
								{/if}
								
								{event name='buttons'}
							</td>
							<td class="columnID"><p>{@$mediaProvider->providerID}</p></td>
							<td class="columnTitle columnMediaProviderTitle">
								{if $__wcf->session->getPermission('admin.content.bbcode.canEditBBCodeMediaProvider')}
									<p><a href="{link controller='BBCodeMediaProviderEdit' id=$mediaProvider->providerID}{/link}">{$mediaProvider->title}</a></p>
								{else}
									<p>{$mediaProvider->title}</p>
								{/if}
							</td>
							
							{event name='columns'}
						</tr>
					{/foreach}
				{/content}
			</tbody>
		</table>
	</div>
	
	<div class="contentNavigation">
		{@$pagesLinks}
		
		{if $__wcf->session->getPermission('admin.content.bbcode.canAddBBCodeMediaProvider')}
			<nav>
				<ul>
					<li><a href="{link controller='BBCodeMediaProviderAdd'}{/link}" title="{lang}wcf.acp.bbcode.mediaProvider.add{/lang}" class="button"><span class="icon icon16 icon-plus"></span> <span>{lang}wcf.acp.bbcode.mediaProvider.add{/lang}</span></a></li>
				</ul>
			</nav>
		{/if}
	</div>
{hascontentelse}
	<div class="container containerPadding">
		<div>
			<p class="warning">{lang}wcf.acp.bbcode.mediaProvider.noneAvailable{/lang}</p>
		</div>
	</div>
{/hascontent}

{include file='footer'}
