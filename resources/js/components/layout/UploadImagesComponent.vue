<template>
    <div>
        <div class="card-body">
            <form>
                <div>
                    <label for="images" class="col-md-4 col-form-label text-md-end">Upload images</label>
                    <input type="file" class="form-control" id='images' name="images" ref="file" multiple @input="uploadImages">
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        data: () => ({
            formData: {'files': null},
            errors: [],
        }),
        emits: ['getImages', 'loadStart', 'loadComplete', 'uploadErrors'],
        methods: {
            async uploadImages() {
                this.$emit('loadStart', true);
                let images = [];
                if (this.$refs.file.files.length < 6) {
                    for (let i = 0; i < this.$refs.file.files.length; i++) {
                        this.formData.files = this.$refs.file.files[i];
                        const headers = {'content-type': 'multipart/form-data'};
                        await window.axios.post('/api/picture/upload', this.formData, {headers}).then(res => {
                            images.push(res.data);
                        }).catch(error => {
                            this.errors = error.response.data.errors;
                            this.$emit('uploadErrors', this.errors)
                        });
                    }
                    this.$emit('getImages', images);
                    this.$emit('loadComplete', true);
                }
            }
        }
    }
</script>
