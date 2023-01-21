<template>
    <form class="form-inline" @submit.prevent="$emit('on-submit')">
        <slot></slot>
        <div class="form-inline__buttons">
            <button class="form-inline__button-save"  type="submit">Save</button>
            <button class="form-inline__button-cancel" @click="$emit('on-cancel')" >+</button>
        </div>
    </form>
</template>
<script>
export default {
    name: 'SingleElementForm',
    props: [],
    data() {
        return {}
    },
    methods: {}
}
</script>
