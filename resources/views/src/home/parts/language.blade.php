<h3>Languages</h3>
<hr />
<div class="row">
    <div class="col-4" v-for="language of languages" style="padding:15px;margin-bottom:5px;">
        <div class="row" style="padding:5px;width:100%;background:#f4f7f6;box-shadow:1px 1px 2px #efefef;">
            <div class="col-1 text-center">
                <span @click="deleteLang(language.id)" class="badge badge-danger" style="cursor: pointer;">x</span>
            </div>
            <div class="col-11">
                <strong>@{{ language.language }}</strong>
                <br />
                <span>@{{ language.level }}</span>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-1 text-center" v-if="showAddLang==0">
        <button class="btn btn-info btn-sm" style="width:100%;"
                v-if="showAddLang==0" @click="showAddLang=1">
            <i class="fa fa-plus"></i> Add
        </button>
    </div>
    <div class="col-4" v-if="showAddLang==1" style="padding:10px;background:#efefef;">
        <p>Add new Language</p>
        <label>Language</label>
        <select v-model="language.language" class="form-control">
            <option v-for="languages_item of languages_list" :value="languages_item.name">@{{ languages_item.name }}</option>
        </select>
        {{--        <input type="text" v-model="language.language" class="form-control" list="languages" />--}}

        {{--        <datalist id="languages">--}}
        {{--            <option v-for="languages_item of languages_list" :value="languages_item.name">--}}
        {{--        </datalist>--}}
        <br />
        <label>Level</label>
        <select class="form-control" v-model="language.level">
            <option value="">Select the level</option>
            <option value="A1">A1</option>
            <option value="A2">A2</option>
            <option value="B1">B1</option>
            <option value="B2">B2</option>
            <option value="C1">C1</option>
            <option value="Native">Native</option>
        </select>
        <br />
        <div class="text-right">
            <button class="btn btn-danger"  v-if="showAddLang==1" @click="showAddLang=0">Close</button>
            <button class="btn btn-success" @click="saveLang()">Save</button>
        </div>
    </div>
</div>
