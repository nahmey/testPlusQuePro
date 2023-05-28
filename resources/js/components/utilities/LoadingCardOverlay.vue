<template>
	<div :class="props.loading ? 'card overlay overlay-block' : 'card h-100 '+props.background_class">
		<slot></slot>

		<div class="overlay-layer card-rounded bg-dark bg-opacity-5" v-if="props.loading">
            <div class="spinner-border text-primary spinner-fixed" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
	</div>
</template>

<script setup>
const props = defineProps(['loading', 'background_class']);
</script>