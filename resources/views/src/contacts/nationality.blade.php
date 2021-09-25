<h3>Nationality</h3>
<hr />
<div class="row" style="padding:0 15px;">
    <div class="col-12" v-for="nation of nationalities" style="padding:15px;margin-bottom:5px;">
        <div class="row" style="padding:5px;width:100%;background:#f4f7f6;box-shadow:1px 1px 2px #efefef;">
            <div class="col-1 text-center">
                <span @click="deleteNation(nation.id)" class="badge badge-danger" style="cursor: pointer;">x</span>
            </div>
            <div class="col-11">
                <strong>@{{ nation.nationality }}</strong>
                <br />
                <span>@{{ nation.permission_to_work }}</span>
            </div>
        </div>
    </div>
</div>
<div class="row" style="padding:0 15px;">
    <div class="col-1 text-center" v-if="showAddNation==0">
        <button class="btn btn-info btn-sm" style="width:100%;"
                v-if="showAddNation==0" @click="showAddNation=1">
            <i class="fa fa-plus"></i> Add
        </button>
    </div>
    <div class="col-12" v-if="showAddNation==1" style="    padding: 20px;
    background: rgb(247 247 247);
    border-radius: .25rem;">
        <label>Nationality</label>
        <select v-model="nation.nationality" class="form-control">
            <option v-for="country of countries" :value="country.name">@{{ country.name }}</option>
        </select>
{{--        <input type="text" v-model="nation.nationality" class="form-control" list="countries" />--}}

{{--        <datalist id="countries">--}}
{{--            <option v-for="country of countries" :value="country.name">--}}
{{--        </datalist>--}}
        <br />
        <label>Level</label>
        <select class="form-control" v-model="nation.permission_to_work">
            <option value="Nothing">Nothing</option>
            <option value="B EU/EFTA">B EU/EFTA</option>
            <option value="C EU/EFTA">C EU/EFTA</option>
            <option value="G EU/EFTA">G EU/EFTA</option>
            <option value="L EU/EFTA">L EU/EFTA</option>
            <option value="B">B</option>
            <option value="C">C</option>
            <option value="L">L</option>
        </select>
        <br />
        <div class="text-right">
            <button class="btn btn-danger"  v-if="showAddNation==1" @click="showAddNation=0">Close</button>
            <button class="btn btn-success" @click="saveNation()">Save</button>
        </div>
    </div>
</div>
