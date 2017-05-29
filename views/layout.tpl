<!DOCTYPE HTML>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="{$base_url}/include/style.css" media="screen"/>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <meta name="description" content="Viwe all your added components."/>
    <meta name="keywords" content="electronics, components, database, project, inventory"/>
    <link rel="shortcut icon" href="{$base_url}/favicon.ico"/>
    <link rel="apple-touch-icon" href="{$base_url}/img/apple.png"/>
    <title>{block name=title}Home - ecDB{/block}</title>
    {block name=head}{/block}
</head>
<body>
<div id="wrapper">
    <!-- Header -->
    <div id="header">
        <div class="logoWrapper">
            <a href ="."><span class="logoImage"></span></a>
        </div>

            {if $smarty.session.SESS_MEMBER_ID}
                <span class="userInfo">
                    Logged in as
                    <a href="{$base_url}/my.php">
                        {$smarty.session.SESS_FIRST_NAME} {$smarty.session.SESS_LAST_NAME}
                    </a>
                    -
                    <a href="{$base_url}/logout">Sign out</a>
	            </span>
                <div class="searchContent">
                    <form class="search" action="{$base_url}/search.php" method="get">
                        <input type="text" name="q" autofocus/>
                    </form>
                </div>
            {/if}
    </div>

    <div id="menu">
        <ul>
            {if $smarty.session.SESS_MEMBER_ID}
                <li><a href="{$base_url}/" class="{if $selected_menu=="components"}selected{/if}"><span class="icon medium inbox"></span> My components</a></li>
                <li><a href="{$base_url}/add.php" class="{if $selected_menu=="component_add"}selected{/if}"><span class="icon medium sqPlus"></span> Add component</a></li>
                <li><a href="{$base_url}/shoplist" class="{if $selected_menu=="shop_list"}selected{/if}"><span class="icon medium shopCart"></span> Shopping list</a></li>
                <li><a href="{$base_url}/proj_list" class="{if $selected_menu=="projects"}selected{/if}"><span class="icon medium cube"></span> Projects</a></li>
                <li><a href="{$base_url}/my.php" class="{if $selected_menu=="my"}selected{/if}"><span class="icon medium user"></span> My account</a></li>
                <li class="public"><a href="{$base_url}/public.php" class="{if $selected_menu=="components_public"}selected{/if}"><span class="icon medium shre"></span> Public components</a></li>
                <li class="donate"><a href="{$base_url}/donate.php" class="{if $selected_menu=="donate"}selected{/if}"><span class="icon medium curDollar"></span> Donate</a></li>
            {/if}
            {if !$smarty.session.SESS_MEMBER_ID}
                <li><a href="{$base_url}/" class="{if $selected_menu=="Login"}selected{/if}"><span class="icon medium key"></span> Login</a></li>
                <li><a href="{$base_url}/register" class="{if $selected_menu=="Register"}selected{/if}"><span class="icon medium user"></span> Register</a></li>
                <li><a href="{$base_url}/about.php" class="{if $selected_menu=="About"}selected{/if}"><span class="icon medium document"></span> About</a></li>
                <li><a href="{$base_url}/blog"><span class="icon medium docLinesStright"></span> Blog</a></li>
            {/if}
        </ul>
    </div>

    <!-- END -->
    <div id="content">
        <div>
            {if !empty($errors)}
                {foreach from=$errors item=$msg}
                    <div class="message red">
                        <ul class="error"><li>{$msg}</li></ul>
                    </div>
                {/foreach}
            {/if}
            {if !empty($messages)}
                {foreach from=$messages item=$msg}
                    <div class="message green">
                        {$msg}
                    </div>
                {/foreach}
            {/if}
            {if !empty($info)}
                {foreach from=$info item=$msg}
                    <div class="message orange">
                        {$msg}
                    </div>
                {/foreach}
            {/if}
        </div>
        {block name=body}{/block}
    </div>
    <!-- Text outside the main content -->
    <div id="copyText">
        <div class="leftBox">
            <div>
                © 2010 - {'Y'|@date} ecDB - Created by <a href="http://nilsf.se">Nils Fredriksson</a>
                - <a href="{$base_url}/contact.php">Contact us</a>
                - <a href="{$base_url}/terms.php">Terms & Privacy</a>
                - <a href="{$base_url}/about.php">About</a>
            </div>
            {if $smarty.session.SESS_IS_ADMIN}
                <div class="stats">

                    {$ADMIN_STATS.members}
                    <span class="boldText">members</span>,

                    {$ADMIN_STATS.components}
                    <span class="boldText">components </span>and

                    {$ADMIN_STATS.projects}
                    <span class="boldText">projects</span>.
                </div>
            {/if}
        </div>
        <div class="rightBox">
            Design by <a href="http://www.buildlog.eu"><span class="blIcon"></span></a>
        </div>
    </div>
    <!-- END -->
</div>
</body>
</html>
