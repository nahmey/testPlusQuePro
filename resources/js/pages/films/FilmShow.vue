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
            :show_view="true">
                
            </FilmFormulaire>
        </div>
    </loading-card-overlay>
</template>

<script setup>
import { ref, onMounted, inject } from 'vue';
import { useRoute, useRouter } from "vue-router";
import FilmFormulaire from '@/pages/films/FilmFormulaire.vue';

const route = useRoute();
const loading = ref(true);
const base_url = inject('base_url');
const all_data = ref(null);

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
        console.log(error)
    })
}

onMounted(() =>{
	loadFilm();
})

</script>