import ProjectsDatagrid from './components/Projects/ProjectsDatagrid'
import ProjectsForm from './components/Projects/ProjectsForm'

import ClassesForm from './components/Classes/ClassesForm'
import ClassesDatagrid from './components/Classes/ClassesDatagrid'
import ClassesDetail from './components/Classes/ClassesDetail'

import MethodsForm from './components/Methods/MethodsForm'
import MethodsDatagrid from './components/Methods/MethodsDatagrid'
import MethodsDetail from './components/Methods/MethodsDetail'

import MethodsTemplateForm from './components/MethodsTemplates/MethodsTemplatesForm'
import MethodsTemplateDatagrid from './components/MethodsTemplates/MethodsTemplatesDatagrid'
import MethodsTemplateDetail from './components/MethodsTemplates/MethodsTemplatesDetail'

import UsersForm from './components/Users/UsersForm'
import UsersDatagrid from './components/Users/UsersDatagrid'

import UserFunctionsForm from './components/UserFunctions/UserFunctionsForm'
import UserFunctionsDatagrid from './components/UserFunctions/UserFunctionsDatagrid'

import SituationsForm from './components/Situations/SituationsForm'
import SituationsDatagrid from './components/Situations/SituationsDatagrid'

const routes = [

    {

        /** Página Inicial **/
        path: '/',
        component: ProjectsDatagrid,
        name: 'projects-datagrid',

    },

    {

        /** Página Inicial **/
        path: '/projects/form/:project_id',
        component: ProjectsForm,
        name: 'projects-form',

    },

    {

        /** Página Inicial **/
        path: '/classes/datagrid/:project_id',
        component: ClassesDatagrid,
        name: 'classes-datagrid',

    },

    {

        /** Página Inicial **/
        path: '/classes/detail',
        component: ClassesDetail,
        name: 'classes-detail',

    },

    {

        /** Página Inicial **/
        path: '/classes/form/:project_id/:class_id',
        component: ClassesForm,
        name: 'classes-form',

    },

    {

        /** Página Inicial **/
        path: '/methods/datagrid/:project_id/:class_id',
        component: MethodsDatagrid,
        name: 'methods-datagrid',

    },

    {

        /** Página Inicial **/
        path: '/methods/form/:project_id/:class_id/:method_id',
        component: MethodsForm,
        name: 'methods-form',

    },

    {

        /** Página Inicial **/
        path: '/methods/detail',
        component: MethodsDetail,
        name: 'methods-detail',

    },

    {

        /** Página Inicial **/
        path: '/methods/templates/datagrid',
        component: MethodsTemplateDatagrid,
        name: 'methods-templates-datagrid',

    },

    {

        /** Página Inicial **/
        path: '/methods/templates/form',
        component: MethodsTemplateForm,
        name: 'methods-templates-form',

    },

    {

        /** Página Inicial **/
        path: '/methods/templates/detail',
        component: MethodsTemplateDetail,
        name: 'methods-templates-detail',

    },

    {

        /** Página Inicial **/
        path: '/users/datagrid',
        component: UsersDatagrid,
        name: 'users-datagrid',

    },

    {

        /** Página Inicial **/
        path: '/users/form',
        component: UsersForm,
        name: 'users-form',

    },

    {

        /** Página Inicial **/
        path: '/user/functions/datagrid',
        component: UserFunctionsDatagrid,
        name: 'user-functions-datagrid',

    },

    {

        /** Página Inicial **/
        path: '/user/functions/form',
        component: UserFunctionsForm,
        name: 'user-functions-form',

    },

    {

        /** Página Inicial **/
        path: '/situations/datagrid',
        component: SituationsDatagrid,
        name: 'situations-datagrid',

    },

    {

        /** Página Inicial **/
        path: '/situations/form',
        component: SituationsForm,
        name: 'situations-form',

    },


];

export default routes;