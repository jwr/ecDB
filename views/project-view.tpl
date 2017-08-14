{extends file='layout.tpl'}

{block name=title}Viewing project - {$project.project_name} - ecDB{/block}

{block name=head}
    <script type="text/javascript" src="include/autocomplete/jquery.autocomplete.js"></script>
    <link rel="stylesheet" type="text/css" href="include/autocomplete/jquery.autocomplete.css" />
    <script type="text/javascript">
        $().ready(function() {
            $("#name").autocomplete("include/autocomplete/autocomplete_name_owner.php?memberID=<?php echo $_SESSION['SESS_MEMBER_ID'] ?>", {
                width: 150,
                matchContains: true,
                minChars: 2,
                selectFirst: false,
            });
        });
    </script>
{/block}

{block name=body}
    <h1>
        Viewing project
        <strong>
            {if $project.project_url}
                <a href="{$project.project_url|escape:'html'}" target="_blank">{$project.project_name}</a>
            {else}
                {$project.project_name}
            {/if}
        </strong>
    </h1>

    <table class="globalTables" cellpadding="0" cellspacing="0">
        <thead>
        <tr>
            <th></th>
            <th>
                <a href="{$base_url}/project/{$project.project_id}?by=name&order={if $order=='asc'}desc{else}asc{/if}">Name</a>
            </th>
            <th>
                <a href="{$base_url}/project/{$project.project_id}?by=category&order={if $order=='asc'}desc{else}asc{/if}">Category</a>
            </th>
            <th>
                <a href="{$base_url}/project/{$project.project_id}?by=manufacturer&order={if $order=='asc'}desc{else}asc{/if}">Manufacturer</a>
            </th>
            <th>
                <a href="{$base_url}/project/{$project.project_id}?by=package&order={if $order=='asc'}desc{else}asc{/if}">Package</a>
            </th>
            <th>
                <a href="{$base_url}/project/{$project.project_id}?by=smd&order={if $order=='asc'}desc{else}asc{/if}">SMD</a>
            </th>
            <th>
                <a href="{$base_url}/project/{$project.project_id}?by=price&order={if $order=='asc'}desc{else}asc{/if}">Price</a>
            </th>
            <th>
                <a href="{$base_url}/project/{$project.project_id}?by=stock_quantity&order={if $order=='asc'}desc{else}asc{/if}">Quantity in stock</a>
            </th>
            <th>
                <a href="{$base_url}/project/{$project.project_id}?by=quantity&order={if $order=='asc'}desc{else}asc{/if}">Quantity in project</a>
            </th>
        </tr>
        </thead>
        <tbody>
        {foreach from=$components item=component}
            <tr>
                {if $smarty.session.SESS_MEMBER_ID}
                    <td class="edit">
                        <a href="{$base_url}/edit_component.php?edit={$component.id}"><span class="icon medium pencil"></span></a>
                    </td>
                    <td>
                        <a href="{$base_url}/edit_component.php?view={$component.id}">{$component.name}</a>
                    </td>
                {else}
                    <td class="edit"></td>
                    <td>{$component.name}</td>
                {/if}
                <td class='componentCol'>{$component.category} / {$component.subcategory}</td>
                <td>{if $component.manufacturer}{$component.manufacturer}{else}-{/if}</td>
                <td>{if $component.package}{$component.package}{else}-{/if}</td>
                <td><span class="icon medium {if $component.smd == 'No'}checkboxUnchecked{else}checkboxChecked{/if}"></span></td>
                <td class='priceCol'>{if $component.price}{$component.price}{else}-{/if}</td>
                <td>{if $component.quantity}{$component.quantity}{else}-{/if}</td>
                <td>{if $component.projects_data_quantity}{$component.projects_data_quantity}{else}-{/if}</td>
            </tr>
        {/foreach}
        </tbody>
    </table>

    <div class="totalSumWrapper">
        {if !$price.total}
            0 {$price.currency}
        {else}
            {$price.total} {$price.currency}
        {/if}
    </div>
{/block}
