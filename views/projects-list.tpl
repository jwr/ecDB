{extends file='layout.tpl'}

{block name=title}Your Projects - ecDB{/block}

{block name=head}{/block}

{block name=body}
    <!-- Main content -->

    {if $smarty.session.SESS_MEMBER_ID}

        <form class="globalForms" method="post" action="{$base_url}/project_add">
            <div class="textInput">
                <label class="keyWord">Project name</label>
                <div class="input"><input name="name" id="name" type="text" class="medium" /></div>
            </div>
            <div class="buttons">
                <div class="input">
                    <button class="button green" name="submit" type="submit"><span class="icon medium save"></span> Add project</button>
                </div>
            </div>
        </form>
        <hr>
    {/if}

    <table class="globalTables" cellpadding="0" cellspacing="0">
        <thead>
        <tr>
            <th></th>
            <th><a href="{$base_url}/proj_list?by=name&order={if $order == 'desc'}asc{else}desc{/if}">Name</a>
            </th>
            <th>Number of Components</th>
            <th>Total cost</th>
        </tr>
        </thead>
        <tbody>
        {foreach from=$projects item=project}
            <tr>
                {if $smarty.session.SESS_MEMBER_ID}
                    <td class="edit"><a href="{$base_url}/project/{$project.project_id}/edit"><span class="icon medium pencil"></span></a></td>
                {else}
                    <td></td>
                {/if}
                <td><a href="{$base_url}/project/{$project.project_id}">{$project.project_name}</a></td>
                <td>{$project.qty|default:'-'}</td>
                <td>
                    {if $project.total_price}
                        {$project.total_price} {$project.currency|default:'-'}
                    {else}
                        -
                    {/if}
                </td>
            </tr>
        {/foreach}
        </tbody>
    </table>
    <!-- END -->
{/block}