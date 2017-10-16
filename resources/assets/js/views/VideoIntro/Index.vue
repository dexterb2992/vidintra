<template>
    <div>
        <div class="recipe__list">
            <div class="recipe__item" v-for="(intro, key) in intros">
                <router-link class="recipe__inner" :to="`/video-intros/${intro.id}/edit`" :id="'item_'+key">
                    <iframe width="298" height="240" :src="`//youtube.com/embed/${intro.youtube_id}`" v-if="intro.youtube_id != null && intro.youtube_id != ''"></iframe>
                    <video v-if="intro.video_source != '' && intro.video_source != null" width="298" height="240" controls>
                        <source :src="`/videos/${intro.video_source}`" type="video/mp4">
                    </video>
                    <p class="recipe__name">{{intro.name}}</p>
                </router-link>
                <a @click="$emit('delete', key)" class="btn btn-sm btn-danger btn-delete pull-right">
                    <i class="glyphicon glyphicon-remove"></i>
                </a>
            </div>
        </div>
        <div v-if="intros.length == 0">
            <div class="alert alert-info">You currently don't have any Video Intro. Add one now!</div>
        </div>
    </div>
</template>
<script type="text/javascript">
    import { get, del } from '../../helpers/api'
    import Flash from '../../helpers/flash'
    import { scrollToTop } from '../../helpers/helper'

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
        },

        mounted() {
            this.$on('delete', function (key) {
                if (confirm("Are you sure to delete this?")) {
                    var id = this.intros[key].id;
                    del('/api/video-intros/'+id)
                        .then((res) => {
                            if(res.data.deleted) {
                                Flash.setSuccess("Successfully deleted.")
                                this.intros.splice(key, 1);
                                scrollToTop();
                            }
                            
                        });
                }
            })
        }
    }
</script>
