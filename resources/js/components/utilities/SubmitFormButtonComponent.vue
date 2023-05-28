<template>
	<div class="d-flex justify-content-end">
		<router-link :to="props.url_retour" class="btn btn-light me-3">Retour</router-link>

		<button type="submit" class="btn btn-primary" v-if="save_button">
			<span class="indicator-label" v-if="submit_form === 'off'">Enregistrer</span>
			<span class="indicator-progress" v-else>Merci de patienter
			<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
		</button>
		<!--end::Button-->
	</div>
</template>

<script setup>
const props = defineProps(['save_button', 'url_retour', 'submit_form'])
</script>