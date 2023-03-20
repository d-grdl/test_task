<template>
    <div class="slider-container" @mouseover="slideImages" @mouseout="stopSlide">
        <div style="aspect-ratio: 16 / 9; overflow: hidden">
            <img :src="currentImage" class="d-block w-100"/>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['images'],
        data() {
            return {
                interval: null,
                currentImage: '',
            }
        },
        mounted() {
            if (Object.keys(this.images).length < 1) {
                this.currentImage = '/images/default.png'
            } else {
                this.currentImage = this.images[0].path
            }
        },
        methods: {
            slideImages() {
                if (this.images !== []) {
                    let counter = 0;
                    this.interval = setInterval(() => {
                        counter++;
                        if (counter === Object.keys(this.images).length) {
                            counter = 0;
                        }
                        this.setCurrentImage(counter)
                    }, 800);
                }
            },
            setCurrentImage(counter){
                this.currentImage = this.images[counter].path;
            },
            stopSlide() {
                if (this.interval !== null) {
                    clearInterval(this.interval);
                }
            }
        }
    }
</script>
