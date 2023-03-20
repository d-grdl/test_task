import { createWebHistory, createRouter } from 'vue-router';
import TagsList from "./components/tags/TagsList.vue";
import VideosList from "./components/video/VideosList.vue";
import CreateTag from "./components/tags/CreateTag.vue";
import EditTag from "./components/tags/EditTag.vue";
import EditVideo from "./components/video/EditVideo.vue";
import CreateVideo from "./components/video/CreateVideo.vue";
import ShowVideo from "./components/video/ShowVideo.vue";
import FilterByTag from "./components/video/FilterByTag.vue";
const routes = [
    {
        path: "/",
        redirect: '/video',
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
})



router.addRoute({
    path: "/tags",
    component: TagsList,
})

router.addRoute({
    path: "/video",
    component: VideosList,
})

router.addRoute({
    path: "/tags/add",
    name: "Add new tag",
    component: CreateTag,
})

router.addRoute({
    path: "/tags/:id/edit",
    component: EditTag,
})

router.addRoute({
    path: "/tags/:id/videos",
    component: FilterByTag,
})


router.addRoute({
    path: "/video/add",
    component: CreateVideo,
})

router.addRoute({
    path: "/video/edit/:id",
    component: EditVideo,
})

router.addRoute({
    path: "/video/view/:id",
    component: ShowVideo,
})


export default router;
