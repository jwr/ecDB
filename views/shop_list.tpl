{extends file='layout.tpl'}

{block name=title}Shopping list - ecDB{/block}

{block name=head}{/block}

{block name=body}
    <table class="globalTables" cellpadding="0" cellspacing="0">
        <thead>
        <tr>
            <th></th>
            <th>
                <a href="{$base_url}/shoplist?by=name&order={if $order == 'asc'}desc{else}asc{/if}">Name</a>
            </th>
            <th>
                <a href="{$base_url}/shoplist?by=manufacturer&order={if $order == 'asc'}desc{else}asc{/if}">Manufacturer</a>
            </th>
            <th>
                <a href="{$base_url}/shoplist?by=package&order={if $order == 'asc'}desc{else}asc{/if}">Package</a>
            </th>
            <th>
                <a href="{$base_url}/shoplist?by=smd&order={if $order == 'asc'}desc{else}asc{/if}">SMD</a>
            </th>
            <th>
                <a href="{$base_url}/shoplist?by=price&order={if $order == 'asc'}desc{else}asc{/if}">Price</a>
            </th>
            <th>
                <a href="{$base_url}/shoplist?by=quantity&order={if $order == 'asc'}desc{else}asc{/if}">Quantity</a>
            </th>
            <th>
                <a href="{$base_url}/shoplist?by=quantity_order&order={if $order == 'asc'}desc{else}asc{/if}">Quantity to order</a>
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
                    <a href="{$base_url}/edit_component.php?edit={$component.id}"><span class="icon medium pencil"></span></a>
                </td>
                <td>
                    <a href="{$base_url}/component.php?view={$component.id}">{$component.name}</a>
                </td>
                <td>{$component.manufacturer|default:'-'}</td>
                <td>{$component.package|default:'-'}</td>
                <td>
                    {if $component.smd == 'No'}
                        <span class="icon medium checkboxUnchecked"></span>
                    {else}
                        <span class="icon medium checkboxChecked"></span>
                    {/if}
                </td>
                <td>{$component.price|default:'-'}</td>
                <td>{$component.quantity|default:'-'}</td>
                <td>{$component.order_quantity|default:'-'}</td>
                <td class="comment">
                    <div>
                    {if $component.comment == ''}
                        <span>-</span>
                    {else}
                    <span class="icon medium spechBubbleSq"></span>
                    <span class="comment">
                        {$component.comment}
                    </span>
                    {/if}
                    </div>
                </td>
            </tr>
        {/foreach}
        </tbody>
    </table>
    <div class="totalSumWrapper">
        {$total_price} {$currency}
    </div>

{/block}