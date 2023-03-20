<template>
    <div class="container mt-3 mb-3">
        <h1 class="display-4">Add new video</h1>
        <form enctype="multipart/form-data">
            <div class="p-3">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" v-model="new_video.title" class="form-control" />
                <div v-if="errors.title">
                    <span v-for="error in errors.title" class="text-danger">
                        {{error}}
                    </span>
                </div>
            </div>
            <div class="p-3">
                <label for="description">Description</label>
                <textarea name="description" id="description" v-model="new_video.description" class="form-control"></textarea>
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
                <textarea name="embedded_content" id="embedded_content" v-model="content" class="form-control"></textarea>
                <div v-if="errors.embedded_content">
                    <span v-for="error in errors.embedded_content" class="text-danger">
                        {{error}}
                    </span>
                </div>
            </div>
        </form>
        <upload-images-component @getImages="attachImages($event)" @loadComplete="($event)=>{imagesLoaded=true}" @loadStart="($event)=>{imagesLoaded=false}"></upload-images-component>
        <div v-if="errors.images">
            <span v-for="error in errors.images" class="text-danger">
                {{error}}
            </span>
        </div>
        <div v-if="!imagesLoaded" class="d-flex flex-row align-items-middle pl-3">
            <img src="https://media.tenor.com/-n8JvVIqBXkAAAAM/dddd.gif" width="20" height="20" class="mt-1"/>
            <span class="text-muted">The images are uploading...</span>
        </div>
        <span v-if="imagesLoaded" @click='createVideo' class="btn btn-primary ml-3 mt-3">Save</span>
        <span v-if="!imagesLoaded" class="btn btn-primary disabled ml-3 mt-3">Save</span>

    </div>
</template>

<script>
import UploadImagesComponent from "../layout/UploadImagesComponent.vue";
export default {
    components: {UploadImagesComponent},
    data() {
        return {
            tags: [],
            new_video: {
                title: '',
                description: '',
                content: '',
                tags: [],
            },
            showDropdown: false,
            selected: [],
            errors: '',
            content: '',
            imagesLoaded: true,
        }
    },
    mounted() {
        window.axios.get('/api/tags').then(res => {
            this.tags = res.data;
        });
    },
    methods: {
        createVideo(){
            this.new_video.embedded_content = this.content;
            let new_tags = []
            this.selected.forEach((item) => {
                new_tags.push(item)
            })
            this.new_video.tags = new_tags;
            window.axios.post('/api/video/create', this.new_video).then(()=>{
                this.$router.push('/');
            }).catch(error => {
                this.errors = error.response.data.errors;
            })
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
            this.new_video.images = value;
        }
    }

}
</script>
