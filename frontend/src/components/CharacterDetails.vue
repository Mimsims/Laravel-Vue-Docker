<script lang="ts">
    import { ref, onMounted } from 'vue';
    import axios from 'axios';
    import { useRoute } from 'vue-router';
    import {apiUrl} from '../config.ts';

    export default {
        setup() {
            const character = ref({} as any);
            const id = ref(0);
            const route = useRoute();

            onMounted(() => {
                id.value = Number(route.params.id);
                axios.get(apiUrl + id.value)
                    .then(response => {
                        character.value = response.data;
                    })
                    .catch(error => {
                        console.error(`Error fetching character ${id.value}:`, error);
                    });
            });

            return {
                id,
                character
            };
        }
    }
</script>

<template>
    <div class="flex flex-col items-center gap-4 justify-center bg-gray-200 min-h-screen">
        <div class="text-6xl">
            {{ id }} - {{ character.name }} details:
        </div>
        <div class="w-6/12 bg-white shadow p-3 gap-2 items-center grid grid-cols-2">
                <div class="grid grid-cols-2">
                    <img :src="character.image" :alt="character.name">
                </div>
                <div class="grid grid-cols-2 text-2xl">
                    <div>Name:</div><div> {{ character.name }}</div>
                    <div>Status: </div><div> {{ character.status }}</div>
                    <div>Species:</div><div>{{ character.species }}</div>
                    <div>Gender:</div><div>{{ character.gender }}</div>
                    <div v-if="character.origin">Origin:</div><div v-if="character.origin">{{ character.origin.name }}</div>
                    <div v-if="character.episode">Times appeared:</div><div v-if="character.episode">{{ character.episode.length }}</div>
                    <router-link :to="'/'" class="text-blue-600 visited:text-purple-600">Back to characters list</router-link>
                </div>
        </div>
    </div>
</template>
