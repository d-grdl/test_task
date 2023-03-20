<template>
    <header-component></header-component>
    <router-view :key="$route.fullPath"></router-view>
    <footer-component></footer-component>
</template>
<script>
import HeaderComponent from "./components/layout/HeaderComponent.vue";
import FooterComponent from "./components/layout/FooterComponent.vue";
export default {
    components: {FooterComponent, HeaderComponent}
}
</script>
