<template>
    <div class="mt-4">
        <InputLabel for="username" value="Username" />
        <div class="relative">
            <TextInput
                id="username"
                v-model="username"
                type="text"
                class="mt-1 block w-full"
                @input="checkUsername"
            />
            <div class="absolute right-2 top-1/2 transform -translate-y-1/2">
                <span v-if="checking" class="text-gray-400"> Checking... </span>
                <CheckCircleIcon
                    v-else-if="isAvailable"
                    class="w-5 h-5 text-neon-blue"
                />
                <XCircleIcon
                    v-else-if="errors.length"
                    class="w-5 h-5 text-neon-pink"
                />
            </div>
        </div>
        <div v-if="errors.length" class="mt-2 text-sm text-neon-pink">
            <p v-for="error in errors" :key="error">{{ error }}</p>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from "vue";
import { router } from "@inertiajs/vue3";
import { debounce } from "lodash";
import { CheckCircleIcon, XCircleIcon } from "@heroicons/vue/24/solid";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";

const props = defineProps({
    modelValue: String,
});

const emit = defineEmits(["update:modelValue"]);

const username = ref(props.modelValue);
const checking = ref(false);
const errors = ref([]);
const isAvailable = ref(false);

watch(username, (value) => {
    emit("update:modelValue", value);
});

const checkUsername = debounce(async () => {
    if (!username.value) return;

    checking.value = true;
    errors.value = [];
    isAvailable.value = false;

    try {
        const response = await router.post(
            route("username.check"),
            { username: username.value },
            { preserveState: true }
        );

        isAvailable.value = response.data.available;
        errors.value = response.data.errors;
    } catch (error) {
        errors.value = ["Error checking username availability"];
    } finally {
        checking.value = false;
    }
}, 300);
</script>
