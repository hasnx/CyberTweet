<template>
    <div>
        <form @submit.prevent="submitPost">
            <div class="relative">
                <textarea
                    v-model="form.content"
                    class="w-full bg-gray-800 text-neon-blue border-none rounded p-3 focus:ring-2 focus:ring-neon-pink"
                    placeholder="What's happening in Night City?"
                    rows="4"
                    maxlength="280"
                ></textarea>
                <div
                    class="absolute bottom-3 right-3 flex items-center space-x-2"
                >
                    <div class="relative w-8 h-8">
                        <svg class="w-8 h-8 transform -rotate-90">
                            <circle
                                cx="16"
                                cy="16"
                                r="14"
                                stroke="currentColor"
                                stroke-width="2"
                                fill="none"
                                class="text-gray-700"
                            />
                            <circle
                                cx="16"
                                cy="16"
                                r="14"
                                stroke="currentColor"
                                stroke-width="2"
                                fill="none"
                                :stroke-dasharray="circumference"
                                :stroke-dashoffset="dashOffset"
                                class="text-neon-pink transition-all duration-200"
                            />
                        </svg>
                        <span
                            class="absolute inset-0 flex items-center justify-center text-xs text-neon-pink"
                        >
                            {{ 280 - form.content.length }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="flex justify-end mt-4">
                <button
                    type="submit"
                    class="bg-neon-pink hover:bg-neon-pink/80 text-black px-6 py-2 rounded-full font-bold transition-all duration-300 shadow-neon"
                >
                    UPLOAD TO NETWORK
                </button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { computed } from "vue";
import { useForm } from "@inertiajs/vue3";

const emit = defineEmits(["posted"]);

const form = useForm({
    content: "",
});

const circumference = computed(() => 2 * Math.PI * 14);
const dashOffset = computed(() => {
    const progress = form.content.length / 280;
    return circumference.value * (1 - progress);
});

const submitPost = () => {
    form.post(route("posts.store"), {
        onSuccess: () => {
            form.reset();
            emit("posted");
        },
    });
};
</script>
