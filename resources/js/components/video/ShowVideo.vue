<template>
    <div class="container mt-3 mb-3">
        <div class="d-flex flex-row align-items-center justify-content-between">
            <h1 class="display-4">{{video.title}}</h1>
            <div>
                <router-link :to="'/video/edit/' + video.id "><span class="btn btn-secondary" style="height: fit-content">Edit</span></router-link>
                <span class="btn btn-danger m-1" style="height: fit-content" @click="deleteVideo">Delete</span>
            </div>
        </div>
        <div class="embed-container" ref="content"></div>
        <p class="mt-2">{{video.description}}</p>
        <div class="d-flex flex-row flex-wrap">
            <div v-for="picture in video.pictures" class="position-relative" style="aspect-ratio: 1 / 1; overflow:hidden; max-width: 10rem">
                <span role="button" class="btn btn-danger m-1 position-absolute bottom-0 right-0" @click="deleteImage(picture.id)">
                    <i class="fa-solid fa-trash-can"></i>
                </span>
                <img :src="picture.path">
            </div>
        </div>
        <div class="row p-2">
            <span v-for="tag in video.tags" @click="() => {this.$router.push('/tags/' + tag.id + '/videos')}"
                  class="btn badge badge-pill badge-secondary">{{tag.name}}</span>
        </div>
    </div>
</template>

<script>
import {useRoute} from "vue-router";

export default {
    data() {
        return {
            video: [],
        }
    },
    setup() {
        const id = useRoute().params.id
        return {id}
    },
    mounted() {
        window.axios.get('/api/video/' + this.id).then(res => {
            this.video = res.data;
            this.$refs.content.innerHTML = this.video.content;
        });
    },
    methods: {
        async deleteVideo() {
            if(confirm("Are you sure you want to delete this video?")) {
                await window.axios.delete('/api/video/' + this.id + '/delete').then(() => {
                    this.$router.push('/');
                }).catch(error => {
                    confirm('Sorry, something went wrong :(');
                })
            }
        },
        async deleteImage(imageId) {
            if(confirm("Are you sure you want to delete this image?")) {
                await window.axios.delete('/api/picture/' + imageId + '/delete').then(() => {
                    window.axios.get('/api/video/' + this.id).then(res => {
                        this.video = res.data;
                        this.$refs.content.innerHTML = this.video.content;
                    });
                }).catch(error => {
                    confirm('Sorry, something went wrong :(');
                })
            }
        }
    }
}
</script>
