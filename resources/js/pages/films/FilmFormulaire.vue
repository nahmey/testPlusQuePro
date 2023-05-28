<template>
	<form  class="form" @submit.prevent="update()" v-if="!first_loading">
		<div class="d-flex flex-wrap">
			<div class="col-12 col-md-8 d-flex flex-wrap">
				<div class="col-12 col-md-6 p-2">
					<label class="form-label" for="form_film_title">Titre du film<span class="text-danger">*</span></label>
					<input type="text" id="form_film_title" class="form-control" v-model="film.title" :disabled="show_view">
				</div>
				<div class="col-12 col-md-6 p-2">
					<label class="form-label" for="form_film_release_date">Date de sortie</label>
					<input type="text" id="form_film_release_date" class="form-control" v-model="film.release_date" :disabled="show_view">
				</div>
				<div class="col-12 p-2">
					<label class="form-label" for="form_film_overview">Description</label>
					<textarea type="text" id="form_film_overview" class="form-control" rows="10" :disabled="show_view" v-model="film.overview"></textarea>
				</div>
				<div class="col-12 col-md-6 p-2">
					<label class="form-label" for="form_film_tagline">Slogan</label>
					<input type="text" id="form_film_tagline" class="form-control" v-model="film.tagline" :disabled="show_view">
				</div>
				<div class="col-12 col-md-6 p-2">
					<label class="form-label" for="form_film_status">Statut</label>
					<input type="text" id="form_film_status" class="form-control" v-model="film.status" :disabled="show_view">
				</div>

			</div>

			<div class="col-12 col-md-4 p-4">
				<img :alt="film.title" :src="poster_base_path+film.poster_path" class="img-fluid">
			</div>
		</div>

		<hr>

		<div class="d-flex flex-wrap">
			<p>Autres Informations</p>

			<div class="col-12 d-flex flex-wrap">
				<div class="col-12 col-md-6 col-md-6 p-2">
					<label class="form-label" for="form_film_genres">Genres</label>
					<Multiselect
						:disabled="show_view"
						v-model="film.genres"
						:options="props.data.genres"
						label="name"
						placeholder="Sélection"
						selectLabel=""
						:searchable="true" 
		                :allow-empty="true"
		                mode="tags"
		                valueProp="id"
		                id="form_film_genres"
					/>
				</div>

				<div class="col-12 col-md-6 p-2">
					<label class="form-label" for="form_film_entreprises">Entreprise</label>
					<Multiselect
						:disabled="show_view"
						v-model="film.entreprises"
						:options="props.data.entreprises"
						label="name"
						placeholder="Sélection"
						selectLabel=""
						:searchable="true" 
		                :allow-empty="true"
		                mode="tags"
		                valueProp="id"
		                id="form_film_entreprises"
					/>
				</div>

				<div class="col-12 col-md-6 p-2">
					<label class="form-label" for="form_film_langages">Langages</label>
					<Multiselect
						:disabled="show_view"
						v-model="film.langages"
						:options="props.data.langages"
						label="name"
						placeholder="Sélection"
						selectLabel=""
						:searchable="true" 
		                :allow-empty="true"
		                mode="tags"
		                valueProp="id"
		                id="form_film_langages"
					/>
				</div>

				<div class="col-12 col-md-6 p-2">
					<label class="form-label" for="form_film_pays">Pays</label>
					<Multiselect
						:disabled="show_view"
						v-model="film.pays"
						:options="props.data.pays"
						label="name"
						placeholder="Sélection"
						selectLabel=""
						:searchable="true" 
		                :allow-empty="true"
		                mode="tags"
		                valueProp="id"
		                id="form_film_pays"
					/>
				</div>
			</div>
		</div>

		<div class="mt-4">
			<SubmitFormButton
			:save_button="show_view === true ? false : true"
			:url_retour="'/'"
			:submit_form="loading ? 'on' : 'off'"
			></SubmitFormButton>
		</div>

	</form>
</template>

<script setup>
import { ref, inject, onMounted } from 'vue';
import { useRoute } from "vue-router";
import SubmitFormButton from '@/components/utilities/SubmitFormButtonComponent.vue';
import Multiselect from '@vueform/multiselect';
import "@vueform/multiselect/themes/default.css";

const props = defineProps(['show_view', 'data']);
const emit = defineEmits(['updateFilm']);
const poster_base_path = "https://image.tmdb.org/t/p/original";
const convertDate = inject('convertDate');
const base_url = inject('base_url');
const film = ref(null);
const first_loading = ref(true);
const loading = ref(true);
const route = useRoute();


const update = () =>
{
	if(route.name === 'film.edit'){
		emit('updateFilm', film.value);
	}
}

onMounted(() => {
	film.value = props.data.film;
	film.value.release_date = convertDate(film.value.release_date);
	loading.value = false;
	first_loading.value = false;
})


</script>