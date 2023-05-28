<template>
	<div class="container-fuid">

		<Navbar></Navbar>

		<notifications group="success_error" position="bottom left" width="500" />

		<div class="container mt-4">
			<router-view v-slot="{ Component }">
				<transition name="fade" mode="out-in">
					<component :is="Component" :key="$route.path"/>
				</transition>
			</router-view>
		</div>

		<FooterComponent></FooterComponent>

	</div>
</template>

<script setup>
import Navbar from '@/components/Navbar.vue';
import FooterComponent from '@/components/Footer.vue';

</script>