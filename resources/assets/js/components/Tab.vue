<template>
  
    <div role="tabpanel" class="tab-pane active" v-show="isActive">
        <div class="well">
            <slot></slot>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            name: {required: true},
            selected: {default: false}
        },
        data() {
            return {
                isActive: false
            }
        },
        computed: {
            href() {
                return "#" + this.name.toLowerCase().replace(/ /g, '-');
            }
        },
        mounted() {
            this.isActive = this.selected
        }
    }
</script>