<template>
<div>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title" v-text="noticia.title"></h5>
            <a v-bind:href="noticia.url" v-text="noticia.url" target="blank"></a>
            
            <div v-if="(noticia.fav)" class="text-right mt-3">
                <svg @click="toggleFavourite(noticia.noticia_id)" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart-fill cursor-pointer text-danger" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/></svg>
            </div>
            <div v-else class="text-right mt-3">
                <svg @click="toggleFavourite(noticia.noticia_id)" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart cursor-pointer" viewBox="0 0 16 16"><path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"/></svg>
            </div>
        </div>
    </div>
    
</div>    
</template>

<script>
    import toastr from 'toastr'
    export default {
        props: ['noticia'],
        data() {
            return {
                refresh: null,
            }
        },
        mounted() {
        },
        methods: {
            toggleFavourite(id) {
                axios.put('toggleFavourite/'+id).then(response => {
                    this.$emit('getNoticiasFavoritas');
                    // this.getNoticia(id);
                    if(response.data == 200) {
                        toastr.success('Noticia Agregada a favoritos');
                    } else if (response.data == 204) {
                        toastr.warning('Noticia Eliminada de favoritos');
                    } else {
                        toastr.error(response.data);
                    };
                }).catch(error => toastr.error('¡Sucedio algun error!'));
            },
            getNoticia(id) {                
                axios.get('/getNoticia/'+id).then(response => {
                    this.noticia = response.data.data;
                }).catch(error => toastr.error('¡Sucedio algun error!'));
            },            
        }
    }
</script>
