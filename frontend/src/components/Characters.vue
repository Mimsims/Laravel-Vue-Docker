<script>
    import axios from 'axios';
    import {apiUrl} from '../config.ts';

    function debounce(func, wait) {
        let timeout;
        return function () {
            const context = this;
            const args = arguments;
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                func.apply(context, args);
            }, wait);
        }
    }

    export default {
        data() {
            return {
                characters: [],
                pages: 1,
                page: 1
            }
        },

        methods: {

            handleScrollDebounced: debounce(function () {
                if (window.scrollY + window.innerHeight >= document.body.scrollHeight - 50 &&
                    this.page < this.pages) {                 
                        this.page++;
                        this.getCharacters();
                }
                }, 200),

            handleScroll() {
                this.handleScrollDebounced();
            },

            getCharacters() {
                axios.get(apiUrl, {
                    params: {
                        page: this.page
                        }
                    })
                    .then(response => {
                        if (this.page > 1) {
                            const new_characters = response.data.results;
                            this.characters = [...this.characters, ...new_characters];
                        }
                        else {
                            this.pages = response.data.info.api_pages;
                            this.characters = response.data.results;      
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching characters:', error);
                    });
            }

        },
       
        mounted() {
            window.addEventListener("scroll", this.handleScroll);
            this.getCharacters();
    },
};
</script>

<template>
    <div id="infinite-list" class="flex flex-col items-center gap-4 justify-center bg-gray-200" ref="scrollComponent">
        <div class="text-6xl">
            Rick and Morty Characters
        </div>
        <router-link :to="'/characters/' + character.id" v-for="character in characters" :key="character.id" class="w-6/12 bg-white shadow p-3 gap-2 items-center hover:shadow-lg transition delay-150 duration-300 ease-in-out hover:scale-105 transform">
            <div class="flex flex-col2 gap-4" >
                <img :src="character.image" :alt="character.name">
                <div>
                    <h2 class="text-4xl">
                        {{ character.id }} - {{ character.name }}
                    </h2>
                    <p class="text-black-600 font-semibold">{{ character.species }}</p>
                    <p> {{ character.status }}</p>
                </div>
            </div>
        </router-link>
    </div>
</template>
