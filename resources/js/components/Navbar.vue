<template>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<div class="container-fluid">
			<a class="navbar-brand" href="#">Navbar</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav me-auto mb-2 mb-lg-0">
					<router-link to="/" class="nav-link active">
						Accueil
					</router-link>
				</ul>
				<form class="d-flex">
			        <button class="btn btn-outline-danger" @click.prevent="logout()">
			        	Deconnexion
			        </button>
			    </form>
			</div>
		</div>
	</nav>
</template>

<script setup>
import { inject } from 'vue';

const base_url = inject('base_url');

const logout = () =>
{
	axios.post(base_url+'/logout')
	.then(response => response.data)
	.then(data => {
		return window.location = base_url
	})
	.catch((error) => {
		console.log(error)
	});
}

</script>