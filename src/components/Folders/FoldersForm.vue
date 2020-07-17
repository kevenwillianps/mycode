<template>

    <div>

        <div class="row">

            <div class="col-md-6 animate__animated animate__fadeIn">

                <h4>

                    <i class="far fa-folder-open mr-1"></i>Pasta/ <span class="badge badge-light">Formulário</span>

                </h4>

            </div>

            <div class="col-md-6 text-right animate__animated animate__fadeIn">

                <h4>

                    <router-link to="/situations/datagrid" class="btn btn-default">

                        Listagem

                    </router-link>

                </h4>

            </div>

            <div class="col-md-12 animate__animated animate__fadeIn">

                <div class="card card-default shadow-sm">

                    <div class="card-body text-white">

                        <div class="form-group row">

                            <label for="NomeDeUsuario" class="col-sm-2 col-form-label">Nome</label>

                            <div class="col-sm-10">

                                <input type="text" class="form-control" id="NomeDeUsuario" v-model="inputs.name">

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

    /** Importação de componentes **/
    import axios from 'axios';

    export default {

        /** Nome do componente atual **/
        name: "FoldersForm",

        data(){

            return{

                inputs : {

                    folder_id : this.$route.params.folder_id,
                    project_id : this.$route.params.project_id,
                    name : null,
                    date_register : null,
                    date_update : null,

                },
            }

        },

        methods : {

            Save(){

                axios.post('router.php?TABLE=FOLDERS&ACTION=FOLDERS_SAVE', {

                    inputs : this.inputs

                })

                    .then(response => {

                        this.$router.replace({name : 'classes-datagrid', params : {project_id : this.inputs.project_id}});
                        console.log('Sucesso -> ' + response.data);

                    })

                    .catch(response => {

                        console.log('Erro -> ' + response.data);

                    });

            },

            /** Método para editar o registro **/
            EditForm(){

                /** Envio de requisição **/
                axios.post('router.php?TABLE=FOLDERS&ACTION=FOLDERS_EDIT_FORM',{

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
            if (this.$route.params.folder_id > 0){

                this.EditForm();

            }

            this.ListSituations();

        }

    }

</script>