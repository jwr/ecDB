{extends file='layout.tpl'}

{block name=title}Home - ecDB{/block}

{block name=head}{/block}

{block name=body}

    <!-- Main content -->
    <div class="subMenu">
        <ul>
            <li><a href="{$base_url}/" class="{if !$category_id && !$sub_category_id}selected{else}isComponents{/if}">All</a></li>
            {foreach from=$categories item=category}
                <li><a href="{$base_url}/category?cat={$category.id}" class="{if $category_id == $category.id}selected{elseif $category.elements > 0}isComponents{/if}">{$category.name}</a></li>
            {/foreach}
        </ul>
    </div>
    {if $sub_categories}
        <div class="subSubMenu">
            <ul>
                {foreach from=$sub_categories item=sub_category}
                    <li>
                        <a href="{$base_url}/category?subcat={$sub_category.id}" class="{if $sub_category_id == $sub_category.id}selected{elseif $sub_category.elements > 0}isComponents{/if}">
                            {$sub_category.name}
                        </a>
                    </li>
                {/foreach}
            </ul>
        </div>
    {/if}


    <table class="globalTables" cellpadding="0" cellspacing="0">
        {assign var="filter_params" value=""}
        {if $smarty.get.cat}
            {assign var="filter_params" value=$filter_params|cat:'&cat='|cat:$smarty.get.cat}
        {/if}
        {if $smarty.get.subcat}
            {assign var="filter_params" value=$filter_params|cat:'&subcat='|cat:$smarty.get.subcat}
        {/if}
            <thead>
            <tr>
                <th>
                </th>
                <th>
                    <a href="{$base_url}/?by=name&order={if $order == 'asc'}desc{else}asc{/if}{$filter_params}">Name</a>
                </th>
                <th>
                    <a href="{$base_url}/?by=category&order={if $order == 'asc'}desc{else}asc{/if}{$filter_params}">Category</a>
                </th>
                <th>
                    <a href="{$base_url}/?by=package&order={if $order == 'asc'}desc{else}asc{/if}{$filter_params}">Package</a>
                </th>
                <th>
                    <a href="{$base_url}/?by=pins&order={if $order == 'asc'}desc{else}asc{/if}{$filter_params}">Pins</a>
                </th>
                <th>
                    Image
                </th>
                <th>
                    Datasheet
                </th>
                <th>
                    <a href="{$base_url}/?by=smd&order={if $order == 'asc'}desc{else}asc{/if}{$filter_params}">SMD</a>
                </th>
                <th>
                    <a href="{$base_url}/?by=price&order={if $order == 'asc'}desc{else}asc{/if}{$filter_params}">Price</a>
                </th>
                <th>
                    <a href="{$base_url}/?by=quantity&order={if $order == 'asc'}desc{else}asc{/if}{$filter_params}">Quantity</a>
                </th>
                <th>
                    Comment
                </th>
            </tr>
            </thead>
            <tbody>
                {foreach from=$components item=component}
                    <tr>
                        <td class="edit">
                            <a href="{$base_url}/component/{$component.id}/edit"><span class="icon medium pencil"></span></a>
                        </td>
                        <td><a href="{$base_url}/component/{$component.id}">{$component.name}</a></td>
                        <td class='componentCol'>
                            <a href='{$base_url}/category?subcat={$component.scid}'>{$component.nx} / {$component.snx}</a>
                        </td>
                        <td>{$component.package|default:'-'}</td>
                        <td>{$component.pins|default:'-'}</td>
                        <td>
                            {if $component.url1}
                                <a class="thumbnail" href="{$component.url1}">
                                    <span class="icon medium picture"></span>
                                    <span class="imgB">
                                        <img src="{$component.url1}" />
                                    </span>
                                </a>
                            {else}
                                -
                            {/if}
                        </td>
                        <td>
                            {if $component.datasheet}
                                <a href="{$component.datasheet}" target="_blank">
                                    <span class="icon medium document"></span>
                                </a>
                            {else}
                                -
                            {/if}
                        </td>
                        <td>
                            {if $component.smd == 'No'}
                                <span class="icon medium checkboxUnchecked"></span>
                            {else}
                                <span class="icon medium checkboxChecked"></span>
                            {/if}
                        </td>
                        <td class='priceCol'>{$component.price|default:'-'}</td>
                        <td>{$component.quantity|default:'-'}</td>
                        <td class="comment">
                            {if $component.comment}
                                <div>
                                    <span class="icon medium spechBubbleSq"></span>
                                    <span class="comment">{$component.comment|@nl2br}</span>
                                </div>
                            {else}
                                <div>-</div>
                            {/if}
                        </td>
                    </tr>
                {/foreach}
            </tbody>
        </table>
    <!-- END -->

{/block}