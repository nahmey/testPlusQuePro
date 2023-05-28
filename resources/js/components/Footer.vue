<template>
	<div class="footer py-4 d-flex flex-lg-column">
		<div class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
			<div class="text-dark order-2 order-md-1">
				<span class="text-muted fw-semibold me-1">{{moment().format('YYYY')}}&copy;</span>
				<a href="https://cen-lorraine.fr/" target="_blank" class="text-gray-800 text-hover-primary">Footer</a>
			</div>
		</div>
	</div>
</template>

<script setup>
import moment from 'moment';

</script>