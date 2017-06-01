{extends file='layout.tpl'}

{block name=title}Home - ecDB{/block}

{block name=head}{/block}

{block name=body}
    <h1>Settings</h1>

    <form class="globalForms noPadding" action="{$base_url}/my" method="post">
        <table class="globalTables leftAlign noHover" cellpadding="0" cellspacing="0">
            <tbody>
            <tr>
                <td class="boldText">First Name</td>
                <td>
                    <input name="firstname" type="text" class="medium" value="{$member.firstname|escape:'html'}" />
                </td>
                <td class="boldText">Last Name</td>
                <td>
                    <input name="lastname" type="text" class="medium" value="{$member.lastname|escape:'html'}" />
                </td>
            </tr>
            <tr>
                <td class="boldText">Email</td>
                <td>
                    <input name="mail" class="medium" type="text" value="{$member.mail|escape:'html'}" />
                </td>
            </tr>
            <tr>
                <td class="boldText">Current Password</td>
                <td>
                    <input name="oldpass" class="medium" type="password" value="" />
                </td>
                <td class="boldText">New password</td>
                <td>
                    <input name="newpass" class="medium" type="password" value="" onpaste="return false;" />
                </td>
            </tr>
            <tr>
                <td class="boldText">Measurement System</td>
                <td>
                    <input type="radio" name="measurement" value="1" {if $member.measurement == 1}checked="checked"{/if} /> Metric
                    <input type="radio" name="measurement" value="0" {if $member.measurement == 0}checked="checked"{/if} /> American System (Imperial)
                </td>
            </tr>
            <tr>
                <td class="boldText">Currency</td>
                <td>
                    <select name="currency">
                        <option value="SEK" {if $member.currency == 'SEK'}selected{/if}>SEK</option>
                        <option value="USD" {if $member.currency == 'USD'}selected{/if}>USD</option>
                        <option value="EUR" {if $member.currency == 'EUR'}selected{/if}>EUR</option>
                        <option value="GBP" {if $member.currency == 'GBP'}selected{/if}>GBP</option>
                    </select>
                </td>
            </tr>
            {if $smarty.session.SESS_IS_ADMIN}
                <tr>
                    <td class="boldText">Administrative User</td>
                    <td>
                        {if $member.admin == 1}Yes{else}No{/if}
                    </td>
                </tr>
            {/if}
            </tbody>
        </table>
        <div class="buttons">
            <div class="input">
                <button class="button green" name="submit" type="submit"><span class="icon medium save"></span> Save</button>
            </div>
        </div>
    </form>
{/block}