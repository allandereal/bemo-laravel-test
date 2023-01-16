import Vue from 'vue'

//Main pages
import Board from './views/board.vue'

import VModal from 'vue-js-modal'
Vue.use(VModal)

const app = new Vue({
    el: '#app',
    components: { Board }
});
