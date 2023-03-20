<template>
    <div class="container mt-3 mb-3">
        <h1 class="display-4">Edit video "{{video.title}}"</h1>
        <form enctype="multipart/form-data">
            <div class="p-3">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" v-model="video.title" class="form-control" />
                <div v-if="errors.title">
                    <span v-for="error in errors.title" class="text-danger">
                        {{error}}
                    </span>
                </div>
            </div>
            <div class="p-3">
                <label for="description">Description</label>
                <textarea name="description" id="description" v-model="video.description" class="form-control"></textarea>
                <div v-if="errors.description">
                    <span v-for="error in errors.description" class="text-danger">
                        {{error}}
                    </span>
                </div>
            </div>
            <div class="p-3">
                <label> Tags </label>
                <div class="border w-100" @click="toggleDropdown" @input="searchTags" @focusout="clearSearch">
                    <input type="text" ref="search" class="w-100 form-control" placeholder="Start typing to search for a tag...">
                </div>
                <div class="row pl-4 mt-2" style="z-index: 20">
                    <span v-for="tag in selected" class="badge badge-pill badge-secondary" @click="removeTag(tag)">{{tags[tag - 1].name}}</span>
                </div>
                <div v-if="showDropdown" @focusout="showDropdown=false" class="border w-100 p-2 bg-white position-relative" v-bind:style="[(selected.length > 0) ? {'margin-top': '-1.5rem'} : {'margin-top': '-0.4rem'} ]" style="z-index: 10">
                    <fieldset>
                        <div v-for="tag in tags" data-option="tag.name" ref="option">
                            <input type="checkbox" v-model="selected" :id="'tag_'+tag.id" :value="(tag.id)">
                            <label :for="'tag_'+tag.id">{{tag.name}}</label>
                        </div>
                    </fieldset>
                </div>
                <div v-if="errors.tags">
                    <span v-for="error in errors.tags" class="text-danger">
                        {{error}}
                    </span>
                </div>
            </div>
            <div class="p-3">
                <label for="embedded_content">Embedded code</label>
                <textarea name="content" ref="content" id="embedded_content" v-model="content" class="form-control"></textarea>
                <div v-if="errors.embedded_content">
                    <span v-for="error in errors.embedded_content" class="text-danger">
                        {{error}}
                    </span>
                </div>
            </div>
        </form>
        <upload-images-component @getImages="attachImages($event)" @loadComplete="($event)=>{imagesLoaded=true}" @loadStart="($event)=>{imagesLoaded=false}"></upload-images-component>
        <div v-if="errors.images" class="pl-3 pb-3">
            <span v-for="error in errors.images" class="text-danger">
                {{error}}
            </span>
        </div>
        <div v-if="!imagesLoaded" class="d-flex flex-row align-items-middle pl-3">
            <img src="https://media.tenor.com/-n8JvVIqBXkAAAAM/dddd.gif" width="20" height="20" class="mt-1"/>
            <span class="text-muted">The images are uploading...</span>
        </div>
        <span v-if="imagesLoaded" @click='updateVideo' class="btn btn-primary ml-3 mt-3">Save</span>
        <span v-if="!imagesLoaded" class="btn btn-primary disabled ml-3 mt-3">Save</span>

    </div>
</template>

<script>
import {useRoute} from "vue-router";
import UploadImagesComponent from "../layout/UploadImagesComponent.vue";

export default {
    components: {UploadImagesComponent},
    data() {
        return {
            tags: [],
            video: [],
            content: '',
            showDropdown: false,
            selected: [],
            errors: '',
            imagesLoaded: true,
        }
    },
    setup() {
        const id = useRoute().params.id
        return {id}
    },
    mounted() {
        window.axios.get('/api/tags').then(res => {
            this.tags = res.data;
        });
        window.axios.get('/api/video/' + this.id).then(res => {
            this.video = res.data;
            this.content = res.data.content;
            this.video.tags.forEach((item, index) => {
                 this.selected.push(item.id)
            })
        });
    },
    methods: {
        updateVideo() {
            this.video.embedded_content = this.content;

            let new_tags = []
            this.selected.forEach((item) => {
                new_tags.push(item)
            })

            this.video.tags = new_tags;

            window.axios.put('/api/video/' + this.video.id + '/edit', this.video, {'content-type': 'multipart/form-data'}).then(() => {
                this.$router.push('/video/view/' + this.video.id);
            }).catch(error => {
                this.errors = error.response.data.errors;
            });
        },
        toggleDropdown() {
            this.showDropdown = !this.showDropdown
        },
        searchTags() {
            this.showDropdown = true;
            let query = this.$refs.search.value;
            this.$refs.option.forEach((item) => {
                if(! item.children[1].textContent.includes(query)) {
                    item.style.display = 'none'
                }
            });
        },
        clearSearch() {
            this.$refs.search.value = '';
            this.$refs.option.forEach((item) => {
                item.style.display = 'block'
            });
        },
        removeTag(id) {
            this.selected.splice(this.selected.indexOf(id), 1)
        },
        attachImages(value) {
            this.video.images = value;
        }
    }
}
</script>
