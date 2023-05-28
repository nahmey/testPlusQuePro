<template>
	<div :class="loading ? 'card overlay overlay-block' : 'card h-100 '+background_class">
		<slot></slot>

		<div class="overlay-layer card-rounded bg-dark bg-opacity-5" v-if="loading">
            <div class="spinner-border text-primary spinner-fixed" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
	</div>
</template>

<script>
export default{
	props: ['loading', 'background_class']
}
</script>