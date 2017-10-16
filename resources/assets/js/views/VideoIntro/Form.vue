<template>
    <div>
        <div class="panel panel-info">
            <div class="panel-heading">
                <h4>{{action}} Video Intro</h4>
                <a class="btn btn-success pull-right btn-circle" data-toggle="tooltip" data-original-title="Preview" v-show="form.id != undefined" :href="previewUrl" target="_blank">
                    <i class="glyphicon glyphicon-eye-open"></i>
                </a>
            </div>
            <div class="panel-body">
                <form class="form">
                    <tabs>
                        <tab name="General" :selected="true">
                            <div class="form-group">
                                <label>Choose the source of your video</label>
                                <select v-model="videoBaseSource" class="form-control">
                                    <option value="Upload">Upload</option>
                                    <option value="Youtube">Youtube</option>
                                </select>
                            </div>
                            <div class="form-group" v-if="videoBaseSource=='Youtube'">
                                <label>Enter youtube URL/Video ID: </label>
                                <input class="form-control" type="text" v-model="form.youtube_id">
                                <small class="error__control" v-if="error.youtube_id">{{error.youtube_id[0]}}</small>
                            </div>
                            <div class="form-group" v-if="videoBaseSource=='Upload'">
                                <video-upload v-model="form.video_source"></video-upload>
                            </div>
                            <div class="form-group">
                                <label>URL to Redirect</label>
                                <input type="url" v-model="form.url_to_redirect" class="form-control">
                                <small class="error__control" v-if="error.url_to_redirect">{{error.url_to_redirect[0]}}</small>
                            </div>
                            <div class="form-group">
                                <label>Slug</label>
                                <input type="text" v-model="form.slug" class="form-control">
                                <small class="error__control" v-if="error.slug">{{error.slug[0]}}</small>

                            </div>
                            <div class="form-group">
                                <label>Logo</label>
                                <div class="recipe__image">
                                    <div class="recipe__box">
                                        <image-upload v-model="form.logo_img"></image-upload>
                                        <small class="error__control" v-if="error.logo_img">{{error.image[0]}}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Enable Skip Intro Text</label>
                                <input type="checkbox" v-model="form.skipintro_is_enabled" value="0">
                                <small class="error__control" v-if="error.skipintro_is_enabled">{{error.skipintro_is_enabled[0]}}</small>
                            </div>
                            <div class="form-group" v-if="form.skipintro_is_enabled">
                                <label>Skip Intro Text</label>
                                <input type="text" v-model="form.skipintro_text" class="form-control">
                                <small class="error__control" v-if="error.skipintro_text">{{error.skipintro_text[0]}}</small>
                            </div>
                            <div class="form-group">
                                <label>Action after video ends</label>
                                <select v-model="form.action_after_end" class="form-control">
                                    <option value="redirect">Redirect</option>
                                    <option value="loop">Loop</option>
                                </select>
                                <small class="error__control" v-if="error.action_after_end">{{error.action_after_end[0]}}</small>
                            </div>
                        </tab>
                        <tab name="More Settings">
                            <div class="form-group">
                                <label>Bottom Text (Right)</label>
                                <textarea class="form-control" v-model="form.bottom_text_right" id="bottom_text_right"></textarea>
                                <small class="error__control" v-if="error.bottom_text_right">{{error.bottom_text_right[0]}}</small>
                            </div>

                            <div class="form-group">
                                <label>Bottom Text (Left)</label>
                                <textarea class="form-control" v-model="form.bottom_text_left" id="bottom_text_left"></textarea>
                                <small class="error__control" v-if="error.bottom_text_left">{{error.bottom_text_left[0]}}</small>
                            </div>
                           
                        </tab>
                    </tabs>
                </form>
            </div>
            <div class="panel-footer">
                <div>
                    <button class="btn btn-primary pull-right" @click="save" :disabled="isProcessing">
                        <i class="glyphicon glyphicon-ok"></i> Save
                    </button>
                    <button class="btn" @click="$router.back()">
                        <i class="glyphicon glyphicon-remove"></i> Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
    import Vue from 'vue'
    import Flash from '../../helpers/flash'
    import { get, post } from '../../helpers/api'
    import { toMultiPartedForm } from '../../helpers/form'
    import VideoUpload from '../../components/VideoUpload.vue'
    import ImageUpload from '../../components/ImageUpload.vue'
    import Tab from '../../components/Tab.vue'
    import Tabs from '../../components/Tabs.vue'

    export default {
        components: {
            VideoUpload,
            ImageUpload,
            Tab,
            Tabs
        },
        data() {
            return {
                form: {

                },
                error: {},
                isProcessing: false,
                initializeURL: `/api/video-intros/create`,
                storeURL: `/api/video-intros`,
                action: 'Create',
                videoBaseSource: '',
                ckeditorToolbar: [[ 'Format', 'Bold', 'Link' ]]
            }
        },
        created() {
            if(this.$route.meta.mode === 'edit') {
                this.initializeURL = `/api/video-intros/${this.$route.params.id}/edit`
                this.storeURL = `/api/video-intros/${this.$route.params.id}?_method=PUT`
                this.action = 'Update'
            }

            this.previewUrl = `/video-intros/${this.$route.params.id}`;

            get(this.initializeURL).then((res) => {
                Vue.set(this.$data, 'form', res.data.form);

                if(res.data.form.video_source != "" && res.data.form.video_source != null) {
                    this.videoBaseSource = 'Upload';
                    console.log(this.form.video_source);
                }

                if(res.data.form.youtube_id != "" && res.data.form.youtube_id != null) {
                    this.videoBaseSource = 'Youtube';
                }

                if(res.data.form.bottom_text_left == null) {
                    res.data.form.bottom_text_left = '© Copyright 2017 – John Doe';
                }

                if(res.data.form.bottom_text_right == null) {
                    res.data.form.bottom_text_right = `1-800-555-9274   your@email.com   <a href="http://facebook.com/my-fb-acct">Facebook</a>  <a href="http://twitter.com/my-twitter-acct">Twitter</a>`;
                }

                CKEDITOR.replace('bottom_text_right');
                CKEDITOR.replace('bottom_text_left');

                $('[data-toggle="tooltip"]').tooltip();
            });
        },
        methods: {
            save() {
                this.form.bottom_text_right = CKEDITOR.instances['bottom_text_right'].getData();
                this.form.bottom_text_left = CKEDITOR.instances['bottom_text_left'].getData();
                console.log(this.form);
                const form = toMultiPartedForm(this.form, this.$route.meta.mode)
                post(this.storeURL, form)
                    .then((res) => {
                        if(res.data.saved) {
                            Flash.setSuccess(res.data.message)
                            // this.$router.push(`/video-intros/${res.data.id}`)
                            // window.location.href="/video-intros/"+res.data.id;
                            $("html, body").animate({
                                scrollTop: 0
                            }, 600);
                        }
                        this.isProcessing = false
                    })
                    .catch((err) => {
                        if(err.response.status === 422) {
                            this.error = err.response.data.errors
                        }
                        this.isProcessing = false
                    });
            }
        },
    }
</script>
