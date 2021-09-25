<h3 class="col-5">Skills</h3>
<hr />
<div class="col-12" v-for="skill of skills" style="padding:15px;margin-bottom:5px;">
    <div class="row" style="padding:5px;width:100%;background:#f4f7f6;box-shadow:1px 1px 2px #efefef;">
        <div class="col-1 text-center">
            <span @click="deleteSkill(skill.id)" class="badge badge-danger" style="cursor: pointer;">x</span>
        </div>
        <div class="col-11">
            <strong>@{{ skill.skill }}</strong>
            <br />
            <span>@{{ skill.level }}</span>
        </div>
    </div>
</div>
<div class="col-2 text-center" v-if="showAddSkills==0">
    <button class="btn btn-info btn-sm" style="width:100%;"
            v-if="showAddSkills==0" @click="showAddSkills=1">
        <i class="fa fa-plus"></i> Add
    </button>
</div>
<div class="col-12" v-if="showAddSkills==1" style="    padding: 20px;
    background: rgb(247 247 247);
    border-radius: .25rem;">
     <p><i class="fa fa-plus-circle"></i> Add new skill</p>
    <hr/>
    <label>Skill</label>
    <input type="text" v-model="skill.skill" class="form-control" required/>
    <small style="color:red" v-if="skill_error == 1">This field is required</small>

{{--        <select id="skills">   list="skills"--}}
{{--            <option v-for="skill_item of skills_list" :value="skill_item.skill">--}}
{{--        </select>--}}
    <br />
    <label>Level</label>
    <select class="form-control" v-model="skill.level" required>
        <option value="">Select the level</option>
        <option value="Junior">Junior</option>
        <option value="Professional">Professional</option>
        <option value="Senior">Senior</option>
        <option value="Expert">Expert</option>
    </select>
    <small style="color:red" v-if="level_error == 1">This field is required</small>
    <br />
    <div class="text-right">
        <button class="btn btn-danger"  v-if="showAddSkills==1" @click="showAddSkills=0;skill_error = 0;level_error= 0;">Close</button>
        <button class="btn btn-success" @click="saveSkill();">Save</button>
    </div>
</div>
