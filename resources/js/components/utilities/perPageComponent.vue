<template>
	<div>
        <select class="form-control" v-on:change="changeNumberPerPage($event)" v-model="perPage">
            <option v-for="nb in nbPerPage" :value="nb" :key="'nbPerPage' + nb">
                {{nb}}
            </option>
        </select>
    </div>
</template>


<script setup>
import { ref } from 'vue';

const props = defineProps(['nbPerPageProps', 'perPageProps']);
const emit = defineEmits(['setPages']);

const nbPerPage = props.nbPerPageProps ? ref(props.nbPerPageProps) : ref([5,10,15]);
const perPage = props.perPageProps ? ref(props.perPageProps) : ref(5);

const changeNumberPerPage = (event) =>
{
    emit('setPages', perPage.value);
}
</script>