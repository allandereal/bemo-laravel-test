<template>
    <div class=column-wrapper>
        <div class="column">
            <div class="column__header">
                <h3 class="column__header--text">{{ column.title }}</h3>
                <button class="column__header--button-delete" @click="emitDeleteColumnEvent()">+</button>
            </div>
            <div class="column__body">
                <draggable style="min-height: 2rem" v-model="cards" group="cards" :move="onMove" @change="onChange" @start="drag=true" >
                    <transition-group type="transition" :name="'flip-list'">
                        <Card v-for="card in cards" :key="card.id" :board-card="card" />
                    </transition-group>
                </draggable>
            </div>
            <div class="column__footer">
                <button class="button-basic column__footer--button-add" v-show="!addCardClicked" @click="toggleAddCard">+ Add card</button>
                <SingleElementForm v-show="addCardClicked" @on-cancel="toggleAddCard" @on-submit="saveNewCard">
                    <textarea class="form-inline__input--text-long" v-model="newCardTitle" placeholder="Card title"></textarea>
                </SingleElementForm>
            </div>
        </div>
    </div>
</template>

<script>
    import Card from '../views/card.vue'
    import axios from "axios";
    import Draggable from 'vuedraggable'
    import SingleElementForm from "./SingleElementForm.vue";

    export default {
        name: "Column",
        props: ['column'],
        data() {
            return {
                drag: false,
                delayedDragging: false,
                newCardTitle: '',
                addCardClicked: false,
                cards: this.column.cards
            }
        },
        methods: {
            onMove({ relatedContext, draggedContext }) {
                //console.log(this.drag);
                const relatedElement = relatedContext.element;
                const draggedElement = draggedContext.element;
                //console.log(relatedElement, draggedElement)
            },
            onChange(el){
                let ordered_cards = {};
                if (el.moved || el.added){

                    if (el.added){
                        this.cards[el.added.newIndex].column_id = this.column.id
                    }

                    ordered_cards = this.cards.map( (val, key) => {
                        return {id: val.id, column_id: val.column_id, position: key + 1};
                    });

                    axios.post('/api/cards/swap-positions', {ordered_cards: ordered_cards})
                        .then(response => {
                            // this.newCardTitle = '';
                            // console.log(response.data.data);
                            // this.cards.push(response.data.data);
                        })
                        .catch(error => (console.log(error)));
                }
            },
            emitDeleteColumnEvent(){
                this.$emit('delete-column', this.column);
            },
            toggleAddCard(){
                this.addCardClicked = !this.addCardClicked;
            },
            saveNewCard(){
                this.addCardClicked = false;
                axios.post('/api/cards', {
                    title: this.newCardTitle,
                    description: '',
                    column_id: this.column.id
                })
                    .then(response => {
                        this.newCardTitle = '';
                        console.log(response.data.data);
                        this.cards.push(response.data.data);
                    })
                    .catch(error => (console.log(error)));
            }
        },
        watch: {
            drag(newValue) {
                if (newValue) {
                    this.delayedDragging = true;
                    return;
                }
                this.$nextTick(() => {
                    this.delayedDragging = false;
                });
            }
        },
        components: {
            SingleElementForm,
            Card,
            draggable
        }
    }
</script>

<style scoped>
.flip-list-move {
    transition: transform 0.5s;
}

.no-move {
    transition: transform 0s;
}
</style>
