<template>
    <div>
        <div v-if="loading_news" class="mx-auto text-center mt-5">
            <div class="spinner-border spinner-border-sm" role="status"><span class="sr-only">Loading...</span></div>
        </div>
        <noticia-component v-for="noticia in noticias"
            :key="noticia.noticia_id" @getNoticia="'getNoticia/'+id"
            :noticia="noticia"></noticia-component>
    </div>    
</template>

<script>
    export default {
        mounted() {
            this.getNoticias();
        },
        data() {
            return {
                loading_news: true,
                noticias: [],
            }
        },        
        methods: {
            getNoticias: function() {
                axios.get('/getNoticias').then(response => {
                    this.loading_news = false;
                    this.noticias = response.data.data;
                });
            },
        },
    }
</script>