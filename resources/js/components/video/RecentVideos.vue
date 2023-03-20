<template>
    <div class="bg-light w-25 text-center mt-2 -ml-5 d-flex flex-column align-items-center">
        <h3>Recently added</h3>
        <div class="card mb-4" style="width: 80%; max-width: 18rem; min-width: 11rem; height: 100%; max-height: 15rem; overflow: hidden; text-overflow: ellipsis;" v-for="video in videos">
            <router-link :to="'/video/view/'+video.id" style="text-decoration: none; color: black">
                <div class="card-body">
                    <image-slider :images="video.pictures"></image-slider>
                    <h5>{{ video.title }}</h5>
                    <p class="card-text">{{ video.description }}</p>
                </div>
            </router-link>
        </div>
    </div>
</template>

<script>

import ImageSlider from "../layout/ImageSlider.vue";
export default {
    components: {ImageSlider},
    props: {
       perPage: Number,
    },
    data() {
        return {
            videos: [],
            currentIndex: 0
        }
    },
    mounted() {
        window.axios.get('/api/video/recent?per_page=' + this.perPage).then(res => {
            this.videos = res.data;
        });
    }
}
</script>
