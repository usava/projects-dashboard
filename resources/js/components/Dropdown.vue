<template>
    <div class="dropdown">
        <div class="dropdown-toggle"
             aria-haspopup="true"
             :aria-expanded="isOpen"

             @click.prevent="isOpen = !isOpen">
            <slot name="trigger"></slot>
        </div>

        <div v-show="isOpen"
             class="dropdown-menu absolute bg-card py-2 rounded shadow mt-2"
             :class="align + '-0'"
             :style="{ width }">
            <slot></slot>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            align: {default: 'left'},
            width: {default: 'auto'}
        },
        data() {
            return {isOpen: false}
        },
        watch: {
            isOpen(isOpen) {
                if (isOpen) {
                    document.addEventListener('click', this.closeIfClickedOutside);
                }
            }
        },
        methods: {
            closeIfClickedOutside(event) {
                if(! event.target.closest('.dropdown')) {
                    this.isOpen = false;

                    document.removeEventListener('click', this.closeIfClickedOutside);
                }
            }
        }
    }
</script>
