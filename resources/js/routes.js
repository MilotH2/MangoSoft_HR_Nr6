
import Kanban from "./components/tasks/tasksKanban";
import statusesKanban from "./components/statuses/statusesKanban";

export const routes = [
    {
        path:'/tasks',
        component: Kanban
    },
    {
        path:'/statuses',
        component: statusesKanban
    },

];
