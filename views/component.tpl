{extends file='layout.tpl'}

{block name=title}View component - {$component.name} - ecDB{/block}

{block name=head}
    <script>
        function delete_component() {
            if (confirm('Delete component?')) {
                document.getElementById('form-delete').submit();
            }
        }
        function ajax_post(component_id, field, increase, callback) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '{$base_url}/ajax/change_component_count_field');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var data = xhr.responseText;
                    if (callback) {
                        var json = JSON.parse(data);
                        if (json.error) {
                            alert(json.error);
                            return;
                        }
                        callback(json);
                    }
                } else if (xhr.status !== 200) {
                    alert('Request failed.  Returned status of ' + xhr.status);
                }
            };
            var params = [];
            params.push(encodeURI('component_id=' + component_id));
            params.push(encodeURI('field=' + field));
            params.push(encodeURI('increase=' + (increase ? 1 : 0)));
            xhr.send(params.join('&'));
        }


        function increase(field, count_element_selector) {
            ajax_post({$component.id}, field, true, function (data) {
                document.querySelector(count_element_selector).innerText = data.data.value;
            });
        }
        function decrease(field, count_element_selector) {
            ajax_post({$component.id}, field, false, function (data) {
                document.querySelector(count_element_selector).innerText = data.data.value;
            });
        }
    </script>
{/block}

{block name=body}
    <h1>
        <a href="{$base_url}/category?cat={$category.category_id}">{$category.category_name}</a> /
        <a href="{$base_url}/category?subcat={$category.sub_category_id}"> {$category.sub_category_name}</a> / {$component.name}
    </h1>

    <div class="aboutComponentHeader">
        <div class="componentGallery">
            <div class="bigImage">
                {if $component.url1}
                    <a href="{$component.url1}" target="_blank"><img src="{$component.url1}" alt=""/></a>
                {else}
                    <div class="componentNoImg">No Image</div>
                {/if}
            </div>
            <div class="smallImages">
                {if $component.url2}
                    <li><a href="{$component.url2}" target="_blank"><img src="{$component.url2}" alt="" /></a></li>
                {/if}
                {if $component.url3}
                    <li><a href="{$component.url3}" target="_blank"><img src="{$component.url3}" alt="" /></a></li>
                {/if}
                {if $component.url4}
                    <li><a href="{$component.url4}" target="_blank"><img src="{$component.url4}" alt="" /></a></li>
                {/if}
            </div>
        </div>
    </div>

    <div class="componentComment">{$component.comment|@nl2br}</div>

    <div class="componetInfo">
        <table class="globalTables leftAlign noHover" cellpadding="0" cellspacing="0">
            <tbody>
            <tr>
                <td class="boldText">Location</td>
                <td>{$component.location|default:'-'}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="boldText">Quantity</td>
                <td>
                    <span id="component-quantity">{$component.quantity|default:'-'}</span>
                    <button class="button white small" name="quantity_increase" type="button" onclick="increase('quantity', '#component-quantity')"><span class="icon medium roundPlus"></span></button>
                    <button class="button white small" name="quantity_decrease" type="button" onclick="decrease('quantity', '#component-quantity')"><span class="icon medium roundMinus"></span></button>
                </td>
                <td class="boldText">Price</td>
                <td>
                    {if $component.price}
                        {$component.price} {$member_settings.currency}
                    {else}
                        -
                    {/if}
                </td>
                <td class="boldText">Order quantity</td>
                <td>
                    <span id="component-order-quantity">{$component.order_quantity|default:'-'}</span>
                    <button class="button white small" name="orderquant_increase" type="button" onclick="increase('order_quantity', '#component-order-quantity')"><span class="icon medium roundPlus"></span></button>
                    <button class="button white small" name="orderquant_decrease" type="button" onclick="decrease('order_quantity', '#component-order-quantity')"><span class="icon medium roundMinus"></span></button>
                </td>
            </tr>
            <tr>
                <td class="boldText">Manufacturer</td>
                <td>
                    {$component.manufacturer|default:'-'}
                </td>
                <td class="boldText">Package</td>
                <td>
                    {$component.package|default:'-'}
                </td>
                <td class="boldText">Pins</td>
                <td>
                    {$component.pins|default:'-'}
                </td>
            </tr>
            <tr>
                <td class="boldText">SMD</td>
                <td>
                    {if $component.smd == "Yes"}
                        <span class="icon medium checkboxChecked"></span>
                    {else}
                        <span class="icon medium checkboxUnchecked"></span>
                    {/if}
                </td>
                <td class="boldText">Scrap</td>
                <td>
                    {if $component.scrap == "Yes"}
                        <span class="icon medium checkboxChecked"></span>
                    {else}
                        <span class="icon medium checkboxUnchecked"></span>
                    {/if}
                </td>
                <td class="boldText">Public</td>
                <td>
                    {if $component.public == "Yes"}
                        <span class="icon medium checkboxChecked"></span>
                    {else}
                        <span class="icon medium checkboxUnchecked"></span>
                    {/if}
                </td>
            </tr>
            <tr>
                <td class="boldText">Width</td>
                <td>
                    {if $component.width}
                        {$component.width}
                        {if $member_settings.measurement == 1}
                            mm
                        {else}
                            "
                        {/if}
                    {else}
                        -
                    {/if}
                </td>
                <td class="boldText">Weight</td>
                <td>
                    {if $component.weight}
                        {$component.weight}
                        {if $member_settings.measurement == 1}
                            g
                        {else}
                            {*TODO: g?*}
                            g
                        {/if}
                    {else}
                        -
                    {/if}
                </td>
                <td class="boldText"></td>
                <td></td>
            </tr>
            <tr>
                <td class="boldText">Depth</td>
                <td>
                    {if $component.depth}
                        {$component.depth}
                        {if $member_settings.measurement == 1}
                            mm
                        {else}
                            "
                        {/if}
                    {else}
                        -
                    {/if}
                </td>
                <td class="boldText"></td>
                <td></td>
                <td class="boldText"></td>
                <td></td>
            </tr>
            <tr>
                <td class="boldText">Height</td>
                <td>
                    {if $component.height}
                        {$component.height}
                        {if $member_settings.measurement == 1}
                            mm
                        {else}
                            "
                        {/if}
                    {else}
                        -
                    {/if}
                </td>
                <td class="boldText"></td>
                <td></td>
                <td class="boldText"></td>
                <td></td>
            </tr>
            <tr>
                <td class="boldText">Datasheet</td>
                <td>
                    {if $component.datasheet}
                        <a href="{$component.datasheet}" target="_blank"><span class="icon medium document"></a>
                    {else}
                        -
                    {/if}
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>


            </tbody>
        </table>
    </div>

    <form class="globalForms noPadding" method="get" action="{$base_url}/component/{$component.id}/edit">
        <div class="buttons">
            <div class="input">
                <button class="button" name="edit" type="submit"><span class="icon medium pencil"></span> Edit Component</button>
                <button class="button" name="based" type="button" onclick="document.getElementById('form-new-based').submit();"><span class="icon medium sqPlus"></span> New based on this</button>
                <button class="button red" name="delete" type="button" onclick="delete_component()"><span class="icon medium trash"></span> Delete component</button>
            </div>
        </div>
    </form>

    <form method="get" action="{$base_url}/component/add/{$component.id}" id="form-new-based"></form>
    <form method="post" action="{$base_url}/component/{$component.id}/delete" id="form-delete"></form>
{/block}