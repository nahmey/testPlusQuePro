<template>
	<loading-card-overlay :loading="loading">
		<div class="card-header">
			<div class="d-flex flex-wrap justify-content-between align-items-center">
				<h1>Liste des films</h1>

				<div class="ps-4">
					<div class="d-flex align-items-center">
						<span class="me-1">Par page</span>
						<PerPage
						:perPageProps="per_page"
						:nbPerPageProps="[5,10,15]"
						v-on:setPages="checkPages"
						>
						</PerPage>
					</div>
				</div>
			</div>
		</div>

		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
					<thead>
						<tr class="fw-bold text-muted">
							<th style="width: 30%">
		                        <tableSortButton
		                        v-bind:keyProps="'title'" 
		                        v-bind:nameProps="'Film'" 
		                        v-bind:currentSortProps="current_sort"
		                        v-bind:currentSortDirProps="current_sort_dir"
		                        v-on:currentSortDir = "checkCurrentSortDir"
		                        v-on:currentSort = "checkCurrentSort"
		                        ></tableSortButton>
		                    </th>
		                    <th style="width: 45%">
		                    	Aperçu
		                    </th>
		                    <th style="width: 10%">
		                    	<tableSortButton
		                        v-bind:keyProps="'release_date'" 
		                        v-bind:nameProps="'Date de sortie'" 
		                        v-bind:currentSortProps="current_sort"
		                        v-bind:currentSortDirProps="current_sort_dir"
		                        v-on:currentSortDir = "checkCurrentSortDir"
		                        v-on:currentSort = "checkCurrentSort"
		                        ></tableSortButton>
		                    </th>
		                    <th style="width: 15%" class="text-end">
		                    	Actions
		                    </th>
		                </tr>
					</thead>

					<tbody>
						<tr v-for="film in films">
							<td data-label="Job Title">
								<div class="d-flex">
									<img :alt="film.title" :src="poster_base_path+film.poster_path" class="col-2 avatar avatar-sm me-2 img-fluid">
									<router-link :to="'/film/'+film.id">
										{{film.title}}
									</router-link>
								</div>
							</td>
							<td data-label="Email">
								{{film.overview}}
							</td>
							<td data-label="Phone">
								{{convertDate(film.release_date)}}
							</td>
							<td class="text-end">
								<router-link class="btn btn-primary btn-sm m-1" :to="'/film/'+film.id">
									<i class="fa-solid fa-eye"></i>
								</router-link>
								<router-link class="btn btn-secondary btn-sm m-1" :to="'/film/edit/'+film.id">
									<i class="fa-solid fa-pen-to-square"></i>
								</router-link>
								<button class="btn btn-danger btn-sm m-1" @click.prevent="confirmDeleteFilm(film.id)">
									<i class="fa-solid fa-trash-can"></i>
								</button>
							</td>
						</tr>
					</tbody>
				</table>

				<lPagination
	            :pageProps="page"
	            :pagesProps="pages"
	            :perPageProps="per_page"
	            :lightPaginationProps="false"
	            v-on:changePage="changePage"
	            >
	            </lPagination>

			</div>
		</div>
	</loading-card-overlay>
</template>


<script setup>
import { ref, onMounted, inject, watch } from 'vue';
import { usePagination } from '@/components/utilities/paginate.js';
import tableSortButton from '@/components/utilities/tableSortButton.vue';
import lPagination from '@/components/utilities/lPagination.vue';
import PerPage from '@/components/utilities/perPageComponent.vue';
import Swal from 'sweetalert2'

const base_url = inject('base_url');
const convertDate = inject('convertDate');
const films = ref(null);
const poster_base_path = "https://image.tmdb.org/t/p/original";
const loading = ref(true);
const showSuccessErrors = inject('showSuccessErrors');

let {
	pages,
	page,
	current_sort,
	current_sort_dir,
	per_page,
	changePage,
	checkPages,
	checkCurrentSortDir,
	checkCurrentSort,
} = usePagination();

const confirmDeleteFilm = (film_id) =>
{
	Swal.fire({
		title: "Supprimer un film ?",
		text: "Souhaitez-vous vraiment supprimer ce film ? La suppression est irréversible !",
		icon: 'question',
		confirmButtonText:'<i class="fa fa-thumbs-up"></i> Oui!',
		confirmButtonAriaLabel: 'Oui',
		confirmButtonColor: '#28a745',
		showCancelButton: true,
		cancelButtonText:'<i class="fa fa-thumbs-down"></i> Non',
		cancelButtonAriaLabel: 'Non',
		cancelButtonColor: '#dc3545',
	}).then((result) => {
		if(result.isConfirmed) {
			deleteFilm(film_id);
		}
	})
}

const deleteFilm = (film_id) =>
{
	// console.log(film_id);
	axios.delete(base_url + '/films/' + film_id , {params: {'id': film_id}})
	.then((response) => {
        if(response.data.error == false){
            showSuccessErrors(response.data.message);
            loadFilms();
        }else{
            showSuccessErrors(response.data.message, 'error');
        }
    }, (error) => {
        console.log(error)
    });
}

const loadFilms = () =>
{
	loading.value = true;
	let route = base_url+'/films?';
	let params = 'page='+page.value+'&per_page='+per_page.value+'&current_sort='+current_sort.value+'&current_sort_dir='+current_sort_dir.value;

	axios.get(route+params)
	.then(response => response.data)
	.then(data => {
		films.value = data.films.data;
        page.value = data.films.current_page;
        pages.value = data.films.last_page;
        per_page.value = data.films.per_page;
        loading.value = false;
	})
	.catch((error) => {
		console.log(error)
	});
}

/*
 * Watch
 */
watch([page, per_page, current_sort, current_sort_dir], () => {
	return loadFilms();
});

onMounted(() =>{
	loadFilms();
})


</script>