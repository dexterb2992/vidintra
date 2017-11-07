<template>
    <video class="video-holder" width="400" v-if="video" controls>
        <source :src="video" class="video-preview">
        Your browser does not support HTML5 video.
    </video>
</template>

<script>
    export default {
        props: {
            preview: {
                type: [String, File],
                default: null
            },
            baseUrl: {
                default: '/'
            }
        },
        data() {
            return {
                video: null
            }
        },
        created() {
            this.setPreview()
            console.log("baseUrl: "+this.baseUrl);
        },
        watch: {
            'preview': 'setPreview'
        },
        methods: {

            setPreview() {
                console.log(this.preview);
                if(this.preview instanceof File ) {
                    this.video = URL.createObjectURL(this.preview);
                    console.log(this.video);
                    // $('.video-preview').parent()[0].load();
                    $(document).find('.video-holder')[0].load();
                } else if (typeof this.preview === 'string') {
                    this.video = `${this.baseUrl}videos/${this.preview}`
                } else {
                    this.video = null
                }
            },
            close() {
                this.$emit('close')
            }
        }
    }
</script>

<style lang="scss">
    .video-holder {  margin-top: 12px; }
</style>