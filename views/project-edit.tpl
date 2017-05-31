{extends file='layout.tpl'}

{block name=title}Your Projects - ecDB{/block}

{block name=head}{/block}

{block name=body}
    <!-- Main content -->

    <h1>Edit Project</h1>

    <form class="globalForms" method="post" action="{$base_url}/project/{$project.project_id}/edit">
        <div class="textInput">
            <label class="keyWord">Project name</label>
            <div class="input"><input name="name" type="text" class="medium" value="{$project.project_name|escape:'html'}" /></div>
        </div>

        <div class="buttons">
            <div class="input">
                <button class="button green" name="submit" type="submit"><span class="icon medium save"></span> Save</button>
                <button class="button red" name="delete" type="submit"><span class="icon medium trash"></span> Delete</button>
            </div>
        </div>
    </form>
    <!-- END -->
{/block}