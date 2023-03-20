<template>
    <div class="d-flex flex-row w-full">
        <div class="d-flex w-100 flex-column ml-5">
            <div class="row justify-content-between align-items-center w-100 pr-5 pt-1 pl-5 ml-3">
                <h1>Videos</h1>
                <router-link to="/video/add"><span class="btn btn-primary mr-5">Add new</span></router-link>
            </div>
            <div class="row d-flex flex-row justify-content-center align-items-stretch mt-4" style="margin: 0px;">
                <div class="mx-2 mb-4 col-md-6 col-lg-3 col-sm-6 col-xs-6 align-items-stretch" v-for="video in videos">
                <div class="card" style="max-width: 18rem; min-width: 11rem; height: 100%; max-height: 15rem; overflow: hidden">
                    <router-link :to="'/video/view/'+video.id" style="text-decoration: none; color: black">
                        <div class="card-body">
                            <image-slider :images="video.pictures"></image-slider>
                            <h5 class="mt-3">{{video['title']}}</h5>
                            <p class="card-text text-muted">{{video['description']}}</p>
                        </div>
                    </router-link>
                </div>
            </div>
            </div>
            <div class="row px-5 pt-2 pb-5 w-100 justify-content-end align-items-middle">
                <label class="form-label mr-3 mt-1">Show per page: </label>
                <select v-model="per_page" class="form-select p-1" @change="changePerPage">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                </select>
            </div>
            <div class="row pl-5 pb-5 w-100 justify-content-center">
                <span v-if="currentPage > 1" @click="previousPage" class="btn btn-outline-dark m-1">Previous</span>
                <span v-if="currentPage < lastPage" @click="nextPage" class="btn btn-outline-dark m-1">Next</span>
            </div>
        </div>
        <recent-videos :perPage="3"></recent-videos>
    </div>
</template>

<script>

import {useRoute} from "vue-router";
import RecentVideos from "./RecentVideos.vue";
import ImageSlider from "../layout/ImageSlider.vue";

export default {
    components: {ImageSlider, RecentVideos},
    setup() {
        const path = useRoute().path
        const query = useRoute().query
        return {query, path}
    },
    data() {
        return {
            videos: [],
            currentPage: 1,
            lastPage: 1,
            per_page: this.query.per_page || 10,
        }
    },
    mounted() {
        let params = this.getParams();
        this.getData(params);
    },
    methods: {
        getParams() {
            let params = {'per_page': this.per_page};
            if ((Object.keys(this.query).length) > 0) {
                if (this.query.page && this.query.page !== '') {
                    params.page = this.query.page;
                }
                if (this.query.searchQuery && this.query.searchQuery !== '') {
                    params.searchQuery = this.query.searchQuery;
                }
            } else {
                params.page = this.currentPage;
            }

            return params;
        },
        getData(params) {
            window.axios.get('/api/video', {params: params}).then(res => {
                this.videos = res.data.data;
                this.currentPage = res.data.current_page;
                this.lastPage = res.data.last_page;
            });
        },
        changePerPage() {
            let params = this.getParams();
            this.getData(params);
        },
        previousPage() {
            let params = this.getParams();
            params.page = this.currentPage - 1;
            this.getData(params);
        },
        nextPage() {
            let params = this.getParams();
            params.page = this.currentPage + 1;
            this.getData(params);
        }

    }
}
</script>
