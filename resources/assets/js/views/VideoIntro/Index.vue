<template>
    <div class="recipe__list">
        <div class="recipe__item" v-for="intro in intros">
            <router-link class="recipe__inner" :to="`/video-intros/${intro.id}/edit`">
                <iframe width="298" height="240" :src="`//youtube.com/embed/${intro.youtube_id}`" v-if="intro.youtube_id != null && intro.youtube_id != ''"></iframe>
                <video v-if="intro.video_source != '' && intro.video_source != null" width="298" height="240" controls>
                    <source :src="`/videos/${intro.video_source}`" type="video/mp4">
                </video>
                <p class="recipe__name">{{intro.slug}}</p>
            </router-link>
        </div>
    </div>
</template>
<script type="text/javascript">
    import { get } from '../../helpers/api'
    export default {
        data() {
            return {
                intros: []
            }
        },
        created() {
            get('/api/video-intros')
                .then((res) => {
                    this.intros = res.data.intros
                })
        }
    }
</script>
