<template>
    <div class="container mt-3 component-container">
        <div class="row flex justify-content-between align-items-center w-100">
            <h1>Tags</h1>
            <router-link to="/tags/add"><span class="btn btn-primary">Add new</span></router-link>
        </div>
        <div class="mt-3" id="tags_list">
            <div class="btn-group m-2" role="group" v-for="tag in tags">
                <span @click="this.$router.push('/tags/' + tag.id + '/videos')" role="button" class="btn btn-outline-dark px-3">{{ tag.name }}</span>
                <span role="button" @click="this.$router.push('/tags/' + tag.id + '/edit')" class="btn btn-secondary"><i class="fa-solid fa-pen-to-square"></i></span>
                <span role="button" @click="deleteTag(tag.id)" class="btn btn-danger"><i class="fa-solid fa-trash-can"></i></span>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    data() {
        return {
            tags: [],
        }
    },
    mounted() {
        window.axios.get('/api/tags').then(res => {
            this.tags = res.data;
        });
    },
    methods: {
        deleteTag(tagId) {
            if(confirm("Are you sure you want to delete this tag?")) {
                window.axios.delete('/api/tags/' + tagId + '/delete').then(() => {
                    window.axios.get('/api/tags').then(res => {
                        this.tags = res.data;
                    });
                })
            }
        }
    }
}

</script>
