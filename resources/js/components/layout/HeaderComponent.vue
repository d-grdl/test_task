<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <router-link to="/"><span class="navbar-brand" data-abc="true"><i class="fa-solid fa-cubes-stacked"></i></span></router-link>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarColor02">
            <ul class="navbar-nav mr-auto">
                <router-link to="/video"><li class="nav-item"> <span class="nav-link" data-abc="true">Videos</span></li></router-link>
                <router-link to="/tags"><li class="nav-item"> <span class="nav-link" data-abc="true">Tags</span> </li></router-link>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="text" name="searchQuery" placeholder="Search" v-model="query">
                <span class="btn btn-secondary my-2 my-sm-0" @click="search">Search</span>
            </form>
        </div>
    </nav>
</template>

<script>

export default {
    data() {
        return {
            query: '',
        }
    },
    methods: {
        search() {
            this.$router.push("/video?searchQuery=" + this.query);
        }
    }
}

</script>

