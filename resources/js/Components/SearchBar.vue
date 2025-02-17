<template>
    <div class="relative">
        <form @submit.prevent="search">
            <div class="relative">
                <input
                    v-model="searchQuery"
                    type="text"
                    class="w-full bg-gray-800 text-neon-blue border-none rounded-full px-4 py-2 pl-10 focus:ring-2 focus:ring-neon-pink"
                    placeholder="Search the Network..."
                />
                <MagnifyingGlassIcon
                    class="absolute left-3 top-2.5 w-5 h-5 text-gray-400"
                />
            </div>
        </form>

        <!-- Search Suggestions -->
        <div
            v-if="showSuggestions && searchQuery"
            class="absolute w-full mt-2 bg-gray-900 rounded-lg border border-neon-pink shadow-lg z-50"
        >
            <div class="p-2 space-y-2">
                <button
                    v-for="suggestion in suggestions"
                    :key="suggestion"
                    @click="selectSuggestion(suggestion)"
                    class="w-full text-left px-3 py-2 rounded hover:bg-gray-800 text-neon-blue hover:text-neon-pink transition-colors"
                >
                    {{ suggestion }}
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from "vue";
import { router } from "@inertiajs/vue3";
import { MagnifyingGlassIcon } from "@heroicons/vue/24/solid";

const searchQuery = ref("");
const showSuggestions = ref(false);
const suggestions = ref([]);

watch(searchQuery, async (newQuery) => {
    if (newQuery.length > 2) {
        // Here you could implement real-time suggestions
        suggestions.value = [
            `Search for "${newQuery}"`,
            `#${newQuery}`,
            `@${newQuery}`,
        ];
        showSuggestions.value = true;
    } else {
        showSuggestions.value = false;
    }
});

const search = () => {
    if (searchQuery.value.trim()) {
        router.get(route("search"), { q: searchQuery.value });
        showSuggestions.value = false;
    }
};

const selectSuggestion = (suggestion) => {
    searchQuery.value = suggestion
        .replace(/^(Search for "|#|@)/, "")
        .replace('"', "");
    search();
};
</script>
