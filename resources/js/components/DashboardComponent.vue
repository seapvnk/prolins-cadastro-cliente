<template>
    <div class="container card p-3 d-flex justify-content-center">
        <div class="row">
            <div class="col-md-12 col-md-offset-2">
                <div class="d-flex">
                    <h1 style="flex:1">Dashboard - 
                        <span class="text-primary"> {{ data.user.name }}</span>
                    </h1>

                    <router-link class="btn btn-outline-danger btn-sm" :to="{ name: 'logout' }">Logout</router-link>

                </div>


                <div class="panel panel-default">
                    <div v-if="data.user.profile.role == 2" class="panel-body">
                        <h2>Dados cadastrais</h2>

                        <ul class="list-group">
                            <li class="list-group-item">Nome: {{ data.user.name }}</li>
                            <li class="list-group-item">E-Mail: {{ data.user.email }}</li>
                            <li class="list-group-item">Logradouro: {{ data.costumer_data.address }}</li>
                            <li class="list-group-item">Número: {{ data.costumer_data.number }}</li>
                            <li class="list-group-item" v-if="data.costumer_data.complement">Complemento: {{ data.costumer_data.complement }}</li>
                            <li class="list-group-item">Cep: {{ data.costumer_data.zip }}</li>
                            <li class="list-group-item">Bairro: {{ data.costumer_data.district }}</li>
                            <li class="list-group-item">Estado: {{ data.costumer_data.state }}</li>
                        </ul>

                    </div>

                    <div v-ifw="data.user.profile.role == 1"  class="panel-body">
                        
                        <h4 @click="toggleMenu = !toggleMenu">
                            [+] 
                            Cadastrar novo usuário
                        </h4>
                        <form class="" v-show="toggleMenu" v-on:submit.prevent="submitNewUser">

                            <label for="inputNameUser" class="sr-only">Nome</label>
                            <input type="text" id="inputEmailUser" class="form-control mb-2" placeholder="nome do usuario" required autofocus v-model="n_user.name">

                            <label for="inputEmailUser" class="sr-only">E-mail</label>
                            <input type="email" id="inputEmailUser" class="form-control mb-2" placeholder="e-mail do usuario" required autofocus v-model="n_user.email">

                            <label for="inputPasswordUser" class="sr-only">Senha</label>
                            <input type="password" id="inputPasswordUser" class="form-control mb-2" placeholder="senha do usuario" required v-model="n_user.password">
                            
                            <label for="inputDescriptionUser" class="sr-only">Descrição</label>
                            <input type="text" id="inputEmailUser" class="form-control mb-2" placeholder="descrição da conta" autofocus v-model="n_user.description">

                            <button class="btn btn-primary" type="submit">cadastrar</button>
                        </form>

                        
                        <h2 class="mt-4">Usuários</h2>
                        <table class="table">
                            <tr>
                                <td>#</td>
                                <td>nome</td>
                                <td>@ e-mail</td>
                            </tr>

                            <tr v-for="user in data.users" :key="user.id">
                                <td>{{ user.id }}</td>
                                <td>{{ user.name }}</td>
                                <td>{{ user.email }}</td>
                            </tr>
                        </table>

                        <h2 class="mt-4">Clientes</h2>
                        <table class="table">
                            <tr>
                                <td>#</td>
                                <td>nome</td>
                                <td>@ e-mail</td>
                                <td>logradouro</td>
                                <td>número</td>
                                <td>complemento</td>
                                <td>CEP</td>
                                <td>Cidade</td>
                                <td>Estado</td>
                            </tr>

                            <tr v-for="costumer in data.costumers" :key="costumer.id">
                                <td>{{ costumer.id }}</td>
                                <td>{{ costumer.name }}</td>
                                <td>{{ costumer.email }}</td>
                                <td>{{ costumer.address }}</td>
                                <td>{{ costumer.number }}</td>
                                <td>{{ costumer.complement }}</td>
                                <td>{{ costumer.zip }}</td>
                                <td>{{ costumer.city }}</td>
                                <td>{{ costumer.state }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                data: '',
                toggleMenu: false,
                n_user: {
                    name: '',
                    password: '',
                    email: '',
                    description: '',
                }
            }
        },
        beforeMount() {
            axios.get('/api/dashboard', {
                headers: {
                    Authorization: 'Bearer ' + localStorage.getItem('token')
                }
            })
            .then(response => {
                this.data = response.data
                console.log(this.data)
            }).catch(error => {

            })
        },
        
        methods: {
            submitNewUser() {

                this.loginError = false;
                axios.post('/api/dashboard/create-user', {
                    ...this.n_user,
                    headers: {
                        Authorization: 'Bearer ' + localStorage.getItem('token')
                    }  
                })
                .then(response => {
                    console.log(response.status)
                    if (response.status === 'ok') {
                        this.n_user = {
                            name: '',
                            email: '',
                            password: '',
                            description: '',
                        }
                    }
                }).catch(error => {
                    this.loginError = true
                });

            }
        }
    }
</script>