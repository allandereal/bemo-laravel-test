<template>
  <div class="heading">
    {{message}}
  </div>
</template>
<script>
const default_layout = "default";


export default {
  computed: {},
  data() {
      return {
          message:'Welcome to my Kanban board built with Laravel, Vue.js & SCSS.'
      }
  }
};
</script>
