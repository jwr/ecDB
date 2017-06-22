{extends file='layout.tpl'}

{block name=title}
    {if !$new_component}
        Edit component - {$component.name} - ecDB
    {else}
        Add component - ecDB
    {/if}
{/block}

{block name=head}
    <script>
        function delete_component() {
            if (confirm('Delete component?')) {
                document.getElementById('form-delete').submit();
            }
        }
        {if !$new_component}
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
                document.querySelector(count_element_selector).value = data.data.value;
            });
        }
        function decrease(field, count_element_selector) {
            ajax_post({$component.id}, field, false, function (data) {
                document.querySelector(count_element_selector).value = data.data.value;
            });
        }
        {/if}
    </script>

    <script type="text/javascript" src="{$base_url}/js/jquery.autocomplete.js"></script>
    <link rel="stylesheet" type="text/css" href="{$base_url}/css/jquery.autocomplete.css" />

    <script type="text/javascript">
        $(function() {
            $("#name").autocomplete("{$base_url}/ajax/autocomplete?f=name", {
                width: 150,
                matchContains: true,
                minChars: 2,
                selectFirst: false
            });
            $("#package").autocomplete("{$base_url}/ajax/autocomplete?f=package", {
                width: 150,
                matchContains: true,
                minChars: 2,
                selectFirst: false
            });
            $("#manufacturer").autocomplete("{$base_url}/ajax/autocomplete?f=manufacturer", {
                width: 150,
                matchContains: true,
                minChars: 2,
                selectFirst: false
            });
        });
    </script>
{/block}

{block name=body}
    {if !$new_component}
    <h1>
        <a href="{$base_url}/category?cat={$category.category_id}">{$category.category_name}</a> /
        <a href="{$base_url}/category?subcat={$category.sub_category_id}"> {$category.sub_category_name}</a> / {$component.name}
    </h1>
    {elseif $new_component && $component}
        <h1>Add new component based on <a href="{$base_url}/component/{$component.id}">{$component.name}</a></h1>
    {/if}

    <form class="globalForms noPadding" action="{$base_url}/component/{if $new_component}add{if $id_based}/{$id_based}{/if}{else}{$component.id}/edit{/if}" method="post">
        <div class="textBoxInput">
            <label class="keyWord boldText">Comment</label>
            <div class="text">
                <textarea name="component[comment]" rows="4" cols="104">{$component.comment}</textarea>
            </div>
        </div>
        <table class="globalTables leftAlign noHover" cellpadding="0" cellspacing="0">
            <tbody>
            <tr>
                <td class="boldText">Name</td>
                <td>
                    <input name="component[name]" type="text" class="medium" value="{$component.name|escape:'html'}" id="name" />
                </td>
                <td class="boldText">Category</td>
                <td>
                    <select name="component[category]">
                        <option value=""> - Category - </option>
                        {foreach from=$category_tree item=category}
                            <optgroup label="{$category.name}">
                                {foreach from=$category.subcategories item=subcategory}
                                    <option value="{$subcategory.id}" {if $subcategory.id == $component.category} selected{/if}>
                                        {$subcategory.name}
                                    </option>
                                {/foreach}
                            </optgroup>
                        {/foreach}
                    </select>
                </td>
                <td class="boldText">Quantity</td>
                <td>
                    <input id="component-quantity" name="component[quantity]" type="text" class="small" value="{$component.quantity|escape:'html'}" />
                    {if !$new_component}
                    <button class="button white small" name="quantity_increase" type="button" onclick="increase('quantity', '#component-quantity')"><span class="icon medium roundPlus"></span></button>
                    <button class="button white small" name="quantity_decrease" type="button" onclick="decrease('quantity', '#component-quantity')"><span class="icon medium roundMinus"></span></button>
                    {/if}
                </td>
            </tr>
            <tr>
                <td class="boldText">Manufacturer</td>
                <td>
                    <input name="component[manufacturer]" id="manufacturer" type="text" class="medium" value="{$component.manufacturer|escape:'html'}" />
                </td>
                <td class="boldText">Package</td>
                <td>
                    <input name="component[package]" id="package" type="text" class="medium" value="{$component.package|escape:'html'}" />
                </td>
                <td class="boldText">Pins</td>
                <td>
                    <input name="component[pins]" type="text" class="small" value="{$component.pins|escape:'html'}" />
                </td>
            </tr>
            <tr>
                <td class="boldText">Location</td>
                <td>
                    <input name="component[location]" type="text" class="medium" value="{$component.location|escape:'html'}" id="location" />
                </td>
                <td class="boldText">Price</td>
                <td>
                    <input name="component[price]" type="text" class="small" value="{$component.price|escape:'html'}" id="price" /> {$member_settings.currency}
                </td>
                <td class="boldText">To order</td>
                <td>
                    <input name="component[order_quantity]" type="text" class="small" value="{$component.order_quantity|escape:'html'}" id="order_quantity"/>
                    {if !$new_component}
                    <button class="button white small" name="quantity_increase" type="button" onclick="increase('order_quantity', '#order_quantity')"><span class="icon medium roundPlus"></span></button>
                    <button class="button white small" name="quantity_decrease" type="button" onclick="decrease('order_quantity', '#order_quantity')"><span class="icon medium roundMinus"></span></button>
                    {/if}
                </td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="boldText">SMD</td>
                <td>
                    <input type="radio" name="component[smd]"{if $component.smd == "Yes"} checked="checked"{/if} value="Yes" /> Yes
                    <input type="radio" name="component[smd]"{if $component.smd == "No"} checked="checked"{/if} value="No" /> No
                </td>
                <td class="boldText">Scrap</td>
                <td>
                    <input type="radio" name="component[scrap]"{if $component.scrap == "Yes"} checked="checked"{/if} value="Yes" /> Yes
                    <input type="radio" name="component[scrap]"{if $component.scrap == "No"} checked="checked"{/if} value="No" /> No
                </td>
                <td class="boldText">Public</td>
                <td>
                    <input type="radio" name="component[public]"{if $component.public == "Yes"} checked="checked"{/if} value="Yes" /> Yes
                    <input type="radio" name="component[public]"{if $component.public == "No"} checked="checked"{/if} value="No" /> No
                </td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="boldText">Weight</td>
                <td>
                    <input name="component[weight]" type="text" class="small" value="{$component.weight|escape:'html'}" />
                    {if $member_settings.measurement == 1}
                        g
                    {else}
                        g {* TODO: g? *}
                    {/if}
                </td>
                <td class="boldText">Width</td>
                <td>
                    <input name="component[width]" type="text" class="small" value="{$component.width|escape:'html'}" />
                    {if $member_settings.measurement == 1}
                        mm
                    {else}
                        in
                    {/if}
                </td>
                <td colspan="2" rowspan="5">
                    <img class="packageImage" border="0" src="{$base_url}/img/boxSize.png"/>
                </td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td class="boldText">Depth</td>
                <td>
                    <input name="component[depth]" type="text" class="small" value="{$component.depth|escape:'html'}" />
                    {if $member_settings.measurement == 1}
                        mm
                    {else}
                        in
                    {/if}
                </td>
            </tr>

            <tr>
                <td class="boldText">Datasheet URL</td>
                <td>
                    <input name="component[datasheet]" type="text" class="medium" value="{$component.datasheet|escape:'html'}" />
                </td>
                <td class="boldText">
                    Height
                </td>
                <td>
                    <input name="component[height]" type="text" class="small" value="{$component.height|escape:'html'}" />
                    {if $member_settings.measurement == 1}
                        mm
                    {else}
                        in
                    {/if}
                </td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="boldText">Image URL 1</td>
                <td>
                    <input name="component[url1]" type="text" class="medium" value="{$component.url1|escape:'html'}" />
                </td>
                <td class="boldText">Image URL 2</td>
                <td>
                    <input name="component[url2]" type="text" class="medium" value="{$component.url2|escape:'html'}" />
                </td>
            </tr>
            <tr>
                <td class="boldText">Image URL 3</td>
                <td>
                    <input name="component[url3]" type="text" class="medium" value="{$component.url3|escape:'html'}" />
                </td>
                <td class="boldText">Image URL 4</td>
                <td>
                    <input name="component[url4]" type="text" class="medium" value="{$component.url4|escape:'html'}" />
                </td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td class="boldText">Add to project</td>
                <td class="boldText">Quantity</td>
                {if $project and !$new_component}
                    <td class="boldText">Project</td>
                    <td class="boldText">Quantity</td>
                    <td></td>
                {else}
                    <td></td>
                    <td></td>
                    <td></td>
                {/if}
            </tr>
            <tr>
                <td></td>
                <td>
                    <select name="project">
                        <option class="main_category" value=""> - Project - </option>
                        {foreach from=$projects item=$p}
                            <option value="{$p.id}"{if $project.id == $p.id} disabled{/if}>{$p.project_name}</option>
                        {/foreach}
                    </select>
                </td>
                <td>
                    <input name="projquant" type="text" class="small" value="{$projquant}" />
                </td>
                {if $project and !$new_component}
                    <td>{$project.project_name}</td>
                    <td>
                        <input name="projquantedit[{$project.project_id}]" type="text" class="small" value="{$project.projects_data_quantity}" />
                    </td>
                {else}
                    <td></td>
                    <td></td>
                {/if}
            </tr>
            </tbody>
        </table>

        <div class="buttons">
            <div class="input">
                {if !$new_component}
                    <button class="button green" name="update" type="submit"><span class="icon medium save"></span> Update</button>
                    <button class="button" name="based" type="button" onclick="document.getElementById('form-new-based').submit();"><span class="icon medium sqPlus"></span> New based on this</button>
                    <button class="button red" name="delete" type="button" onclick="delete_component()"><span class="icon medium trash"></span> Delete</button>
                {else}
                    <button class="button green" name="update" type="submit"><span class="icon medium save"></span> Save</button>
                {/if}
            </div>
        </div>
    </form>

    <form method="get" action="{$base_url}/component/add/{$component.id}" id="form-new-based"></form>
    <form method="post" action="{$base_url}/component/{$component.id}/delete" id="form-delete"></form>
{/block}