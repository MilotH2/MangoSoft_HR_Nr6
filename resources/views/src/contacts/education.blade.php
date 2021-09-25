
<h3 class="col-7">Education</h3>
<hr />
<div class="row" v-for="degree of degrees" style="padding:0 15px;">
    <div class="col-12" style="padding:15px;margin-bottom:5px;">
        <div class="row" style="padding:5px;box-shadow:1px 1px 2px #efefef;width:100%;background:#f4f7f6;border-radius:10px;">
            <div class="col-1 text-center">
                <span @click="deleteEdu(degree.id)" class="badge badge-danger" style="cursor: pointer;">x</span>
            </div>
            <div class="col-11">
                <strong>@{{ degree.degree }}</strong>
                <br />
                <small class="text-muted">@{{ degree.institution }}</small>
                <br />
                <span>@{{ degree.finished_year }}</span>
            </div>
        </div>
    </div>
</div>
<div class="row" style="padding:0 15px;">
    <div class="col-1 text-center" v-if="showAddEdu==0">
        <button class="btn btn-info btn-sm" style="width:100%;"
                v-if="showAddEdu==0" @click="showAddEdu=1">
            <i class="fa fa-plus"></i> Add
        </button>
    </div>
    <div class="col-12" v-if="showAddEdu==1" style="padding: 20px;
        background: rgb(247 247 247);
        border-radius: .25rem;">
        <p><i class="fa fa-plus-circle"></i> Add new education</p>
        <hr/>
        <div class="row">
            <div class="col-12">
                <label>Degree</label>
                <select class="form-control" v-model="degree.degree">
                    <option value="">Select the degree</option>
                    <option value="High School">High School</option>
                    <option value="Efz">Efz</option>
                    <option value="Fachausweis">Fachausweis</option>
                    <option value="Diplom">Diplom</option>
                    <option value="Höhere Fachschule">Höhere Fachschule</option>
                    <option value="Cas">Cas</option>
                    <option value="Mas">Mas</option>
                    <option value="Bachelor">Bachelor</option>
                    <option value="Master">Master</option>
                    <option value="Phd">Phd</option>
                </select>
            </div>
            <div class="col-8">
                <br />
                <label>Institution</label>
                <input type="text" v-model="degree.institution" class="form-control" />
            </div>
            <div class="col-4">
                <br />
                <label>Finished Year</label>
                <select class="form-control" v-model="degree.year">
                    <option v-for="n in 50" :value="2021-n">@{{ 2021-n }}</option>
                </select>
            </div>
        </div>


        <br />
        <div class="text-right">
            <button class="btn btn-danger" @click="showAddEdu=0">Close</button>
            <button class="btn btn-success" @click="saveEdu()">Save</button>
        </div>
    </div>
</div>

