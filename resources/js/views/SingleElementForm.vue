<template>
    <form class="form-inline" @submit.prevent="$emit('on-submit', form)">
        <slot></slot>
        <div class="form-inline__buttons">
            <button class="form-inline__button-save"  type="submit">Save</button>
            <button class="form-inline__button-cancel" @click="$emit('on-cancel', form)" >+</button>
        </div>
    </form>
</template>
<script>
export default {
    name: 'SingleElementForm',
    props: ['jj'],
    data() {
        return {
            form: {
                email: this.user?.email || "",
                name: this.user?.name || "",
            },
        };
    },
    methods: {
        hi(){console.log(1111)},
    }
}
</script>
