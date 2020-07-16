<template>

    <div>

        <div class="row">

            <div class="col-md-6 animate__animated animate__fadeIn">

                <h4>

                    <i class="far fa-folder-open mr-1"></i>Métodos/Template/ <span class="badge badge-light">Formulário</span>

                </h4>

            </div>

            <div class="col-md-6 text-right animate__animated animate__fadeIn">

                <h4>

                    <router-link to="/methods/templates/datagrid" class="btn btn-default">

                        Listagem

                    </router-link>

                </h4>

            </div>

            <div class="col-md-12 animate__animated animate__fadeIn">

                <div class="card card-default shadow-sm">

                    <div class="card-body text-white">

                        <div class="form-group row">

                            <label for="NomeDaClasses" class="col-sm-2 col-form-label">Nome do Método</label>

                            <div class="col-sm-10">

                                <input type="text" class="form-control" id="NomeDaClasses">

                            </div>

                        </div>

                        <div class="form-group row">

                            <label for="DescricaoDaClasses" class="col-sm-2 col-form-label">Descrição do Método</label>

                            <div class="col-sm-10">

                                <input type="password" class="form-control" id="DescricaoDaClasses">

                            </div>

                        </div>

                        <div class="form-group row">

                            <label for="VisibilidadeDoMetodo" class="col-sm-2 col-form-label">Visibilidade do Método</label>

                            <div class="col-sm-10">

                                <input type="password" class="form-control" id="VisibilidadeDoMetodo">

                            </div>

                        </div>

                        <hr>

                        <div class="row">

                            <div class="col-md-12">

                                <div class="form-group">

                                    <label for="CaminhoDoBancoDeDados" class="col-form-label">Código do Método</label>

                                    <textarea class="form-control" id="CaminhoDoBancoDeDados" rows="5"></textarea>

                                </div>

                            </div>

                        </div>

                        <div class="form-group text-right">

                            <div class="btn btn btn-default">

                                Salvar

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
    
</template>

<script>
    export default {
        name: "ClassesForm"
    }
</script>