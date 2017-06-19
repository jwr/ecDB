{extends file='layout.tpl'}

{block name=title}Error - ecDB{/block}

{block name=head}{/block}

{block name=body}
    <div class="message red">
        {if $error_code == 1}
            You don't have permission to view this component.
        {elseif $error_code == 2}
            You don't have permission to edit this component.
        {elseif $error_code == 3}
            Oh crap! Something broke...
        {else}
            Error!
        {/if}
    </div>
{/block}