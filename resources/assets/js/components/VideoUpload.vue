<template>
    <div class="form-group video">
        <label>Upload Video</label>
        <input type="file" accept="video/*" @change="upload">
        
        <video-preview :preview="value" @close="$emit('input', null)" :baseUrl="baseUrl"></video-preview>
    </div>
</template>

<script>
import VideoPreview from './VideoPreview.vue'

export default {
    components: {
        VideoPreview
    },
    props: {
        value: {
            type: [String, File],
            default: null
        },
        baseUrl: {
            default: '/'
        }
    },
    methods: {
        upload(e) {
            const files = e.target.files

            if (files && files.length > 0) {
                this.$emit('input', files[0]);

            }
           
        }
    }
}
</script>
