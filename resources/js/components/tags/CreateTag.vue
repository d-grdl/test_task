<template>
    <div class="container mt-3 mb-3" style="aspect-ratio: 2/1">
        <form>
            <div class="p-3">
                <label for="name">New tag</label>
                <input type="text" name="name" id="name" class="form-control" v-model="new_tag.name" />
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

export default {
    data() {
        return {
            new_tag: {
                name: ''
            },
            errors: [],
        }
    },
    methods: {
        createTag() {
            window.axios.post('/api/tags/create', this.new_tag).then(()=>{
                this.$router.push('/tags')
            }).catch(error => {
                this.errors = error.response.data.errors;
            })
        }
    }
}

</script>
