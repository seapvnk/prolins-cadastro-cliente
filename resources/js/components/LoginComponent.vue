<template>
    <div class="card text-center form-wrapper">
        <div class="bg-light border-bottom p-2 card-title text-bold">Login</div>
        <form class="card-body form-signin w-50 m-auto" v-on:submit.prevent="submitLogin">
            <label for="inputEmail" class="sr-only">E-mail</label>
            <input type="email" id="inputEmail" class="form-control mb-2" placeholder="seu endereço de e-mail" required autofocus v-model="email">

            <label for="inputPassword" class="sr-only">Senha</label>
            <input type="password" id="inputPassword" class="form-control mb-2" placeholder="sua senha" required v-model="password">

            <button class="btn btn-primary btn-block" type="submit">Entrar</button>
            <span class="btn-link d-flex" v-on:click="forgoutMyPassword">Esqueci minha senha</span>
        </form>

    </div>
</template>

<script>
    import store from '../store'
    export default {
        data() {
            return {
                email: '',
                password: '',
                loginError: false,
            }
        },
        methods: {
            submitLogin() {
                this.loginError = false;
                axios.post('/api/auth/login', {
                    email: this.email,
                    password: this.password
                }).then(response => {
                    // login user, store the token and redirect to dashboard
                    store.commit('loginUser')
                    localStorage.setItem('token', response.data.access_token)
                    this.$router.push({ name: 'dashboard' })
                }).catch(error => {
                    this.loginError = true
                });
            },
            forgoutMyPassword() {
                this.loginError = false;

                if (!this.email) {
                    alert('insira o e-mail antes de solicitar a recuperação da senha')
                }

                axios.post('/api/recover-password', {
                    email: this.email,
                }).then(response => {
                    alert('um e-mail com o link de recuperação da senha foi enviando para seu e-mail')
                }).catch(error => {
                    this.loginError = true
                });
            }
        }
    }
</script>