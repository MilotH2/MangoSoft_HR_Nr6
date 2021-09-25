<template>
        <div style="width:100%">
            <kanban-board :stages="stages" :blocks="blocks" @update-block="updateBlock">
                <div v-for="stage in stages" :slot="stage" :key="stage">
                    <h2>{{ stage }}</h2>
                </div>
                <div v-for="block in blocks" :slot="block.id" :key="block.id">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-10 col-md-10">
                                    <h4 class="block_title" style="margin-bottom:1px !important">{{ block.company }}</h4><br />
                                    <h6>{{block.contact.firstname}} {{block.contact.lastname}}</h6>
                                    <p>{{block.contact.email}}</p>
                                    <p>{{block.description}}</p>
                                    <a :href="block.link" target="_blank"><i class="fa fa-globe"></i>URL</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </kanban-board>
        </div>
</template>

<script>
    export default {
        name: "tasksKanban",
        data(){
            return{
                stages: ['Requested', 'Prepared', 'Checked', 'Status-Open'],
                blocks: [],
            }

        },
        config: {
            // Don't allow blocks to be moved out of the approved stage
            accepts(block, target, source) {
                return source.dataset.status !== 'approved'
            }
        },
        // stateMachineConfig: {
        //     id: 'kanban',
        //     initial: 'on-hold',
        //     states: {
        //         'on-hold': {
        //             on: {
        //                 PICK_UP: 'in-progress',
        //             },
        //         },
        //         'in-progress': {
        //             on: {
        //                 RELINQUISH_TASK: 'on-hold',
        //                 PUSH_TO_QA: 'needs-review',
        //             },
        //         },
        //         'needs-review': {
        //             on: {
        //                 REQUEST_CHANGE: 'in-progress',
        //                 PASS_QA: 'approved',
        //             },
        //         },
        //         approved: {
        //             type: 'final',
        //         },
        //     },
        // },
        methods:{
            updateBlock(id, status) {
                const self = this;
                this.blocks.find(b => b.id === Number(id)).status = status;
                axios.post('/api/updateStatus', {
                    token:this.$store.getters.userToken,
                    id:this.$route.params.id,
                    task_id:id,
                    status:status,
                }).then(function (response) {
                    self.blocks = response.data;
                }).catch(function (error) {
                    console.log(error);
                });
            },
          getTasks(){
              const self = this;
              axios.post('/api/getTasksForKanban', {
                  token:this.$store.getters.userToken,
              }).then(function (response) {
                  console.log('response222',response);
                  self.blocks = response.data;
              }).catch(function (error) {
                  console.log(error);
              });
          } ,
        },
        created() {
            this.getTasks();
        }
    }
</script>


<style lang="scss">
    @import "../../../assets/kanban.css";
    .drag-container{
        max-width: 2000px;
    }
    .drag-column {
        -webkit-flex: 1;
        flex: 1;
        margin: 0 10px;
        position: relative;
        /* background: rgb(160, 198, 255); */
        overflow: hidden;
        background: transparent;
    }
    .drag-column-to-do {
        -webkit-flex: 1;
        flex: 1;
        margin:0 10px 0 -10px !important;
        position: relative;
        /* background: rgb(160, 198, 255); */
        overflow: hidden;
        background: transparent;
    }
    .drag-item {
        padding: 10px;
        color: black;
        background: #ffffff;
        border:1px solid #efefef;
        border-radius:5px;
        box-shadow:2px 2px #ccc;
        margin: 10px;
        height: 220px;
        /* background: rgba(0, 0, 0, 0.4); */
        transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
        cursor: pointer;
    }
    .drag-item .edit_hover_class img {
        visibility:hidden;
    }
    .drag-item .edit_hover_class div p {
        visibility:hidden;
    }
    /*.drag-item:hover {*/
    /*    padding: 10px;*/
    /*    color: black;*/
    /*    background: #CCCCCC;*/
    /*    margin: 10px;*/
    /*    height: 160px;*/
    /*    !* background: rgba(0, 0, 0, 0.4); *!*/
    /*    transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);*/
    /*    cursor: pointer;*/
    /*    border:1px solid #efefef;*/
    /*    border-radius:5px;*/
    /*    box-shadow:2px 2px #ccc;*/
    /*}*/
    .drag-item:hover .edit_hover_class img {
        visibility:visible;
        /* background: rgba(0, 0, 0, 0.4); */

    }
    .drag-item:hover .edit_hover_class div p {
        visibility:visible;
        /* background: rgba(0, 0, 0, 0.4); */

    }
    .block_title{
        //font-weight: bold;

    }
    .drag-column h2 {
        /* font-size: 0.8rem; */
        margin: 0;
        text-transform: uppercase;
        font-weight: 600;
        font-size: 16px;
    }
    .drag-column-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px;
        border: 1px solid;
        background-color: #292f4c !important;
        margin: 10px;
        color:white;
        border-radius:5px;
    }
    .drag-column-Requested .drag-column-header{
        background-color: #e74c3c !important;
    }
    .drag-column-Prepared .drag-column-header{
        background-color: #2980b9 !important;
    }
    .drag-column-Checked .drag-column-header{
        background-color: #f39c12 !important;
    }
    .drag-column-Status-Open .drag-column-header{
        background-color: #2ecc71 !important;
    }
    /*.drag-column-to-do{*/
    /*    background: red;*/
    /*}*/
    .start_date_calendar{
        height: 45px;
        width: 50px;
        border-top: 4px solid #2ecc71;
        border-right:1px solid #ccc;
        border-left:1px solid #ccc;
        border-bottom:1px solid #ccc;
        border-top-left-radius:5px;
        border-top-right-radius:5px;
    }
    .end_date_calendar{
        height: 45px;
        width: 50px;
        border-top: 4px solid #e74c3c ;
        border-right:1px solid #ccc;
        border-left:1px solid #ccc;
        border-bottom:1px solid #ccc;
        border-top-left-radius:5px;
        border-top-right-radius:5px;
    }
</style>
