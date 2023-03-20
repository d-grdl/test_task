<template>
    <div class="container mt-3 mb-3" style="aspect-ratio: 2/1">
        <form>
            <div class="p-3">
                <label>Edit tag</label>
                <input type="text" name="name" class="form-control" v-model="tag.name" />
                <div v-if="errors.name">
                    <span v-for="error in errors.name" class="text-danger">
                        {{error}}
                    </span>
                </div>
            </div>
            <span class="btn btn-primary ml-3 mt-3" @click="createTag">Save</span>
        </form>
    </div>
</template>

<script>

import {useRoute} from "vue-router";

export default {
    data() {
        return {
            tag: [],
            errors: [],
        }
    },
    setup() {
        const id = useRoute().params.id
        return {id}
    },
    mounted() {
        window.axios.get('/api/tags/' + this.id).then((res)=>{
            this.tag = res.data;
        });
    },
    methods: {
        createTag() {
            window.axios.put('/api/tags/'+ this.tag.id + '/edit', this.tag).then(()=>{
                this.$router.push('/tags');
            }).catch(error => {
                this.errors = error.response.data.errors;
            })
        }
    }
}

</script>
