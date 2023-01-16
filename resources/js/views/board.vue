<template xmlns="http://www.w3.org/1999/html">
    <div class="board">
        <div class="board__heading">
            Welcome to my Kanban board built with Laravel, Vue.js & SCSS.
        </div>
        <div class="board__body">
            <Column v-for="column in columns" :key="column.id" :column="column" @delete-column="deleteColumn" />
            <div class="form-toggle">
                <button class="button-faded form-toggle__button--open-form"  @click="toggleAddColumn" v-show="!newColumnClicked">+ Add column</button>
                <SingleElementForm v-show="newColumnClicked" @on-cancel="toggleAddColumn" @on-submit="saveNewColumn">
                    <textarea class="form-inline__input--text-long" v-model="newColumnTitle" placeholder="Column title"></textarea>
                </SingleElementForm>
            </div>
        </div>
    </div>
</template>
<script>
    import Column from '../views/column.vue'
    import axios from 'axios'
    import SingleElementForm from "./SingleElementForm.vue";

    export default {
        name: "board",
        computed: {},
        data() {
            return {
                columns: [],
                newColumnClicked: false,
                newColumnTitle: ''
            }
        },
        created() {
            this.fetchColumns();
        },

        methods: {
            fetchColumns(){
                axios.get('/api/columns')
                    .then(response => (this.columns = response.data.data))
                    .catch(error => (console.log(error)));
            },
            toggleAddColumn(){
                this.newColumnClicked = !this.newColumnClicked;
            },
            saveNewColumn(){
                this.newColumnClicked = false;
                axios.post('/api/columns', {
                    title: this.newColumnTitle
                })
                    .then(response => {
                        this.newColumnTitle = '';
                        console.log(response);
                        this.columns.push(response.data.data);
                    })
                    .catch(error => (console.log(error)));
            },
            deleteColumn(column){
                axios.delete('/api/columns/'+column.id)
                    .then(response => {
                        console.log(response);
                        this.columns = this.columns.filter((val) => (val.id !== column.id));
                    })
                    .catch(error => (console.log(error)));
            },
        },

        components: {
            SingleElementForm,
            Column
        }
    };
</script>
