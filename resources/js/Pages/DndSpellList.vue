<template>
    <Head title="D&D Spell List" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                D&D Spell List
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        
                        <!-- Filters and Search -->
                        <div class="mb-6 space-y-4">
                            <!-- Search Bar -->
                            <div class="flex gap-4">
                                <div class="flex-1">
                                    <input
                                        v-model="searchQuery"
                                        type="text"
                                        placeholder="Search spells by name, description, school, or class..."
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                        @keyup.enter="searchSpells"
                                    />
                                </div>
                                <button
                                    @click="searchSpells"
                                    class="px-4 py-2 text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                >
                                    Search
                                </button>
                                <button
                                    @click="clearFilters"
                                    class="px-4 py-2 text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500"
                                >
                                    Clear
                                </button>
                            </div>

                            <!-- Filter Row -->
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-6">
                                <!-- Level Filter -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Level</label>
                                    <select
                                        v-model="filters.level"
                                        class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                        @change="searchSpells"
                                    >
                                        <option value="">All Levels</option>
                                        <option v-for="level in filterOptions.levels" :key="level" :value="level">
                                            {{ level }}
                                        </option>
                                    </select>
                                </div>

                                <!-- School Filter -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">School</label>
                                    <select
                                        v-model="filters.school"
                                        class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                        @change="searchSpells"
                                    >
                                        <option value="">All Schools</option>
                                        <option v-for="school in filterOptions.schools" :key="school" :value="school">
                                            {{ school }}
                                        </option>
                                    </select>
                                </div>

                                <!-- Class Filter -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Class</label>
                                    <select
                                        v-model="filters.class"
                                        class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                        @change="searchSpells"
                                    >
                                        <option value="">All Classes</option>
                                        <option v-for="spellClass in filterOptions.classes" :key="spellClass" :value="spellClass">
                                            {{ spellClass }}
                                        </option>
                                    </select>
                                </div>

                                <!-- Concentration Filter -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Concentration</label>
                                    <select
                                        v-model="filters.concentration"
                                        class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                        @change="searchSpells"
                                    >
                                        <option value="">All</option>
                                        <option value="true">Yes</option>
                                        <option value="false">No</option>
                                    </select>
                                </div>

                                <!-- Ritual Filter -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ritual</label>
                                    <select
                                        v-model="filters.ritual"
                                        class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                        @change="searchSpells"
                                    >
                                        <option value="">All</option>
                                        <option value="true">Yes</option>
                                        <option value="false">No</option>
                                    </select>
                                </div>

                                <!-- Sort Options -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sort By</label>
                                    <select
                                        v-model="sortBy"
                                        class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                        @change="searchSpells"
                                    >
                                        <option value="name">Name</option>
                                        <option value="level">Level</option>
                                        <option value="school">School</option>
                                        <option value="casting_time">Casting Time</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Results Summary -->
                        <div class="mb-4 flex justify-between items-center">
                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                Showing {{ spells.from || 0 }} to {{ spells.to || 0 }} of {{ spells.total || 0 }} spells
                            </div>
                            <div class="flex items-center gap-2">
                                <label class="text-sm text-gray-600 dark:text-gray-400">Per Page:</label>
                                <select
                                    v-model="perPage"
                                    class="px-2 py-1 border border-gray-300 rounded dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                    @change="searchSpells"
                                >
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                        </div>

                        <!-- Loading State -->
                        <div v-if="loading" class="flex justify-center py-12">
                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-600"></div>
                        </div>

                        <!-- Spell List -->
                        <div v-else class="space-y-4">
                            <div
                                v-for="spell in spells.data"
                                :key="spell.id"
                                class="p-4 border border-gray-200 rounded-lg hover:shadow-md transition-shadow duration-200 dark:border-gray-600 dark:hover:shadow-lg"
                            >
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        {{ spell.name }}
                                    </h3>
                                    <div class="flex gap-2">
                                        <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded dark:bg-blue-900 dark:text-blue-200">
                                            Level {{ spell.level }}
                                        </span>
                                        <span class="px-2 py-1 text-xs font-medium bg-purple-100 text-purple-800 rounded dark:bg-purple-900 dark:text-purple-200">
                                            {{ spell.school }}
                                        </span>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-2 mb-3 text-sm text-gray-600 dark:text-gray-400">
                                    <div><strong>Casting Time:</strong> {{ spell.casting_time }}</div>
                                    <div><strong>Range:</strong> {{ spell.range }}</div>
                                    <div><strong>Duration:</strong> {{ spell.duration }}</div>
                                    <div><strong>Components:</strong> {{ spell.components }}</div>
                                </div>

                                <div class="flex gap-2 mb-3">
                                    <span v-if="spell.concentration" class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded dark:bg-yellow-900 dark:text-yellow-200">
                                        Concentration
                                    </span>
                                    <span v-if="spell.ritual" class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded dark:bg-green-900 dark:text-green-200">
                                        Ritual
                                    </span>
                                    <span v-if="spell.classes" class="px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded dark:bg-gray-700 dark:text-gray-200">
                                        {{ spell.classes }}
                                    </span>
                                </div>

                                <div class="text-sm text-gray-700 dark:text-gray-300 mb-2">
                                    {{ spell.description }}
                                </div>

                                <div v-if="spell.higher_levels" class="text-sm text-gray-600 dark:text-gray-400">
                                    <strong>At Higher Levels:</strong> {{ spell.higher_levels }}
                                </div>
                            </div>
                        </div>

                        <!-- Pagination -->
                        <div v-if="spells.last_page > 1" class="mt-6 flex justify-center">
                            <nav class="flex items-center gap-2">
                                <button
                                    v-if="spells.prev_page_url"
                                    @click="goToPage(spells.current_page - 1)"
                                    class="px-3 py-2 text-sm bg-white border border-gray-300 rounded-md hover:bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:bg-gray-600"
                                >
                                    Previous
                                </button>

                                <template v-for="page in visiblePages" :key="page">
                                    <button
                                        v-if="page !== '...'"
                                        @click="goToPage(page)"
                                        :class="[
                                            'px-3 py-2 text-sm border rounded-md',
                                            page === spells.current_page
                                                ? 'bg-indigo-600 text-white border-indigo-600'
                                                : 'bg-white border-gray-300 hover:bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:bg-gray-600'
                                        ]"
                                    >
                                        {{ page }}
                                    </button>
                                    <span v-else class="px-3 py-2 text-sm text-gray-500">...</span>
                                </template>

                                <button
                                    v-if="spells.next_page_url"
                                    @click="goToPage(spells.current_page + 1)"
                                    class="px-3 py-2 text-sm bg-white border border-gray-300 rounded-md hover:bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:bg-gray-600"
                                >
                                    Next
                                </button>
                            </nav>
                        </div>

                        <!-- Empty State -->
                        <div v-if="!loading && (!spells.data || spells.data.length === 0)" class="text-center py-12">
                            <div class="text-gray-500 dark:text-gray-400 text-lg">
                                No spells found matching your criteria.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, reactive, computed, onMounted } from 'vue'
import { Head } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import axios from 'axios'

// Reactive data
const loading = ref(false)
const searchQuery = ref('')
const sortBy = ref('name')
const perPage = ref(20)
const currentPage = ref(1)

const filters = reactive({
    level: '',
    school: '',
    class: '',
    concentration: '',
    ritual: ''
})

const filterOptions = reactive({
    levels: [],
    schools: [],
    classes: []
})

const spells = ref({
    data: [],
    current_page: 1,
    last_page: 1,
    per_page: 20,
    total: 0,
    from: 0,
    to: 0,
    prev_page_url: null,
    next_page_url: null
})

// Computed
const visiblePages = computed(() => {
    const current = spells.value.current_page
    const last = spells.value.last_page
    const pages = []
    
    // Always show first page
    if (current > 3) {
        pages.push(1)
        if (current > 4) pages.push('...')
    }
    
    // Show pages around current
    for (let i = Math.max(1, current - 2); i <= Math.min(last, current + 2); i++) {
        pages.push(i)
    }
    
    // Always show last page
    if (current < last - 2) {
        if (current < last - 3) pages.push('...')
        pages.push(last)
    }
    
    return pages
})

// Methods
const searchSpells = async () => {
    loading.value = true
    try {
        const params = {
            search: searchQuery.value,
            sort_by: sortBy.value,
            sort_direction: 'asc',
            per_page: perPage.value,
            page: currentPage.value,
            ...filters
        }

        // Remove empty filters
        Object.keys(params).forEach(key => {
            if (params[key] === '' || params[key] === null || params[key] === undefined) {
                delete params[key]
            }
        })

        const response = await axios.get('/dnd/spells', { params })
        spells.value = response.data
    } catch (error) {
        console.error('Error fetching spells:', error)
    } finally {
        loading.value = false
    }
}

const clearFilters = () => {
    searchQuery.value = ''
    filters.level = ''
    filters.school = ''
    filters.class = ''
    filters.concentration = ''
    filters.ritual = ''
    sortBy.value = 'name'
    currentPage.value = 1
    searchSpells()
}

const goToPage = (page) => {
    currentPage.value = page
    searchSpells()
}

const loadFilterOptions = async () => {
    try {
        const response = await axios.get('/dnd/spells/filter-options')
        filterOptions.levels = response.data.levels
        filterOptions.schools = response.data.schools
        filterOptions.classes = response.data.classes
    } catch (error) {
        console.error('Error loading filter options:', error)
    }
}

// Lifecycle
onMounted(() => {
    loadFilterOptions()
    searchSpells()
})
</script>