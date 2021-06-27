<template>
    <div class="card text-center form-wrapper">
        <div class="bg-light border-bottom p-2 card-title text-bold">Registro</div>
        <div v-if="hasError">
        
            <span class="text-danger"  v-for="error in errors" :key="error">
                {{ error }}
            </span>
                
        </div>
        <form class="card-body form-signin w-75 m-auto row" v-on:submit.prevent="submitRegister">
            <label for="inputName" class="sr-only">Nome</label>
            <input type="text" id="inputName" class="form-control mb-2 col-6" placeholder="seu nome" required autofocus v-model="name">

            <label for="inputEmail" class="sr-only">E-mail</label>
            <input type="email" id="inputEmail" class="form-control mb-2 col-6" placeholder="seu endereço de e-mail" required autofocus v-model="email">


            <label for="inputPassword" class="sr-only">Senha</label>
            <input type="password" id="inputPassword" class="form-control mb-2 col-6" placeholder="sua senha" required v-model="password">

            <label for="inputZip" class="sr-only">Cep</label>
            <input type="text" id="inputZip" class="form-control mb-2 col-6" placeholder="seu cep" required autofocus v-model="zip">

            <label for="inputAddr" class="sr-only">Endereço</label>
            <input type="text" id="inputAddress" class="form-control mb-2 col-6" placeholder="seu endereço" required autofocus v-model="address">

            <label for="inputNumber" class="sr-only">Número</label>
            <input type="text" id="inputNumber" class="form-control mb-2 col-6" placeholder="seu número" required autofocus v-model="number">

            <label for="inputComplement" class="sr-only">Complemento</label>
            <input type="text" id="inputComplement" class="form-control mb-2 col-6" placeholder="complemento do seu endereço" required autofocus v-model="complement">

            <label for="inputDistrict" class="sr-only">Bairro</label>
            <input type="text" id="inputDistrict" class="form-control mb-2 col-6" placeholder="nome do seu bairro" required autofocus v-model="district">

            <label for="inputCity" class="sr-only">City</label>
            <input type="text" id="inputCity" class="form-control mb-2 col-6" placeholder="nome da sua cidade" required autofocus v-model="city">
            
            <label for="inputState" class="sr-only">Estado</label>
            <select  id="inputState" class="form-control mb-2 col-6" placeholder="UF"  required autofocus v-model="state">
                <option value="">Selecione</option>
                <option value="AC">AC</option>
                <option value="AL">AL</option>
                <option value="AP">AP</option>
                <option value="AM">AM</option>
                <option value="BA">BA</option>
                <option value="CE">CE</option>
                <option value="DF">DF</option>
                <option value="ES">ES</option>
                <option value="GO">GO</option>
                <option value="MA">MA</option>
                <option value="MS">MS</option>
                <option value="MT">MT</option>
                <option value="MG">MG</option>
                <option value="PA">PA</option>
                <option value="PB">PB</option>
                <option value="PR">PR</option>
                <option value="PE">PE</option>
                <option value="PI">PI</option>
                <option value="RJ">RJ</option>
                <option value="RN">RN</option>
                <option value="RS">RS</option>
                <option value="RO">RO</option>
                <option value="RR">RR</option>
                <option value="SC">SC</option>
                <option value="SP">SP</option>
                <option value="SE">SE</option>
                <option value="TO">TO</option>
            </select>

            <button class="btn btn-primary btn-block" type="submit">Entrar</button>
        </form>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                name: '',
                email: '',
                password: '',
                address: '',
                number: '',
                complement: '',
                district: '',
                city: '',
                state: '',
                zip: '',
                hasError: false,
                errors: false
            }
        },
        methods: {
            submitRegister() {
                axios.post('/api/register', {
                    name: this.name,
                    email: this.email,
                    password: this.password,
                    address: this.address,
                    number: this.number,
                    complement: this.complement,
                    district: this.district,
                    city: this.city,
                    state: this.state,
                    zip: this.zip

                }).then(response => {
                    // login user, store the token and redirect to dashboard
                    this.$router.push({ name: 'login' })
                }).catch(e => {
                    this.hasError = true
                    this.errors = e.data
                    console.log(e.data)
                });
            }
        }
    }
</script>