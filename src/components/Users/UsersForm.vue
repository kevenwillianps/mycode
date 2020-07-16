<template>

    <div>

        <div class="row">

            <div class="col-md-6 animate__animated animate__fadeIn">

                <h4>

                    <i class="far fa-folder-open mr-1"></i>Usuários/ <span class="badge badge-light">Formulário</span>

                </h4>

            </div>

            <div class="col-md-6 text-right animate__animated animate__fadeIn">

                <h4>

                    <router-link to="/users/datagrid" class="btn btn-default">

                        Listagem

                    </router-link>

                </h4>

            </div>

            <div class="col-md-12 animate__animated animate__fadeIn">

                <div class="card card-default shadow-sm">

                    <div class="card-body text-white">

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

                            <div class="btn btn btn-default" v-on:click="Save()">

                                Salvar

                            </div>

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

                axios.post('router.php?TABLE=USERS_FUNCTION&ACTION=USERS_FUNCTION_DATAGRID')

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