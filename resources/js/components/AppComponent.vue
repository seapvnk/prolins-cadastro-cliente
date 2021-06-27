<template>
    <div>
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container-fluid">
                    <a class="navbar-brand" href="/"><img src="https://www.prolins.com.br/wp-content/uploads/2021/05/Logo-Prolins2.png"/></a>
            
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavDropdown">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                
                                <router-link :to="{ name: 'login' }">Entrar</router-link> 
                                <span class="text-light">|</span>
                                <router-link  :to="{ name: 'register' }">Registro de clientes</router-link>

                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

        <div class="container p-4">
            <router-view></router-view>
        </div>

    </div>
</template>

<script>
    import store from '../store'
    export default {
    
        created() {

            if(localStorage.token) {
                axios.get('/api/user', {
                    headers: {
                        Authorization: 'Bearer ' + localStorage.getItem('token')
                    }
                },
                ).then(response => {
                    store.commit('loginUser')
                }).catch(error => {
                    if (error.response.status === 401 || error.response.status === 403) {
                        store.commit('logoutUser')
                        localStorage.setItem('token', '')
                        this.$router.push({name: 'login'})
                    }

                });
            }

        }
    }
</script>