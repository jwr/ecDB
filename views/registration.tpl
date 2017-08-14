{extends file='layout.tpl'}

{block name=title}Register - ecDB{/block}

{block name=head}{/block}

{block name=body}
    <!-- Main content -->

    <div class="loginWrapper">
        <div class="left">
            <div class="aboutECDB">
                You want to build something and need some components for your project.
                You don't know if you have those components, or where they are.
                This is a problem many of us recognise.
                We want to change that for you by making a online inventory system for your electronic components that is easy to use.
                Add your components. Search to find it, and then use it!
            </div>
            <form class="globalForms" name="loginForm" method="post" action="{$base_url}/register">
                <div class="textInput">
                    <label class="keyWord">First name</label>
                    <div class="input"><input name="fname" type="text" value="{$fname|escape:'htmlall'}" class="medium" id="fname" /></div>
                </div>
                <div class="textInput">
                    <label class="keyWord">Last name</label>
                    <div class="input"><input name="lname" type="text" value="{$lname|escape:'htmlall'}" class="medium" id="lname" /></div>
                </div>
                <div class="textInput">
                    <label class="keyWord">Username</label>
                    <div class="input"><input name="login" type="text" value="{$login|escape:'htmlall'}" class="medium" id="login" /></div>
                </div>
                <div class="textInput">
                    <label class="keyWord">E-mail</label>
                    <div class="input"><input name="mail" type="text" value="{$mail|escape:'htmlall'}" class="medium" id="mail" /></div>
                </div>
                <div class="textInput">
                    <label class="keyWord">Password</label>
                    <div class="input"><input name="password" type="password" class="medium" id="password" /></div>
                </div>
                <div class="textInput">
                    <label class="keyWord">Repeat password</label>
                    <div class="input"><input name="cpassword" type="password" class="medium" id="cpassword" onpaste="return false;" /></div>
                </div>
                <div class="buttons">
                    By registering you accept the <a href="{$base_url}/terms">Terms and Contidions.</a><br><br>
                    <div class="input">
                        <button class="button green" name="Submit" type="submit">Register</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="right"></div>
    </div>
    <!-- END -->
{/block}