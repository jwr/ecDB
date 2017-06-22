{extends file='layout.tpl'}

{block name=title}ecDB - electronics component DataBase{/block}

{block name=head}{/block}

{block name=body}
    <!-- Main content -->

        <div class="loginWrapper">
            <div class="left">

                <div class="aboutECDB">
                    You want to build something and need some components for your project.
                    You don't know if you have those components, or where they are.
                    This is a problem many of us recognise.
                    We want to change that for you by making a online inventory system for your electronic components
                    that is easy to use.
                    Add your components. Search to find it, and then use it!
                </div>

                <form class="globalForms" name="loginForm" method="post" action="{$base_url}/auth">
                    <div class="textInput">
                        <label class="keyWord">Username</label>
                        <div class="input">
                            To try ecDB, login with demo:demo<br />
                            <input name="login" class="medium" type="text" id="login"/>
                        </div>
                    </div>
                    <div class="textInput">
                        <label class="keyWord">Password</label>
                        <div class="input"><input name="password" class="medium" type="password" id="password"/></div>
                    </div>
                    <div class="buttons">
                        <div class="input">
                            <button class="button green" name="Submit" type="submit"><span
                                        class="icon medium key"></span> Login
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="right"></div>
        </div>
    <!-- END -->
{/block}