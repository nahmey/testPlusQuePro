<template>
	<div class="container-fuid">

		<Navbar></Navbar>

		<div class="container-fluid p-4">
			<router-view v-slot="{ Component }">
				<transition name="fade" mode="out-in">
					<component :is="Component" :key="$route.path"/>
				</transition>
			</router-view>
		</div>
	</div>
</template>

<script setup>
import Navbar from '@/components/Navbar.vue';

</script>