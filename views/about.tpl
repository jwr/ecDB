{extends file='layout.tpl'}

{block name=title}About - ecDB{/block}

{block name=head}{/block}

{block name=body}
    <!-- Main content -->
    <div class="loginWrapper">
        <div class="left">
            <div class="message blue">
                Check out the new <a href="/blog">ecDB blog.</a> Or follow <a href="https://twitter.com/#!/ecDBnet">@ecDBnet</a> at Twitter to get the latest updates!
            </div>
            <h1>What is ecDB?</h1>

            ecDB is basically a place where you, as an electronics hobbyist (or professional) can add your own components to your personal database to keep track of what components you own, where they are, how many you own and so on.

            <br /><br />
            <a href="{$base_url}/img/about/index.png"><img src="{$base_url}/img/about/index_thumbnail.png"></a>
            <a href="{$base_url}/img/about/add.png"><img src="{$base_url}/img/about/add_thumbnail.png"></a><br /><br />
            <h1>Who & Why?</h1>

            ecDB is created by <a target="_blank" href="http://nilsf.se">Nils Fredriksson</a> and designed by <a target="_blank" href="http://www.buildlog.eu">Buildlog</a>. <br /><br />

            Me, Nils, have always wanted to have a system like this to keep track of what component I own. Before I created this system I (I guess you too...) had to dig through boxes filled with components to maybe find that component I needed. This is an unnecessary task to do, it not only takes time, and it also can be really frustrating not to find that component you are looking for. So I ended up creating this website where I easily can keep track of my components!

            <br /><br />
            <h1>What does it cost?</h1>

            ecDB is completely free!<br />
            But if you like ecDB you can use this button to donate us some money.
            <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                <input type="hidden" name="cmd" value="_s-xclick">
                <input type="hidden" name="hosted_button_id" value="7ZT5UY5XMHA52">
                <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
            </form>

            <br />
            <h1>Is ecDB really done?</h1>
            No! ecDB is still under development. Here are some of the upcoming features:<br /><br />

            - Public components - a place where you easily can trade components.<br />
            - View to physically print the personal database. Old-school typewritten text and nice colums!<br />
            - Datasheet and picture uploading.<br />
            - Advanced component search with parameters.<br />
            - Log for each component. See when the component last was used/edited/bought etc.<br />
            - Barcode implementation for easy storage management.<br />
            - Import and export of personal database to text/spreadsheet.<br />
            - Quick edit function of component data directly from the database view.<br />
            - Add personal categories and fields.<br />
            - Borrow component data from other components in the database to easily add components.
        </div>
        <div class="right"></div>
    </div>
    <!-- END -->
{/block}