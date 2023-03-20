<template>
    <div class="row flex justify-content-between align-items-center w-75 pr-5 pt-1 pl-5 ml-3">
        <h1>Videos tagged #{{tag.name}}</h1>
    </div>
    <div class="d-flex flex-row w-full justify-content-center">
        <div class="d-flex w-100 px-5 flex-column">
            <div class="row d-flex flex-row justify-content-center align-items-stretch mt-4" style="margin: 0px;">
                <div class="mx-2 mb-4 col-md-6 col-lg-3 col-sm-6 col-xs-6 align-items-stretch" v-for="video in videos">
                    <div class="card" style="max-width: 18rem; min-width: 11rem; height: 100%;">
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
    </div>
</template>

<script>

import {useRoute} from "vue-router";
import ImageSlider from "../layout/ImageSlider.vue";
import RecentVideos from "./RecentVideos.vue";

export default {
    components: {RecentVideos, ImageSlider},
    data() {
        return {
            tag: '',
            videos: [],
            currentPage: 1,
            lastPage: 1,
            per_page: this.query.per_page || 10,
        }
    },
    setup() {
        const id = useRoute().params.id
        const query = useRoute().query
        const path = useRoute().path
        return {id, query, path}
    },
    mounted() {
        window.axios.get('/api/tags/' + this.id).then(res => {
           this.tag = res.data;
        });
        let params = this.getParams();
        this.getData(params);
    },
    methods: {
        getParams() {
            let params = {'per_page': this.per_page};
            if (this.query.page && this.query.page !== '') {
                params.page = this.query.page;
            } else {
                params.page = this.currentPage;
            }
            return params;
        },
        getData(params) {
            window.axios.get('/api/tags/' + this.id + '/videos', {params: params}).then(res => {
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
