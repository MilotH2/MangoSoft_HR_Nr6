
<h3>Experience</h3>
<hr />
<div class="row" style="padding:0 15px;">
    <div class="col-12" v-for="position of positions" style="padding:15px;margin-bottom:5px;">
        <div class="row" style="padding:5px;box-shadow:1px 1px 2px #efefef;width:100%;background:#f4f7f6;border-radius:10px;">
            <div class="col-1 text-center">
                <span @click="deletePosition(position.id)" class="badge badge-danger" style="cursor: pointer;">x</span>
            </div>
            <div class="col-11">
                <strong>@{{ position.position }}</strong>
                <br />
                <p class="text-muted" style="white-space: pre-wrap;margin:0;padding:0;font-size:9pt;">@{{ position.description }}</p>
                <span>@{{ position.company }}</span>
                <br />
                <small class="text-muted">@{{ position.from_year }} - @{{ position.to_year }}</small>
            </div>
        </div>
    </div>
</div>
<div class="row" style="padding:0 15px;">
    <div class="col-2 text-center" v-if="showAddPositions==0">
        <button class="btn btn-info btn-sm" style="width:100%;"
                v-if="showAddPositions==0" @click="showAddPositions=1">
            <i class="fa fa-plus"></i> Add
        </button>
    </div>
    <div class="col-12" v-if="showAddPositions==1" style="    padding: 20px;
    background: rgb(247 247 247);
    border-radius: .25rem;">
        <p><i class="fa fa-plus-circle"></i> Add new experience</p>
        <div class="row">
            <div class="col-6">
                <label>Position</label>
                <input type="text" v-model="position.position" class="form-control" />
            </div>
            <div class="col-6">
                <label>Company</label>
                <input type="text" v-model="position.company" class="form-control" />
            </div>
        </div>
        <br />
        <label>Descirption</label>
        <textarea v-model="position.description" class="form-control"></textarea>
        <div class="row">
            <div class="col-6">
                <label>From Year</label>
                <select class="form-control" v-model="position.from_year">
                    <option v-for="n in 50" :value="2022-n">@{{ 2022-n }}</option>
                </select>
            </div>
            <div class="col-6">
                <label>To Year</label>
                <select class="form-control" v-model="position.to_year">
                    <option value="Current">Current</option>
                    <option v-for="n in 30" :value="2022-n">@{{ 2022-n }}</option>
                </select>
            </div>
        </div>
        <br />
        <div class="text-right">
            <button class="btn btn-danger" @click="showAddPositions=0">Close</button>
            <button class="btn btn-success" @click="savePosition()">Save</button>
        </div>
    </div>
</div>
