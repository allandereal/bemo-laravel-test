<template>
    <div class="modal">
        <h3 class="modal__heading" v-show="!titleClicked" @click="titleClicked = true">{{ card.title }}</h3>
        <SingleElementForm v-show="titleClicked" @on-cancel="toggleEditTitleClicked" @on-submit="updateCardTitle">
            <textarea class="form-inline__input--text-long" v-model="cardTitle" ></textarea>
        </SingleElementForm>
        <div>
            <h4>Description</h4>
            <button v-show="hasDescription && !editDescriptionClicked" @click="editDescriptionClicked = true">edit</button>
            <p v-show="!editDescriptionClicked" @click="editDescriptionClicked = true" class="">{{ card.description ? card.description : 'Add detailed description' }}</p>
            <SingleElementForm v-show="editDescriptionClicked" @on-cancel="toggleEditDescriptionClicked" @on-submit="updateCardDescription">
                <textarea class="form-inline__input--text-long" v-model="cardDescription" placeholder="Describe this card"></textarea>
            </SingleElementForm>
        </div>
    </div>
</template>

<script>
    import axios from "axios";
    import SingleElementForm from "./SingleElementForm.vue";

    export default {
        name: "CardModal",
        props: ['card'],
        data() {
            return {
                hasDescription: !!this.card.description,
                cardDescription: this.card.description,
                editDescriptionClicked: false,
                titleClicked: false,
                cardTitle: this.card.title
            }
        },
        methods: {
            updateCardDescription(){
                this.editDescriptionClicked = false;
                axios.put('/api/board-cards', {
                    id: this.card.id,
                    description: this.cardDescription
                })
                    .then(response => {
                        console.log(response);
                        this.card.description = this.cardDescription
                    })
                    .catch(error => (console.log(error)));
            },
            toggleEditDescriptionClicked(){
                this.editDescriptionClicked = !this.editDescriptionClicked;
            },
            toggleEditTitleClicked(){
                this.editTitleClicked = !this.editTitleClicked;
            },
            updateCardTitle(){
                this.titleClicked = false;
                axios.put('/api/board-cards', {
                    id: this.card.id,
                    title: this.cardTitle
                })
                    .then(response => {
                        console.log(response);
                        this.card.title = this.cardTitle
                    })
                    .catch(error => (console.log(error)));
            }
        },
        components: {
            SingleElementForm,
        }
    }
</script>

<style scoped>

</style>
