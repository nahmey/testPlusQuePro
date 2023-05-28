import { ref, onMounted, onUnmounted } from 'vue';

export function usePagination(perPageProps, currentSortProps) {

	/*
	 * Variables
	 */
	const pages = ref(0);
	const page = ref(1);
	const per_page = perPageProps ? ref(perPageProps) : ref(5);
	const current_sort = currentSortProps ? ref(currentSortProps) : ref('title');
	const current_sort_dir = ref('asc');


	const changePage = (val) =>
	{
		page.value = val;
	}

	const checkPages = (event) =>
	{
	    per_page.value = event;
	}

	const checkCurrentSortDir = (event) =>
	{
	    current_sort_dir.value = event;
	}

	const checkCurrentSort = (event) =>
	{
	    current_sort.value = event;
	}

	return {
		pages,
		page,
		current_sort,
		current_sort_dir,
		// perPage,
		per_page,
		changePage,
		checkPages,
		checkCurrentSortDir,
		checkCurrentSort,
	}
}