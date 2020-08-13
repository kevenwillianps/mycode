<template>

    <div>

        <nav class="navbar navbar-expand-lg navbar-light bg-default mb-0">

            <a class="navbar-brand" href="#">

                <i class="far fa-folder-open mr-1"></i>Funções de Usuários/ <span class="badge badge-primary">Formulário</span>

            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#method_navbar_header" aria-controls="method_navbar_header" aria-expanded="false" aria-label="Toggle navigation">

                <span class="navbar-toggler-icon"></span>

            </button>

            <div class="collapse navbar-collapse" id="method_navbar_header">

                <ul class="navbar-nav ml-auto">

                    <li class="nav-item">

                        <router-link to="/user/functions/datagrid/" class="nav-link">

                            <i class="fas fa-bars mr-1"></i>Listagem

                        </router-link>

                    </li>

                </ul>

            </div>

        </nav>

        <div class="col-md-12 animate__animated animate__fadeIn mt-3">

            <div class="card card-default shadow-sm">

                <div class="card-body">

                    <div class="form-group row">

                        <label for="NomeDeUsuario" class="col-sm-2 col-form-label">Nome</label>

                        <div class="col-sm-10">

                            <input type="text" class="form-control" id="NomeDeUsuario" v-model="inputs.name">

                        </div>

                    </div>

                    <div class="form-group row">

                        <label for="EmailDoUsuario" class="col-sm-2 col-form-label">Descrição</label>

                        <div class="col-sm-10">

                            <input type="text" class="form-control" id="EmailDoUsuario" v-model="inputs.description">

                        </div>

                    </div>

                    <div class="form-group text-right">

                        <div class="btn btn btn-primary" v-on:click="Save()">

                            Salvar

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
    
</template>

<script type="text/ecmascript-6">

    import axios from 'axios';

    export default {

        /** Nome do componente atual **/
        name: "ClassesForm",

        data(){

            return{

                inputs : {

                    user_function_id : this.$route.params.user_function_id,
                    name : null,
                    description : null,
                    date_register : null,
                    date_update : null,

                },
            }

        },

        methods : {

            Save(){

                axios.post('router.php?TABLE=USER_FUNCTIONS&ACTION=USER_FUNCTIONS_SAVE', {

                    inputs : this.inputs

                })

                    .then(response => {

                        this.$router.replace({name : 'user-functions-datagrid'});
                        console.log('Sucesso -> ' + response.data);

                    })

                    .catch(response => {

                        console.log('Erro -> ' + response.data);

                    });

            },

            /** Método para editar o registro **/
            EditForm(){

                /** Envio de requisição **/
                axios.post('router.php?TABLE=USER_FUNCTIONS&ACTION=USER_FUNCTIONS_EDIT_FORM',{

                    inputs : this.inputs

                })

                /** Caso tenha sucesso **/
                    .then(response => {

                        this.inputs = response.data.result;

                    })

                    /** Caso tenha falha **/
                    .catch(response => {

                        console.log('Erro -> ' + response.data);

                    });

            },

        },

        mounted(){

            /** Verifico se é cadastro ou alteração **/
            if (this.$route.params.user_function_id > 0){

                this.EditForm();

            }

        }

    }

</script>