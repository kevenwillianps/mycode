<template>

  <div id="app">

    <div v-if="session.user_name">

      <div class="wrapper">

        <nav id="sidebar" class="shadow-sm">

          <div class="sidebar-header text-center">

            <h3 class="mb-0">

              <i class="fas fa-meteor"></i>

            </h3>

          </div>

          <ul class="list-unstyled components text-center">

            <li>

              <router-link to="/">

                <i class="far fa-folder-open" title="Conteúdo"></i>

              </router-link>

            </li>

            <li>

              <router-link to="/methods/templates/datagrid">

                <i class="fas fa-code-branch"></i>

              </router-link>

            </li>

            <li class="active">

              <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">

                <i class="fas fa-cog"></i>

              </a>

              <ul class="collapse list-unstyled" id="homeSubmenu">

                <li>

                  <router-link to="/users/datagrid">

                    <i class="fas fa-users"></i>

                  </router-link>

                </li>

                <li>

                  <router-link to="/user/functions/datagrid">

                    <i class="fas fa-id-card"></i>

                  </router-link>

                </li>

                <li>

                  <router-link to="/situations/datagrid">

                    <i class="fas fa-check"></i>

                  </router-link>

                </li>

              </ul>

            </li>

          </ul>

          <ul class="list-unstyled CTAs text-center">

            <li>

              <a type="button" class="article" v-on:click="DestroySession()">

                <i class="fas fa-power-off"></i>

              </a>

            </li>

          </ul>

        </nav>

        <div id="content">

          <router-view></router-view>

        </div>

      </div>

    </div>

    <div v-else>

      <Login></Login>

    </div>

  </div>

</template>

<script type="text/ecmascript-6">

    /** Importação de componentes **/
    import axios from 'axios'
    import Login from './components/Geral/Login'

    export default {

        name: 'App',

        /** Declaração de componentes **/
        components: {

            Login,

        },

        data() {

            return {

                form: {

                    progress_bar: false,
                    show_form: false,

                },
                session: [],
            }

        },

        methods: {

            /** Encerro a sessão do usuário **/
            DestroySession() {

                /** Habilito minha barra de progresso **/
                this.form.progress_bar = true;

                axios.post('router.php?TABLE=USERS&ACTION=USERS_DESTROY_SESSION')

                    .then(response => {

                        location.reload();
                        console.log(response);

                    })

                    .catch(response => {

                        console.log(response.data)

                    });

            },

            /** Crio a sessão do usuário **/
            GetSession() {

                /** Habilito minha barra de progresso **/
                this.form.progress_bar = true;

                axios.post('router.php?TABLE=USERS&ACTION=USERS_GET_SESSION')

                    .then(response => {

                        /** Desabilito minha barra de progresso **/
                        this.session = response.data.result;
                        window.setTimeout(() => {

                            /** Habilito minha barra de progresso **/
                            this.form.progress_bar = false;

                        }, 1000);

                    })

                    .catch(response => {

                        console.log(response.data)

                    });

            },

        },

        /** Métodos executados quando o componente é montado **/
        mounted() {

            /** Método que inicia a sessão **/
            this.GetSession();

            /** Informo que o componente foi motando **/
            console.log('Componente "App", montado com sucesso')

        }

    }

</script>
