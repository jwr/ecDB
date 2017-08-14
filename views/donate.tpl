{extends file='layout.tpl'}

{block name=title}Donate - ecDB{/block}

{block name=head}{/block}

{block name=body}

    <h1>Donate</h1>

    ecDB is completely free!<br />

    However, if you like ecDB you may use the button below to donate some money to the project!<br /><br />

    <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
        <input type="hidden" name="cmd" value="_s-xclick">
        <input type="hidden" name="hosted_button_id" value="7ZT5UY5XMHA52">
        <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
    </form>

{/block}