<template>

    <div>

        <nav class="navbar navbar-expand-lg navbar-light bg-default mb-0">

            <a class="navbar-brand" href="#">

                <i class="far fa-folder-open mr-1"></i>Usuários/ <span class="badge badge-primary">Formulário</span>

            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#method_navbar_header" aria-controls="method_navbar_header" aria-expanded="false" aria-label="Toggle navigation">

                <span class="navbar-toggler-icon"></span>

            </button>

            <div class="collapse navbar-collapse" id="method_navbar_header">

                <ul class="navbar-nav ml-auto">

                    <li class="nav-item">

                        <router-link to="/users/datagrid/" class="nav-link">

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

                        <label for="NomeDeUsuario" class="col-sm-2 col-form-label">Nome do Usuário</label>

                        <div class="col-sm-10">

                            <input type="text" class="form-control" id="NomeDeUsuario" v-model="inputs.name">

                        </div>

                    </div>

                    <div class="form-group row">

                        <label for="EmailDoUsuario" class="col-sm-2 col-form-label">Email do Usuário</label>

                        <div class="col-sm-10">

                            <input type="text" class="form-control" id="EmailDoUsuario" v-model="inputs.email">

                        </div>

                    </div>

                    <div class="form-group row">

                        <label for="SenhaDoUsuario" class="col-sm-2 col-form-label">Senha do Usuário</label>

                        <div class="col-sm-10">

                            <input type="password" class="form-control" id="SenhaDoUsuario" v-model="inputs.password">

                        </div>

                    </div>

                    <div class="form-group row">

                        <label for="Cargo" class="col-sm-2 col-form-label">Cargo</label>

                        <div class="col-sm-10">

                            <select id="Cargo" class="custom-select form-control" v-model="inputs.user_function_id">

                                <option v-bind:value="result.user_function_id" v-for="(result, index) in query.user_functions" v-bind:key="index">

                                    {{ result.name }}

                                </option>

                            </select>

                        </div>

                    </div>

                    <div class="form-group row">

                        <label for="Situation" class="col-sm-2 col-form-label">Situação</label>

                        <div class="col-sm-10">

                            <select id="Situation" class="custom-select form-control" v-model="inputs.situation_id">

                                <option v-bind:value="result.situation_id" v-for="(result, index) in query.situations" v-bind:key="index">

                                    {{ result.name }}

                                </option>

                            </select>

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

                    user_id : null,
                    user_function_id : null,
                    situation_id : null,
                    name : null,
                    email : null,
                    password : null,

                },

                query : {

                    user_functions : [],
                    situations : [],

                }

            }

        },

        methods : {

            Save(){

                axios.post('router.php?TABLE=USERS&ACTION=USERS_SAVE', {

                    inputs : this.inputs

                })

                    .then(response => {

                        this.$router.replace({name : 'users-datagrid'});
                        console.log('Sucesso -> ' + response.data);

                    })

                    .catch(response => {

                        console.log('Erro -> ' + response.data);

                    });

            },

            ListSituation(){

                axios.post('router.php?TABLE=SITUATIONS&ACTION=SITUATIONS_DATAGRID')

                    .then(response => {

                        this.query.situations = response.data.result;

                    })

                    .catch(response => {

                        console.log('Erro -> ' + response.data);

                    });

            },

            ListUserFunctions(){

                axios.post('router.php?TABLE=USER_FUNCTIONS&ACTION=USER_FUNCTIONS_DATAGRID')

                    .then(response => {

                        this.query.user_functions = response.data.result;

                    })

                    .catch(response => {

                        console.log('Erro -> ' + response.data);

                    });

            }

        },

        mounted(){

            this.ListSituation();
            this.ListUserFunctions();

        }

    }

</script>