export default {
    install (Vue, options) {
        Vue.prototype.$priority = (priority) => priorityHtml(priority);
    }
}
const priorityHtml = (priority) => {
    if(priority===1 || priority==='1'){
        return '<span class="badge badge-info font-weight-normal ml-2">Low</span>';
    }
    if(priority===2 || priority==='2'){
        return '<span class="badge badge-warning font-weight-normal ml-2">Medium</span>';
    }
    if(priority===3 || priority==='3'){
        return '<span class="badge badge-danger font-weight-normal ml-2">High</span>';
    }
};
