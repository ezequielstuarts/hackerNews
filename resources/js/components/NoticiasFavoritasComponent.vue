<template>
    <div>
        <div v-if="loading_news" class="mx-auto text-center mt-5">
            <div class="spinner-border spinner-border-sm" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        
        <noticia-component v-for="noticia in noticias" :key="noticia.noticia_id" :noticia="noticia" :user_id="user_id" @getNoticiasFavoritas="getNoticiasFavoritas"></noticia-component>
    </div>    
</template>

<script>
    export default {
        mounted() {
            this.getNoticiasFavoritas();
        },
        data() {
            return {
                noticias: null,
                loading_news: true,
                user_id: null,
            }
        },
        methods: {
            getNoticiasFavoritas: function() {
                axios.get('/getFavoritasByUser').then(response => {
                    this.noticias = response.data.user.favoritas;
                    this.loading_news = false;
                });
            },
        },
    }
</script>
