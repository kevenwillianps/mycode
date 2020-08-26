<template>

    <div>

        <div class="container mt-3">

           <div class="mx-auto col-md-6 animate__animated animate__fadeIn">

               <div class="card shadow-sm mb-3 animate animate__fadeIn" v-if="form.progress_bar">

                   <div class="card-body">

                       <Progress percent="100"></Progress>

                   </div>

               </div>

               <div v-bind:class="'shadow-sm alert ' + alert.class" role="alert" v-if="alert.message">

                   <h4 class="alert-heading">

                       Atenção!

                   </h4>

                   <p>

                       Verificar as seguintes mensagens:

                   </p>

                   <hr>

                   <div>

                       <p class="mb-0" v-for="(message, index) in alert.message" v-bind:key="index">

                           {{ message }}

                       </p>

                   </div>

               </div>

               <div class="card card-default shadow-sm">

                   <div class="card-body">

                       <i class="fas fa-meteor" style="font-size: 2rem"></i>

                       <h5 class="card-title mt-2">

                           Tela de Login

                       </h5>

                       <h6 class="card-subtitle mb-2 text-muted">

                           Preencha os campos corretamente

                       </h6>

                       <div class="form-group">

                           <input type="email" class="form-control" placeholder="Email" v-model="inputs.email">

                       </div>

                       <div class="form-group">

                           <input type="password" class="form-control" placeholder="Senha" v-model="inputs.password" v-on:keydown.enter="Access()">

                       </div>

                       <div class="form-group">

                           <a type="button" class="btn btn-primary col-md-12 text-white" v-on:click="Access()">

                               Entrar

                           </a>

                       </div>

                   </div>

               </div>

           </div>

        </div>

    </div>

</template>

<script type="text/ecmascript-6">

    /** Importação de componentes **/
    import axios from 'axios'
    import Progress from '../Geral/Progress';

    export default {

        /** Nome do componente atual **/
        name: "Login",

        /** Declaração de componentes **/
        components: {

            Progress

        },

        data() {

            return {

                form: {

                    progress_bar: false,
                    class: null,
                    show_form: false,
                    progressBar: 0,

                },

                inputs: {

                    email: null,
                    password: null,

                },

                alert: {

                    class: null,
                    message: null,

                }

            }

        },

        methods: {

            Access() {

                /** Limpo o Alerta **/
                this.alert.message = null;

                /** Habilito minha barra de progresso **/
                this.form.progress_bar = true;

                axios.post('router.php?TABLE=USERS&ACTION=USERS_ACCESS', {
                    inputs: this.inputs
                })

                    .then(response => {

                        switch (response.data.cod) {

                            /** Usuário Localizado **/
                            case 1:

                                location.reload();
                                break;

                            /** Usuário Não Localizado **/
                            case 404:
                                this.alert.class = 'alert-warning';
                                this.alert.message = response.data.message;
                                /** Desabilito minha barra de progresso **/
                                this.form.progress_bar = false;
                                break;

                            /** Dados Não Preenchidos **/
                            case 405:
                                this.alert.class = 'alert-danger';
                                this.alert.message = response.data.message;
                                /** Desabilito minha barra de progresso **/
                                this.form.progress_bar = false;
                                break;

                        }

                    })

                    .catch(response => {

                        console.log(response.data)

                    });

            }

        },

        /** Métodos executados quando o componente for montado **/
        mounted() {

            /** Informo que o componente foi montado com sucesso **/
            console.log("Componente 'Login', montado com sucesso");

        },

    }

</script>