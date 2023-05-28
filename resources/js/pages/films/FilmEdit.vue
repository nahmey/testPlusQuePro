<template>
	<loading-card-overlay :loading="loading">
        <div class="card-header">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <h1>Détails du film</h1>
                <router-link to="/" class="btn btn-secondary">
                    <i class="fa-solid fa-rotate-left"></i> Retour
                </router-link>
            </div>
        </div>

        <div class="card-body">
            <FilmFormulaire 
            v-if="!loading"
            :data="all_data"
            v-on:updateFilm="updateFilm"
            >
            </FilmFormulaire>
        </div>
    </loading-card-overlay>
</template>

<script setup>
import { ref, onMounted, inject } from 'vue';
import { useRoute, useRouter } from "vue-router";
import FilmFormulaire from '@/pages/films/FilmFormulaire.vue';

const showSuccessErrors = inject('showSuccessErrors');
const parseErrorMessage = inject('parseErrorMessage');
const route = useRoute();
const router = useRouter();
const loading = ref(true);
const base_url = inject('base_url');
const all_data = ref(null);

const updateFilm = (update_film) =>
{
    axios.put(base_url+'/films/'+update_film.id, update_film)
    .then(response => response.data)
    .then(data => {
        if(data.error == true){
            loading.value = false;
            showSuccessErrors(parseErrorMessage(data.message), 'error');
        }else{
            showSuccessErrors(data.message);
            return router.push({path: '/'});
        }
        return loading.value = false;
    })
    .catch((error) => {
        loading.value = false;
    })
}

const loadFilm = () =>
{
	axios.get(base_url+'/films/'+route.params.id+'/edit')
    .then(response => response.data)
    .then(data => {
    	all_data.value = data;
        loading.value = false;
    })
    .catch((error) => {
        loading.value = false;
    })
}

onMounted(() =>{
	loadFilm();
})

</script>